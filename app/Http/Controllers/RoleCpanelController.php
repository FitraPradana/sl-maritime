<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class RoleCpanelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = DB::connection('mysql')
                ->table('roles');

            // Tambahkan filter sesuai kebutuhan
            if ($request->role_name_filter != '') {
                $roles->where('roles.name', 'like', '%' . $request->role_name_filter . '%');
            }

            $roles->orderByDesc('roles.updated_at');
            $query = $roles->get();

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    return '
                <div class="form group" align="center">
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm" data-toggle="modal" data-target="#edit_role' . $data->id . '"><i class="fa fa-pencil"></i></a>
                    <button type="button" onclick="deleteData(`' . route('roles.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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

        return view('role.view');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
            ]);

            $role = Role::create([
                'name' => $request->input('name'),
                'guard_name' => 'web'
            ]);

            DB::commit();
            Alert::success('Add Role', 'Added Roles has been successfull !');
            return redirect('Roles')->with(['success' => 'Added Roles has been successfull !']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id)
    {
        $role = Role::find($id);
        $del = $role->delete();
        // Alert::success('Delete Role', 'Delete Roles has been successfull !');
        return response()->json([
            // "berhasil" => "Data Asset berhasil ditemukan",
        ]);
    }
}
