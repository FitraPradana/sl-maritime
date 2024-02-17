<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class UserHasRolesCpanelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userHasRoles = DB::connection('mysql')
                ->table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->select('users.*','roles.name as RolesName','model_has_roles.role_id');

            // Tambahkan filter sesuai kebutuhan
            if ($request->username_search != '') {
                $userHasRoles->where('users.name', 'like', '%'.$request->username_search.'%' );
            }
            if ($request->role_search != '') {
                $userHasRoles->where('roles.name',  'like', '%'.$request->role_search.'%' );
            }

            $userHasRoles->orderByDesc('users.updated_at');
            $query = $userHasRoles->get();


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
                ->addColumn('RolesName', function ($data) {
                    return $data->RolesName;
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

        $role = Role::all();
        $users = User::all();
        return view('user.userHasRoles.view', compact('role','users'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'user' => 'required',
                'role' => 'required',
            ]);

            $userHasRole = User::find($request->user);
            $userHasRole->assignRole($request->role);

            DB::commit();
            Alert::success('Add UserHasRoles', 'Added UserHasRoles has been successfull !');
            return redirect('UserHasRoles')->with(['success' => 'Added UserHasRoles has been successfull !']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
