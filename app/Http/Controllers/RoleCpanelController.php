<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RoleCpanelController extends Controller
{
    public function index()
    {
        return view('role.view');
    }

    public function json()
    {
        $role = DB::connection('mysql')
            ->table('roles')
            ->orderByDesc('roles.updated_at')
            ->get();

        return DataTables::of($role)
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

    public function role_has_permission()
    {
        return view('role.roleHasPermission.view');
    }

    public function role_has_permission_json()
    {
        $roleHasPermission = DB::connection('mysql')
            ->table('roles')
            ->join('role_has_permissions','roles.id','role_has_permissions.role_id')
            ->join('permissions','permissions.id','role_has_permissions.permission_id')
            ->select('roles.*','permissions.name as PermissionName')
            ->orderByDesc('roles.updated_at')
            ->get();

        return DataTables::of($roleHasPermission)
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
            ->addColumn('PermissionName', function ($data) {
                return $data->PermissionName;
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
