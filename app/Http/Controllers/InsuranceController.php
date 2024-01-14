<?php

namespace App\Http\Controllers;

use App\Models\SLMBroker;
use App\Models\SLMInsurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class InsuranceController extends Controller
{
    public function index()
    {
        $ins_type = DB::connection('sqlsrv2')->table('mst_insurance_type')->get();
        $ins_broker = DB::connection('sqlsrv2')->table('mst_insurance_broker')->get();
        $ins_insurer = DB::connection('sqlsrv2')->table('mst_insurance_insurer')->get();
        $company = DB::connection('sqlsrv2')->table('ms_nav_companies')->where('companycode', '!=', '---')->get();
        return view('insurance.view', compact('ins_type','ins_broker','ins_insurer','company'));
    }

    public function json()
    {
        $insurance = DB::connection('sqlsrv2')
            ->table('tran_insurance_header')
            ->leftJoin('mst_insurance_broker','tran_insurance_header.broker','mst_insurance_broker.brokercode')
            ->leftJoin('mst_insurance_insurer','mst_insurance_insurer.insurercode','tran_insurance_header.insurer')
            ->leftJoin('mst_insurance_type','mst_insurance_type.typecode','tran_insurance_header.insurancetype')
            // ->select('tran_insurance_header.*','mst_insurance_broker.*','mst_insurance_insurer.*')
            ->orderByDesc('tran_insurance_header.inceptiondate')
            ->get();

        return DataTables::of($insurance)
            ->addColumn('action', function ($data) {
                return '
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_insurance' . $data->id . '"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_insurance' . $data->id . '"><i class="fa fa-trash m-r-5"></i> Delete</a>
                        </div>
                </div>
                            ';
                // <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_department"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
            })
            ->addColumn('inceptiondate', function ($data) {
                return Carbon::parse($data->inceptiondate)->format('d M Y');
            })
            ->addColumn('expirydate', function ($data) {
                return Carbon::parse($data->expirydate)->format('d M Y');
            })
            ->addColumn('status', function ($data) {
                return $data->status;
            })
            // ->editColumn('status', function ($edit_status) {
            //     if ($edit_status->status == 'Not Valid') {
            //         return '<span class="badge bg-inverse-danger">NOT VALID</span>';
            //     } elseif ($edit_status->status == 'Progress') {
            //         return '<span class="badge bg-inverse-info">PROGRESS</span>';
            //     } elseif ($edit_status->status == 'Open') {
            //         return '<span class="badge bg-inverse-warning">OPEN</span>';
            //     } elseif ($edit_status->status == 'valid' OR $edit_status->status == 'Valid') {
            //         return '<span class="badge bg-inverse-success">VALID</span>';
            //     }
            // })
            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function form_add_renewal()
    {
        $ins_type = DB::connection('sqlsrv2')->table('mst_insurance_type')->get();
        $ins_broker = DB::connection('sqlsrv2')->table('mst_insurance_broker')->get();
        $ins_insurer = DB::connection('sqlsrv2')->table('mst_insurance_insurer')->get();
        $company = DB::connection('sqlsrv2')->table('ms_nav_companies')->where('companycode', '!=', '---')->get();
        return view('insurance.form_add', compact('ins_type','ins_broker','ins_insurer','company'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'policy_number'         => ['required'],
                'insurance_type'        => ['required'],
                'inception_date'        => ['required'],
                'expiry_date'           => ['required'],
                'status'                => ['required'],
                'entity'                => ['required'],
                'broker'                => ['required'],
                'insurer'               => ['required'],
                'fully_paid'            => ['required'],
                'total_amount'          => ['required','numeric'],
            ]);

            if ($validator->fails()) {
                return redirect('insurance/form_add_renewal')
                            ->withErrors($validator)
                            ->withInput();
            }

            // Renewal Insurance
            SLMInsurance::create([
                'policynumber'      => $request->policy_number,
                'oldtransnumber'    => '',
                'insurancetype'     => $request->insurance_type,
                'company'           => $request->entity,
                'inceptiondate'     => Carbon::createFromFormat('m/d/Y', $request->inception_date)->format('Y-m-d'),
                'expirydate'        => Carbon::createFromFormat('m/d/Y', $request->expiry_date)->format('Y-m-d'),
                'durations'         => '0',
                'broker'            => $request->broker,
                'insurer'           => $request->insurer,
                'status'            => $request->status,
                'fullypaid'         => $request->fully_paid,
                'remark'            => $request->remarks,
                // 'createat'          => now(),
                'createby'          => auth()->user()->name,
                // 'updateat'          => now(),
                'updateby'          => auth()->user()->name,
            ]);

            // Update Status Deposit
            // $member = Member::where('id', $request->member_id)->first();
            // $saldo_sebelum = $member->saldo_deposit;
            // $dataMember = [
            //     'saldo_deposit'        => $saldo_sebelum + $request->saldo_sebelumnya,
            // ];
            // Member::find($member->id)->update($dataMember);

            DB::commit();
            return redirect('insurance/renewal_monitoring')->with(['success' => 'Data Renewal Insurance berhasil di Tambahkan !']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return redirect('insurance/renewal_monitoring')->with(['error' => 'Data Renewal Insurance gagal di Tambahkan !']);
        }
    }

    public function saveBroker(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'brokercode' => 'required',
            'brokername' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Simpan data ke dalam database
        $SaveBroker = SLMBroker::create([
            'brokercode' => $request->input('brokercode'),
            'brokername' => $request->input('brokername'),
            'createat' => Carbon::now(),
            'createby' => auth()->user()->name,
            'updateat' => Carbon::now(),
            'updateby' => auth()->user()->name,
            // Tambahkan field lainnya sesuai kebutuhan
        ]);

        // Berikan respons
        return response()->json([
            "redirect" => url("insurance/form_add_renewal"),
            'message' => 'Data berhasil disimpan',
            'data' => $SaveBroker
        ]);
    }
}
