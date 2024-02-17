<?php

namespace App\Http\Controllers;

use App\Imports\MSTNavCompanyImport;
use App\Models\MSNavCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class MSTNavCompanyController extends Controller
{
    public function index()
    {
        $this->import_navcompany_auto();

        $navcompany = MSNavCompany::all();

        return view('MSTNavCompany.view', compact('navcompany'));
    }

    public function json()
    {
        $navcompany = DB::connection('mysql')
            ->table('ms_nav_companies')
            // ->orderByDesc('mst_insurance_broker.lastupdate')
            ->get();

        return DataTables::of($navcompany)
            ->addColumn('action', function ($data) {
                return '
                <div class="form group" align="center">
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm" data-toggle="modal" data-target="#edit_navcompany' . $data->id . '"><i class="fa fa-pencil"></i></a>
                    <button type="button" onclick="deleteData(`' . route('navcompany.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function import_navcompany_auto()
    {
        $navcompany = MSNavCompany::all();
        if ($navcompany->isEmpty()) {
            $path = public_path('document/Nav Company Import.xlsx');
            $import = (new MSTNavCompanyImport);
            $import->import($path);

            if ($import->failures()->isNotEmpty()) {
                return back()->withFailures($import->failures());
            }

            toast()->success('Import Data NAV COMPANY has been saved successfully!', 'Congrats');
            return redirect('NavCompany');
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'companycode' => 'required',
                'companyname' => 'required',
            ]);

            // Simpan data ke dalam database
            $SaveNavCompany = MSNavCompany::create([
                'companycode' => $request->input('companycode'),
                'companyname' => $request->input('companyname'),
                'companydescription' => $request->input('companydescription'),
                'createat' => Carbon::now(),
                'createby' => auth()->user()->name,
                'updateat' => Carbon::now(),
                'updateby' => auth()->user()->name,
            ]);

            DB::commit();
            Alert::success('Data berhasil disimpan');
            return redirect('NavCompany')->with(['success' => 'Data "'.$request->input('companycode').'" berhasil disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(Request $request, $id){
        try {
            $dataCompany = [
                'companycode' => $request->input('companycode'),
                'companyname' => $request->input('companyname'),
                'companydescription' => $request->input('companydescription'),
                'updateat' => Carbon::now(),
                'updateby' => auth()->user()->name,
            ];
            MSNavCompany::find($id)->update($dataCompany);

            DB::commit();
            Alert::success('Data berhasil di Update');
            return redirect('NavCompany')->with(['success' => 'Data "'.$request->input('companycode').'" berhasil di Update']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id)
    {
        $navcompany = MSNavCompany::find($id);

        $company = $navcompany->delete();
        return response()->json([
            // "berhasil" => "Data Asset berhasil ditemukan",
        ]);
    }
}
