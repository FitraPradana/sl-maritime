<?php

namespace App\Http\Controllers;

use App\Imports\MSTInsuranceInsurerImport;
use App\Models\MSTInsuranceInsurer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class MSTInsuranceInsurerController extends Controller
{
    public function index()
    {
        $this->import_insurer_auto();

        $ins_type = MSTInsuranceInsurer::all();

        return view('MSTInsuranceInsurer.view', compact('ins_type'));
    }

    public function json()
    {
        $employee = DB::connection('mysql')
            ->table('mst_insurance_insurer')
            // ->orderByDesc('mst_insurance_broker.lastupdate')
            ->get();

        return DataTables::of($employee)
            ->addColumn('action', function ($data) {
                return '
                <div class="form group" align="center">
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm" data-toggle="modal" data-target="#edit_insurer' . $data->id . '"><i class="fa fa-pencil"></i></a>
                    <button type="button" onclick="deleteData(`' . route('insurer.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function import_insurer_auto()
    {
        $insurer = MSTInsuranceInsurer::all();
        if ($insurer->isEmpty()) {
            $path = public_path('document/Insurer Import.xlsx');
            $import = (new MSTInsuranceInsurerImport);
            $import->import($path);

            if ($import->failures()->isNotEmpty()) {
                return back()->withFailures($import->failures());
            }

            toast()->success('Import Data INSURER has been saved successfully!', 'Congrats');
            return redirect('insurer');
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'insurercode' => 'required',
                'insurername' => 'required',
            ]);

            // Simpan data ke dalam database
            $SaveInsurer = MSTInsuranceInsurer::create([
                'insurercode' => $request->input('insurercode'),
                'insurername' => $request->input('insurername'),
                'createat' => Carbon::now(),
                'createby' => auth()->user()->name,
                'updateat' => Carbon::now(),
                'updateby' => auth()->user()->name,
            ]);

            DB::commit();
            Alert::success('Data berhasil disimpan');
            return redirect('Insurance/Insurer')->with(['success' => 'Data berhasil disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $dataType = [
                'insurercode' => $request->input('insurercode'),
                'insurername' => $request->input('insurername'),
            ];
            MSTInsuranceInsurer::find($id)->update($dataType);

            DB::commit();
            Alert::success('Data berhasil disimpan');
            return redirect('Insurance/Insurer')->with(['success' => 'Data berhasil disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }

    public function delete($id)
    {
        $insurer = MSTInsuranceInsurer::find($id);

        $ins = $insurer->delete();
        return response()->json([
            // "berhasil" => "Data Asset berhasil ditemukan",
        ]);
    }
}
