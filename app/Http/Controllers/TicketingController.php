<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TicketingController extends Controller
{
    public function index()
    {
        return view('ticketing.view');
    }

    public function json()
    {

        $ticketing = DB::connection('sqlsrv2')
                ->table('IT_HelpdeskTransaction')
                ->get();

        return DataTables::of($ticketing)
            ->addColumn('actions', function ($data) {
                return '
                <div class="form group" align="center">
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_employee' . $data->id . '"><i class="fa fa-pencil"></i></a>
                </div>
                ';
                // <button type="button" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
            })
            ->addColumn('InsertDate', function ($data) {
                return Carbon::parse($data->InsertDate)->format('d M Y H:i:s');
            })
            ->addColumn('UpdateDate', function ($data) {
                return Carbon::parse($data->UpdateDate)->format('d M Y H:i:s');
            })
            // ->addColumn('company', function ($data) {
            //     return $data->company;
            // })
            ->rawColumns(['actions','company'])
            ->make(true);
    }
}
