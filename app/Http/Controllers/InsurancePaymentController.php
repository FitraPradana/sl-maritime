<?php

namespace App\Http\Controllers;

use App\Models\TranInsurancePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class InsurancePaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $insurancePayment = DB::connection('mysql')
                ->table('tran_insurance_payment')
                ->join('mst_insurance_broker', 'tran_insurance_payment.broker', 'mst_insurance_broker.brokercode')
                ->join('mst_insurance_insurer', 'mst_insurance_insurer.insurercode', 'tran_insurance_payment.insurer')
                ->join('mst_insurance_type', 'mst_insurance_type.typecode', 'tran_insurance_payment.insurancetype')
                ->join('tran_insurance_header', 'tran_insurance_header.policynumber', 'tran_insurance_payment.policynumber')
                ->select(
                    'tran_insurance_payment.*',
                    'tran_insurance_payment.status as status_payment',
                    'mst_insurance_broker.brokercode',
                    'mst_insurance_broker.brokername',
                    'mst_insurance_insurer.insurercode',
                    'mst_insurance_insurer.insurername',
                    'mst_insurance_type.typecode',
                    'mst_insurance_type.typename',
                    'tran_insurance_header.policynumber',
                    DB::raw('DATE_SUB(duedate, INTERVAL 30 DAY) as date_before_30_days'),
                    DB::raw('DATE_SUB(duedate, INTERVAL 16 DAY) as date_before_16_days'),
                    DB::raw('DATE_SUB(duedate, INTERVAL 15 DAY) as date_before_15_days'),
                    DB::raw('DATE_SUB(duedate, INTERVAL 8 DAY) as date_before_8_days'),
                    DB::raw('DATE_SUB(duedate, INTERVAL 7 DAY) as date_before_7_days'),
                    DB::raw('DATE_ADD(duedate, INTERVAL 7 DAY) as date_after_7_days'),
                    DB::raw('CURDATE() as today')

                );

            // Tambahkan filter sesuai kebutuhan
            // if ($request->policynumber_filter != '') {
            //     $insurancePayment->where('tran_insurance_header.policynumber', 'like', '%' . $request->policynumber_filter . '%');
            // }

            $insurancePayment->orderByDesc('tran_insurance_header.policynumber');
            $query = $insurancePayment->get();

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    return '
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_insurance' . $data->id . '"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_insurance' . $data->id . '"><i class="fa fa-trash m-r-5"></i> Delete</a>
                        </div>

                        </div>
                        ';
                    // <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_insurance' . $data->id . '"><i class="fa fa-money m-r-5"></i> Delete</a>
                    // <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_department"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                })
                ->addColumn('duedate', function ($data) {
                    return Carbon::parse($data->duedate)->format('d M Y');
                })
                ->addColumn('remark_color', function ($data) {
                    $today = $data->today;
                    $date_before_30_days = Carbon::parse($data->date_before_30_days);
                    $date_before_15_days = Carbon::parse($data->date_before_15_days);
                    $date_before_7_days = Carbon::parse($data->date_before_7_days);
                    $date_after_7_days = Carbon::parse($data->date_after_7_days);
                    $dueDate = Carbon::parse($data->duedate);
                    $selisihHari = $dueDate->diffInDays($today);
                    $status_payment = $data->status_payment;
                    if ($today >= $date_before_30_days and $today < $date_before_15_days and $status_payment == 'pending') {
                        return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    ';
                    } elseif ($today >= $date_before_15_days and $today < $date_before_7_days and $status_payment == 'pending') {
                        return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    ';
                    } elseif ($today >= $date_before_7_days and $today < $date_after_7_days and $status_payment == 'pending') {
                        return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    ';
                    } elseif ($today >= $date_after_7_days and $status_payment == 'pending') {
                        return 'Expired lebih dari 7 hari';
                    }
                })
                ->editColumn('status', function ($edit_status) {
                    if ($edit_status->status == 'pending') {
                        return '<span class="badge bg-inverse-danger">PENDING</span>';
                    } elseif ($edit_status->status == 'success') {
                        return '<span class="badge bg-inverse-success">SUCCESS</span>';
                    }
                })
                ->addColumn('paymentdate', function ($paid) {
                    if ($paid->paymentdate == null AND $paid->status == 'pending') {
                        return '<a class="btn btn-info btn-sm" href="#" data-toggle="modal" data-target="#update_payment_date' . $paid->id . '"><i class="fa fa-money m-r-5"></i>PAID</a>';
                    } else {
                        return Carbon::parse($paid->paymentdate)->format('d M Y');
                    }
                })
                ->rawColumns(['action', 'remark_color', 'status', 'paymentdate'])
                ->make(true);
        }

        $insurancePayment = TranInsurancePayment::all();
        return view('insurance_payment.view', compact('insurancePayment'));
    }

    public function update_payment_date(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            //Update Payment Date
            $insurancePayment = TranInsurancePayment::where('id', $id)->first();
            $insurancePayment->update([
                'paymentdate'               => $request->payment_date,
                'status'                    => 'success',
            ]);

            DB::commit();
            // toast()->success('Data has been saved successfully!', 'Congrats');
            Alert::success('Payment Date', 'Payment date has been update successfull !!!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
