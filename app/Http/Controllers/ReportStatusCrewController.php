<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportStatusCrewController extends Controller
{
    function index(Request $request)
    {
        if(request()->ajax()) {

            if(!empty($request->from_date)) {

                $data = DB::connection('sqlsrv2')
                    ->table('users')
                    // ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->get();

            } else {

                $data = DB::table('users')
                    ->get();

            }

            return datatables()->of($data)->make(true);
        }

        return view('daterange');
    }
}
