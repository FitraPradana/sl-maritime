<?php

namespace App\Http\Controllers;

use App\Models\Permission as PermissionCpanel;
use App\Models\Role as RoleCpanel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleHasPermissionCpanelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roleHasPermission = DB::connection('mysql')
                ->table('roles')
                ->join('role_has_permissions', 'roles.id', 'role_has_permissions.role_id')
                ->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')
                ->select('roles.*', 'permissions.name as PermissionName');

            // Tambahkan filter sesuai kebutuhan
            if ($request->role_name_filter != '') {
                $roleHasPermission->where('roles.id', $request->role_name_filter);
            }
            if ($request->permission_name_filter != '') {
                $roleHasPermission->where('permissions.id', $request->permission_name_filter);
            }

            $roleHasPermission->orderByDesc('roles.updated_at');
            $query = $roleHasPermission->get();

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
        $permission = PermissionCpanel::all();
        $role = RoleCpanel::all();
        return view('role.roleHasPermission.view', compact('permission','role'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required',
                'permission' => 'required',
            ]);

            // $role = Role::create(['name' => $request->input('name')]);
            $role = Role::findByName($request->input('name'));
            // return $request->input('name');
            $role->givePermissionTo($request->input('permission'));

            DB::commit();
            Alert::success('RoleHasPermission "' . $request->name . '" berhasil di tambah ');
            return redirect('RoleHasPermission')->with(['success' => 'RoleHasPermission "' . $request->name . '" berhasil di tambah !']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
