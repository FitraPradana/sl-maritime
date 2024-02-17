<?php

namespace App\Http\Controllers;

use App\Imports\MSTInsuranceBrokerImport;
use App\Models\MSTInsuranceBroker;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class MSTInsuranceBrokerController extends Controller
{
    public function index()
    {
        $this->import_broker_auto();
        $broker = MSTInsuranceBroker::all();
        return view('broker.view', compact('broker'));
    }

    public function json()
    {
        $employee = DB::connection('mysql')
            ->table('mst_insurance_broker')
            // ->orderByDesc('mst_insurance_broker.lastupdate')
            ->get();

        return DataTables::of($employee)
            ->addColumn('action', function ($data) {
                return '
                <div class="form group" align="center">
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_broker' . $data->id . '"><i class="fa fa-pencil"></i></a>
                    <button type="button" onclick="deleteData(`' . route('broker.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'brokercode' => 'required',
                'brokername' => 'required',
            ]);

            // Simpan data ke dalam database
            $SaveBroker = MSTInsuranceBroker::create([
                'brokercode' => $request->input('brokercode'),
                'brokername' => $request->input('brokername'),
                'createat' => Carbon::now(),
                'createby' => auth()->user()->name,
                'updateat' => Carbon::now(),
                'updateby' => auth()->user()->name,
                // Tambahkan field lainnya sesuai kebutuhan
            ]);

            DB::commit();
            Alert::success('Data berhasil disimpan');
            return redirect('Insurance/Broker')->with(['success' => 'Data berhasil disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Update Data Bonus
            $dataBroker = [
                'brokercode' => $request->input('brokercode'),
                'brokername' => $request->input('brokername'),
            ];
            MSTInsuranceBroker::find($id)->update($dataBroker);

            DB::commit();
            Alert::success('Data berhasil disimpan');
            return redirect('Insurance/Broker')->with(['success' => 'Data berhasil disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function import_broker_auto()
    {
        $broker = MSTInsuranceBroker::all();
        if ($broker->isEmpty()) {
            $path = public_path('document/Broker Import.xlsx');
            $import = (new MSTInsuranceBrokerImport);
            $import->import($path);

            if ($import->failures()->isNotEmpty()) {
                return back()->withFailures($import->failures());
            }

            toast()->success('Import Data BROKER has been saved successfully!', 'Congrats');
            return redirect('broker');
        }
    }

    public function delete($id)
    {
        $broker = MSTInsuranceBroker::find($id);

        $brok = $broker->delete();
        return response()->json([
            // "berhasil" => "Data Asset berhasil ditemukan",
        ]);
    }
}
