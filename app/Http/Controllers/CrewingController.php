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
        return view('crewing.report.report');
    }

    public function crewing_report_json()
    {
        $report_crewing = DB::connection('sqlsrv2')
            ->table('DataPribadi')
            ->join('signon','DataPribadi.NOREC','signon.norec')
            ->join('vessel','DataPribadi.VESSELNO','vessel.vesselcode')
            ->select('DataPribadi.*','signon.tglweb','vessel.ops')
            // ->limit(5)
            ->orderByDesc('signon.tglweb')
            ->get();

        return DataTables::of($report_crewing)
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
