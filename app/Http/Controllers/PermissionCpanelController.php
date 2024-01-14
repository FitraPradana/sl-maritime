<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PermissionCpanelController extends Controller
{
    public function index()
    {
        return view('permission.view');
    }

    public function json()
    {
        $permission = DB::connection('mysql')
            ->table('permissions')
            ->orderByDesc('permissions.updated_at')
            ->get();

        return DataTables::of($permission)
        ->addColumn('action', function ($data) {
            return '
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_role' . $data->id . '"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_role' . $data->id . '"><i class="fa fa-trash m-r-5"></i> Delete</a>
                        </div>
                </div>
            ';
            })
            ->addColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d M Y H:i:s');
            })
            ->addColumn('updated_at', function ($data) {
                return Carbon::parse($data->updated_at)->format('d M Y H:i:s');
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
