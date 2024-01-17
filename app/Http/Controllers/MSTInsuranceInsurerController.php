<?php

namespace App\Http\Controllers;

use App\Imports\MSTInsuranceInsurerImport;
use App\Models\MSTInsuranceInsurer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MSTInsuranceInsurerController extends Controller
{
    public function index()
    {
        $this->import_insurer_auto();
        return view('MSTInsuranceInsurer.view');
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
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_employee' . $data->id . '"><i class="fa fa-pencil"></i></a>
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
}
