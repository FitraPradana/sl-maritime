<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
// use App\Http\Controllers\when

class UserController extends Controller
{
    //

    public function index(Request $request)
    {
        $user = User::all();
        $role = Role::all();
        return view('user.view', compact('user','role'));
    }

    public function json(Request $request)
    {



        // if ($request->isMethod('post')) {
        //     dd('is post method');
        // }

        // $user = DB::connection('sqlsrv')
        //     ->table('users')
        //     ->orderByDesc('updated_at')
        //     ->get();

        $user = collect(User::all());
        // $user->when($request->has('filter_name'), function ($q) use ($request) {
        //     $q->where('name','like', '%'.$request->filter_name.'%');
        // });

        // $user>when($request->filter_name, function ($query) use ($request) {
        //     return $query->where('name','like', '%'.$request->filter_name.'%');
        // });



        return DataTables::of($user)
            ->addColumn('checkbox', function ($data) {
                return '
                <input type="checkbox" name="cb-head"><br>
                ';
            })
            ->editColumn('name', function ($edit_name) {
                return '
                <h2 class="table-avatar">
                    <a href="#" class="avatar"><img src="'. asset('/') .'template_hrsm/assets/img/people.png" alt=""></a>
                    <a href="#">' . $edit_name->username . ' <span> ' . $edit_name->name . '</span></a>
                </h2>
            ';
            })
            ->addColumn('email', function ($data) {
                return $data->email;
            })
            ->addColumn('password', function ($data) {
                return $data->password;
            })
            ->addColumn('expired_date', function ($data) {
                return Carbon::parse($data->expired_date)->format('d M Y H:i:s');
            })
            ->addColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d M Y H:i:s');
            })
            ->addColumn('updated_at', function ($data) {
                return Carbon::parse($data->updated_at)->format('d M Y H:i:s');
            })
            ->editColumn('active_status', function ($edit_status) {
                if ($edit_status->active_status == 'active') {
                    return '<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                } elseif ($edit_status->active_status == 'non-active') {
                    return '<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Non Active</a>';
                }
            })
            ->addColumn('action', function ($data) {
                return '
                <div class="dropdown dropdown-action">
					<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Edit_user' . $data->id . '"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#change_password' . $data->id . '"><i class="fa fa-key m-r-5"></i> Change Password</a>
                        </div>
                </div>
                            ';
                // <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_department"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
            })
            ->rawColumns(['action','name','active_status','checkbox'])
            ->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Add User
            $userSave = User::create([
                'username'              => $request->username,
                'name'                  => $request->name,
                'email'                 => $request->email,
                'password'              => Hash::make($request->confirm_pasword),
                'active_status'         => 'active',
                // 'expired_date_password' => '-',
            ]);
            $userSave->assignRole($request->role);
            $lastInsertid_User = $userSave->id;


            DB::commit();
            return redirect('user')->with(['success' => 'Data User berhasil di Tambahkan !']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function changePassword(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Change Password User
            $user = User::find($id);
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            return redirect('user')->with(['success' => 'Password Updated Successfully !']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
