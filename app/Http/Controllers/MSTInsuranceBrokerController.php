<?php

namespace App\Http\Controllers;

use App\Imports\MSTInsuranceBrokerImport;
use App\Models\MSTInsuranceBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MSTInsuranceBrokerController extends Controller
{
    public function index()
    {
        $this->import_broker_auto();
        return view('broker.view');
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
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_employee' . $data->id . '"><i class="fa fa-pencil"></i></a>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        //
    }

    // public function import()
    // {
    //     $path = public_path('document/Broker Import.xlsx');

    //     $import = new BrokerImport();
    //     $import->import($path);

    //     if ($import->failures()->isNotEmpty()) {
    //         return back()->withFailures($import->failures());
    //     }

    //     toast()->success('Data has been saved successfully!', 'Congrats');
    //     return redirect('/insurance/renewal_monitoring')->with('success', 'Data Location Berhasil di Import AUTOMATIC!!!');
    // }

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
}
