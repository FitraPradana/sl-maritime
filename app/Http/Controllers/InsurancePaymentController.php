<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InsurancePaymentController extends Controller
{
    public function index()
    {
        return view('insurance_payment.view');
    }

    public function json()
    {
        $insurancePayment = DB::connection('mysql')
            ->table('tran_insurance_payment')
            ->leftJoin('mst_insurance_broker','tran_insurance_payment.broker','mst_insurance_broker.brokercode')
            ->leftJoin('mst_insurance_insurer','mst_insurance_insurer.insurercode','tran_insurance_payment.insurer')
            ->leftJoin('mst_insurance_type','mst_insurance_type.typecode','tran_insurance_payment.insurancetype')
            ->leftJoin('tran_insurance_header','tran_insurance_header.id','tran_insurance_payment.tran_insurance_header_id')
            ->orderByDesc('tran_insurance_payment.duedate')
            ->get();

        return DataTables::of($insurancePayment)
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
                $today = Carbon::now();
                $dueDate = Carbon::parse($data->duedate);
                $selisihHari = $dueDate->diffInDays($today);
                // $time = Carbon::now()->diff($data->duedate);
                // $dPrev60_date = date('Y-m-d', strtotime('-60 days', strtotime($today)));
                // $dPrev31_date = date('Y-m-d', strtotime('-31 days', strtotime($today)));
                // $dPrev30_date = date('Y-m-d', strtotime('-30 days', strtotime($today)));
                // $dPrev11_date = date('Y-m-d', strtotime('-11 days', strtotime($today)));
                // $dPrev10_date = date('Y-m-d', strtotime('-10 days', strtotime($today)));
                // $dNext10_date = date('Y-m-d', strtotime('+10 days', strtotime($today)));
                // return '-60Days:'.$dPrev60_date.', -31Days:'.$dPrev31_date.'';
                // return $selisihHari;
                if($selisihHari <= 60 AND $selisihHari >= 31){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    ';
                }
                elseif($selisihHari <= 30 AND $selisihHari >= 11){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    ';
                }
                elseif($selisihHari <= 10){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    ';
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
                if ($paid->paymentdate == null) {
                    return '<a class="btn btn-info btn-small" href="#" data-toggle="modal" data-target="#payment_date' . $paid->id . '"><i class="fa fa-money m-r-5"></i>PAID</a>';
                } else {
                    return Carbon::parse($paid->paymentdate)->format('d M Y');
                }
            })
            ->rawColumns(['action','remark_color','status','paymentdate'])
            ->make(true);
    }
}
