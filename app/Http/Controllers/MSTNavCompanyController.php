<?php

namespace App\Http\Controllers;

use App\Imports\MSTNavCompanyImport;
use App\Models\MSNavCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MSTNavCompanyController extends Controller
{
    public function index()
    {
        $this->import_navcompany_auto();
        return view('MSTNavCompany.view');
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
                    <a href="#" class="edit btn btn-xs btn-info btn-flat btn-sm editAsset" data-toggle="modal" data-target="#edit_employee' . $data->id . '"><i class="fa fa-pencil"></i></a>
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
}
