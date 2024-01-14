<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.view');
    }

    public function json()
    {
        $employee = DB::connection('sqlsrv2')
            ->table('employee')
            ->orderByDesc('employee.lastupdate')
            ->get();

        return DataTables::of($employee)
            ->addColumn('action', function ($data) {
                return '
                <div class="form group" align="center">
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_employee' . $data->id . '"><i class="fa fa-pencil"></i></a>
                </div>
                ';
                // <button type="button" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
            })
            // ->addColumn('lastupdate', function ($data) {
            //     return Carbon::parse($data->lastupdate)->format('d M Y H:i:s');
            // })
            // ->addColumn('expirydate', function ($data) {
            //     return Carbon::parse($data->expirydate)->format('d M Y H:i:s');
            // })
            ->rawColumns(['action'])
            ->make(true);
    }
}
