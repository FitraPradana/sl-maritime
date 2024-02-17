<?php

namespace App\Http\Controllers;

use App\Imports\MSTInsuranceTypeImport;
use App\Models\MSTInsuranceType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class MSTInsuranceTypeController extends Controller
{
    public function index()
    {
        $this->import_insurance_type_auto();

        $ins_type = MSTInsuranceType::all();

        return view('MSTInsuranceType.view', compact('ins_type'));
    }

    public function json()
    {
        $type = DB::connection('mysql')
            ->table('mst_insurance_type')
            // ->orderByDesc('mst_insurance_broker.lastupdate')
            ->get();

        return DataTables::of($type)
            ->addColumn('action', function ($data) {
                return '
                <div class="form group" align="center">
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_insurance_type' . $data->id . '"><i class="fa fa-pencil"></i></a>
                    <button type="button" onclick="deleteData(`' . route('insurance_type.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function import_insurance_type_auto()
    {
        $type = MSTInsuranceType::all();
        if ($type->isEmpty()) {
            $path = public_path('document/Insurance Type Import.xlsx');
            $import = (new MSTInsuranceTypeImport);
            $import->import($path);

            if ($import->failures()->isNotEmpty()) {
                return back()->withFailures($import->failures());
            }

            toast()->success('Import Data INSURANCE TYPE has been saved successfully!', 'Congrats');
            return redirect('Insurance/Type');
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'typecode' => 'required',
                'typename' => 'required',
            ]);

            // Simpan data ke dalam database
            $SaveBroker = MSTInsuranceType::create([
                'typecode' => $request->input('typecode'),
                'typename' => $request->input('typename'),
                'createat' => Carbon::now(),
                'createby' => auth()->user()->name,
                'updateat' => Carbon::now(),
                'updateby' => auth()->user()->name,
            ]);

            DB::commit();
            Alert::success('Data berhasil disimpan');
            return redirect('Insurance/Type')->with(['success' => 'Data berhasil disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Update Data Bonus
            $dataType = [
                'typecode' => $request->input('typecode'),
                'typename' => $request->input('typename'),
            ];
            MSTInsuranceType::find($id)->update($dataType);

            DB::commit();
            Alert::success('Data berhasil disimpan');
            return redirect('Insurance/Type')->with(['success' => 'Data berhasil disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id)
    {
        $type = MSTInsuranceType::find($id);

        $brok = $type->delete();
        return response()->json([
            // "berhasil" => "Data Asset berhasil ditemukan",
        ]);
    }
}
