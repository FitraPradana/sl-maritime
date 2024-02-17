<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UserHasPermissionCpanelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userHasPermission = DB::connection('mysql')
                ->table('users')
                ->join('model_has_permissions','users.id','model_has_permissions.model_id')
                ->join('permissions','model_has_permissions.permission_id','permissions.id')
                ->select('users.*','permissions.name as PermissionName','model_has_permissions.permission_id');

            // Tambahkan filter sesuai kebutuhan
            if ($request->username_search != '') {
                $userHasPermission->where('users.name', 'like', '%'.$request->username_search.'%' );
            }
            if ($request->role_search != '') {
                $userHasPermission->where('permissions.name',  'like', '%'.$request->permission_search.'%' );
            }

            $userHasPermission->orderByDesc('users.updated_at');
            $query = $userHasPermission->get();


            return DataTables::of($query)
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

        $permission = Permission::all();
        return view('user.userHasPermission.view', compact('permission'));
    }
}
