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
        $insurancePayment = DB::connection('sqlsrv2')
            ->table('tran_insurance_payment')
            ->leftJoin('mst_insurance_broker','tran_insurance_payment.broker','mst_insurance_broker.brokercode')
            ->leftJoin('mst_insurance_insurer','mst_insurance_insurer.insurercode','tran_insurance_payment.insurer')
            ->leftJoin('mst_insurance_type','mst_insurance_type.typecode','tran_insurance_payment.insurancetype')
            ->orderByDesc('tran_insurance_payment.createat')
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
                // <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_department"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
            })
            ->addColumn('duedate', function ($data) {
                return Carbon::parse($data->duedate)->format('d M Y');
            })
            ->addColumn('remark_color', function ($data) {
                return '
                <div class="progress progress-lg">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-lg">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-lg">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                ';
                // if($data->)
            })
            ->rawColumns(['action','remark_color'])
            ->make(true);
    }
}
