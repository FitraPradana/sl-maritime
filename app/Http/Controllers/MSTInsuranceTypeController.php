<?php

namespace App\Http\Controllers;

use App\Imports\MSTInsuranceTypeImport;
use App\Models\MSTInsuranceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MSTInsuranceTypeController extends Controller
{
    public function index()
    {
        $this->import_insurance_type_auto();
        return view('MSTInsuranceType.view');
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
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_employee' . $data->id . '"><i class="fa fa-pencil"></i></a>
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
}
