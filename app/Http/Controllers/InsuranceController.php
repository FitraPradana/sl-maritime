<?php

namespace App\Http\Controllers;

use App\Models\MSTInsuranceBroker;
use App\Models\SLMBroker;
use App\Models\SLMInsurance;
use App\Models\SLMInsurancePayment;
use App\Models\TranInsuranceHeader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class InsuranceController extends Controller
{
    public function PoliceInsuranceAuto()
    {
        $now = Carbon::now();
        $dateNow = $now->year . $now->month . $now->day;
        $cek = TranInsuranceHeader::count();
        if (
            $cek == 0
        ) {
            $urut = 10001;
            $nomer = 'P-INS/' . $now->year . '/' . $urut;
        } else {
            $ambil = TranInsuranceHeader::all()->last();
            $urut = (int)substr($ambil->policynumber, -5) + 1;
            $nomer = 'P-INS/' . $now->year . '/' . $urut;
        }

        return $nomer;
    }

    public function index()
    {
        $ins_type = DB::connection('mysql')->table('mst_insurance_type')->get();
        $ins_broker = DB::connection('mysql')->table('mst_insurance_broker')->get();
        $ins_insurer = DB::connection('mysql')->table('mst_insurance_insurer')->get();
        $company = DB::connection('mysql')->table('ms_nav_companies')->where('companycode', '!=', '---')->get();

        return view('insurance.view', compact('ins_type','ins_broker','ins_insurer','company'));
    }

    public function json()
    {
        $insurance = DB::connection('mysql')
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
            // ->addColumn('status', function ($data) {
            //     return $data->status;
            // })
            ->editColumn('status', function ($edit_status) {
                if ($edit_status->status == 'not_active') {
                    return '<span class="badge bg-inverse-danger">NOT ACTIVE</span>';
                } elseif ($edit_status->status == 'need_action') {
                    return '<a href="#">NEED ACTION</a>';
                    // return '<a href="#"><span class="badge bg-inverse-info">NEED ACTION</span></a>';
                    // return '<span class="badge bg-inverse-info">NEED ACTION</span>';
                } elseif ($edit_status->status == 'expired') {
                    return '<span class="badge bg-inverse-warning">EXPIRED</span>';
                } elseif ($edit_status->status == 'active') {
                    return '<span class="badge bg-inverse-success">ACTIVE</span>';
                }
            })
            ->addColumn('remark_color', function ($data) {
                $today = Carbon::now();
                $dueDate = Carbon::parse($data->expirydate);
                $selisihHari = $dueDate->diffInDays($today);
                if($selisihHari <= 60 AND $selisihHari >= 31){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    ';
                }
                elseif($selisihHari <= 30 AND $selisihHari >= 11){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    ';
                }
                elseif($selisihHari <= 10){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    ';
                }
            })
            ->rawColumns(['action','status','remark_color'])
            ->make(true);
    }

    public function form_add_renewal()
    {
        $ins_type = DB::connection('mysql')->table('mst_insurance_type')->get();
        $ins_broker = DB::connection('mysql')->table('mst_insurance_broker')->get();
        $ins_insurer = DB::connection('mysql')->table('mst_insurance_insurer')->get();
        $company = DB::connection('mysql')->table('ms_nav_companies')->where('companycode', '!=', '---')->get();
        $PoliceInsuranceAuto = $this->PoliceInsuranceAuto();
        return view('insurance.form_add', compact('ins_type','ins_broker','ins_insurer','company','PoliceInsuranceAuto'));
    }

    public function store(Request $request)
    {
        // $installment = collect($request->installment);
        // // $count = count($request->installment);
        // return $installment;


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
                'line_amount'           => ['required'],
                // 'total_amount'          => ['required','numeric'],
            ]);


            if ($validator->fails()) {
                return redirect('insurance/form_add_renewal')
                            ->withErrors($validator)
                            ->withInput();
            }

            // Renewal Insurance
            $SLMInsurance = SLMInsurance::create([
                'policynumber'      => $request->policy_number,
                'oldtransnumber'    => '',
                'insurancetype'     => $request->insurance_type,
                'company'           => $request->entity,
                // 'inceptiondate'     => Carbon::createFromFormat('m/d/Y', $request->inception_date)->format('Y-m-d'),
                'inceptiondate'     => $request->inception_date,
                'expirydate'        => $request->expiry_date,
                'durations'         => '0',
                'broker'            => $request->broker,
                'insurer'           => $request->insurer,
                'status'            => $request->status,
                'fullypaid'         => $request->fully_paid,
                'remark'            => $request->remarks,
                'createat'          => Carbon::now(),
                'createby'          => auth()->user()->name,
                'updateat'          => Carbon::now(),
                'updateby'          => auth()->user()->name,
            ]);
            $lastInsertid_Insurance = $SLMInsurance->id;

            if($request->fully_paid == "no"){
                for ($i=0; $i < count($request->installment); $i++) {
                    SLMInsurancePayment::create([
                        'tran_insurance_header_id'  => $lastInsertid_Insurance,
                        'insurancetype'             => $request->insurance_type,
                        'company'                   => $request->entity,
                        'broker'                    => $request->broker,
                        'insurer'                   => $request->insurer,
                        'installment_ke'            => $request->installment[$i],
                        'amount'                    => $request->line_amount[$i],
                        'total_amount'              => $request->line_amount[$i],
                        'duedate'                   => $request->duedate[$i],
                        'durations'                 => '0',
                        'status'                    => 'pending',
                        'status_payment'            => 'pending',
                        'remark'                    => $request->remarks,
                        'createat'                  => Carbon::now(),
                        'createby'                  => auth()->user()->name,
                        'updateat'                  => Carbon::now(),
                        'updateby'                  => auth()->user()->name,
                    ]);
                }

            }

            if($request->fully_paid == "yes"){
                for ($i=0; $i < count($request->installment); $i++) {
                    SLMInsurancePayment::create([
                        'tran_insurance_header_id'  => $lastInsertid_Insurance,
                        'insurancetype'             => $request->insurance_type,
                        'company'                   => $request->entity,
                        'broker'                    => $request->broker,
                        'insurer'                   => $request->insurer,
                        'installment_ke'            => 'Fully Paid',
                        // 'duedate'                   => Carbon::createFromFormat('m/d/Y', $request->expiry_date)->format('Y-m-d'),
                        'amount'                    => $request->line_amount[$i],
                        'total_amount'              => $request->line_amount[$i],
                        'duedate'                   => $request->duedate[$i],
                        'durations'                 => '0',
                        'status'                    => 'pending',
                        'status_payment'            => 'pending',
                        'remark'                    => $request->remarks,
                        'createat'                  => Carbon::now(),
                        'createby'                  => auth()->user()->name,
                        'updateat'                  => Carbon::now(),
                        'updateby'                  => auth()->user()->name,
                    ]);
                }
            }

            // Update Status Deposit
            // $member = Member::where('id', $request->member_id)->first();
            // $saldo_sebelum = $member->saldo_deposit;
            // $dataMember = [
            //     'saldo_deposit'        => $saldo_sebelum + $request->saldo_sebelumnya,
            // ];
            // Member::find($member->id)->update($dataMember);

            DB::commit();
            // Alert::success('Success', 'Data Renewal insurance telah ditambahkan');
            toast()->success('Data has been saved successfully!', 'Congrats');
            // return redirect()->back();
            return redirect('insurance/renewal_monitoring')->with('success', 'Data Renewal Insurance "'.$request->policy_number.'" berhasil di Tambahkan !');
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
        $SaveBroker = MSTInsuranceBroker::create([
            'brokercode' => $request->input('brokercode'),
            'brokername' => $request->input('brokername'),
            'createat' => Carbon::now(),
            'createby' => auth()->user()->name,
            'updateat' => Carbon::now(),
            'updateby' => auth()->user()->name,
            // Tambahkan field lainnya sesuai kebutuhan
        ]);

        // toast()->success('Data has been saved successfully!', 'Congrats');
        // return redirect()->back();

        // Berikan respons
        return response()->json([
            "redirect" => url("insurance/form_add_renewal"),
            'message' => 'Data berhasil disimpan',
            'data' => $SaveBroker
        ]);
    }
}
