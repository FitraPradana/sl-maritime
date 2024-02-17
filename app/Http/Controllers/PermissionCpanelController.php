<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PermissionCpanelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = DB::connection('mysql')
                ->table('permissions');

            // Tambahkan filter sesuai kebutuhan
            if ($request->permission_name_filter != '') {
                $permissions->where('permissions.name', 'like', '%' . $request->permission_name_filter . '%');
            }

            $permissions->orderByDesc('permissions.updated_at');
            $query = $permissions->get();

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="form group" align="center">
                        <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm" data-toggle="modal" data-target="#edit_role' . $data->id . '"><i class="fa fa-pencil"></i></a>
                    </div>
                    ';
                        // <button type="button" onclick="deleteData(`' . route('roles.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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

        return view('permission.view');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required|unique:permissions,name',
            ]);

            $role = Permission::create([
                'name' => $request->input('name'),
                'guard_name' => 'web'
            ]);

            DB::commit();
            Alert::success('Add Role', 'Added Permissions has been successfull !');
            return redirect('Permissions')->with(['success' => 'Added Permissions has been successfull !']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
