<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TicketingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ticketing = DB::connection('sqlsrv2')
                ->table('IT_HelpdeskTransaction')
                ->orderBy('TicketDate', 'desc');
                // ->get();

            // Tambahkan filter sesuai kebutuhan
            $fromDate = Carbon::parse($request->from_date)->format('d/m/Y');
            $toDate = Carbon::parse($request->to_date)->format('d/m/Y');
            if ($request->from_date != '' && $request->to_date != '') {
                if($toDate < $fromDate){
                    // return redire
                };
                $ticketing->whereBetween('TicketDate', [$fromDate, $toDate]);
            }

            // if ($request->has('category')) {
            //     $query->where('categories.name', $request->category);
            // }

            $query = $ticketing->get();

            return DataTables::of($query)
                ->addColumn('actions', function ($data) {
                    return '
                    <div class="form group" align="center">
                        <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_employee' . $data->id . '"><i class="fa fa-pencil"></i></a>
                    </div>
                    ';
                    // <button type="button" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                })
                ->addColumn('TicketDate', function ($data) {
                    return Carbon::parse($data->TicketDate)->format('d M Y');
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


        return view('ticketing.view');
    }
}
