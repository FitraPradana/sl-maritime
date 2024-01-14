<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CrewingController extends Controller
{
    public function crewing_report()
    {
        return view('crewing.report');
    }

    public function crewing_report_json()
    {
        $report_crewing = DB::connection('sqlsrv2')
            ->table('DataPribadi')
            ->leftJoin('signon','DataPribadi.NOREC','signon.norec')
            ->leftJoin('vessel','DataPribadi.VESSELNO','vessel.vesselcode')
            // ->select('tran_insurance_header.*','mst_insurance_broker.*','mst_insurance_insurer.*')
            ->orderByDesc('signon.tglweb')
            ->get();

        return DataTables::of($report_crewing)
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
            // ->addColumn('inceptiondate', function ($data) {
            //     return Carbon::parse($data->inceptiondate)->format('d M Y');
            // })
            // ->addColumn('expirydate', function ($data) {
            //     return Carbon::parse($data->expirydate)->format('d M Y');
            // })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
