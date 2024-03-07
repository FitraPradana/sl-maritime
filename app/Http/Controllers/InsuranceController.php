<?php

namespace App\Http\Controllers;

use App\Models\MSTInsuranceBroker;
use App\Models\SLMBroker;
use App\Models\SLMInsurance;
use App\Models\SLMInsurancePayment;
use App\Models\TranInsuranceHeader;
use App\Models\TranInsurancePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

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
            $nomer = 'P-INS-' . $now->year . '-' . $urut;
        } else {
            $ambil = TranInsuranceHeader::orderBy('tran_insurance_header_id', 'desc')->first();
            $urut = (int)substr($ambil->tran_insurance_header_id, -5) + 1;
            $nomer = 'P-INS-' . $now->year . '-' . $urut;
        }
        return $nomer;
    }

    public function IdAuto()
    {

        $cek = TranInsuranceHeader::count();
        if (
            $cek == 0
        ) {
            $urut = 1;
            $nomer = $urut;
        } else {
            $ambil = TranInsuranceHeader::all()->last();
            $urut = (int)substr($ambil->id, -1) + 1;
            $nomer = $urut;
        }

        return $nomer;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $insurance = DB::connection('mysql')
                ->table('tran_insurance_header')
                ->leftJoin('mst_insurance_broker','tran_insurance_header.broker','=','mst_insurance_broker.brokercode')
                ->leftJoin('mst_insurance_insurer','mst_insurance_insurer.insurercode','=', 'tran_insurance_header.insurer')
                ->leftJoin('mst_insurance_type','mst_insurance_type.typecode','=','tran_insurance_header.insurancetype')
                ->select('tran_insurance_header.*','tran_insurance_header.id as IdTranInsHeader','mst_insurance_broker.brokercode','mst_insurance_broker.brokername','mst_insurance_insurer.insurercode','mst_insurance_insurer.insurername','mst_insurance_type.typecode','mst_insurance_type.typename','tran_insurance_header.policynumber',
                DB::raw('DATE_SUB(expirydate, INTERVAL 60 DAY) as date_before_60_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 31 DAY) as date_before_31_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 11 DAY) as date_before_11_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 10 DAY) as date_before_10_days'),
                DB::raw('DATE_ADD(expirydate, INTERVAL 10 DAY) as date_after_10_days'),
                DB::raw('CURDATE() as today')
                );

            // Tambahkan filter sesuai kebutuhan
            if ($request->policynumber_filter != '') {
                $insurance->where('tran_insurance_header.policynumber', 'like', '%' . $request->policynumber_filter . '%');
            }
            if ($request->ins_type_filter != '') {
                $insurance->where('tran_insurance_header.insurancetype', $request->ins_type_filter);
            }
            if ($request->company_filter != '') {
                $insurance->where('tran_insurance_header.company', $request->company_filter);
            }
            if ($request->broker_filter != '') {
                $insurance->where('tran_insurance_header.broker', $request->broker_filter);
            }
            if ($request->insurer_filter != '') {
                $insurance->where('tran_insurance_header.insurer', $request->insurer_filter);
            }
            if ($request->status_filter != '') {
                $insurance->where('tran_insurance_header.status', $request->status_filter);
            }
            // if ($request->flag_filter != '') {
            //     if($request->flag_filter == 'green'){
            //         foreach ($insurance as $item) {
            //             $insurance
            //                 ->where('date_before_60_days', '<=', $item->today)
            //                 ->where('date_before_30_days', '>', $item->today);
            //         }
            //         // $insurance->whereBetween('today', ['date_before_60_days, date_before_30_days']);
            //             // ->where('today', '<', DB::raw('DATE_SUB(expirydate, INTERVAL 30 DAY) as date_before_30_days'));
            //     }
            //     elseif($request->flag_filter == 'yellow'){
            //         $insurance->whereBetween('today', ['date_before_30_days, date_before_11_days']);
            //     }
            //     elseif($request->flag_filter == 'red'){
            //         $insurance->whereBetween('today', ['date_before_10_days, date_after_10_days']);
            //     }
            // }

            // Tambahkan pengurutan descending berdasarkan kolom tertentu
            // $insurance->orderBy('tran_insurance_header.policynumber', 'desc');
            $insurance->orderByDesc('tran_insurance_header.tran_insurance_header_id');
            // dd($insurance->toSql());
            $query = $insurance->get();

            return DataTables::of($query)
            ->addColumn('action', function ($data) {
                $countId = DB::connection('mysql')->table('tran_insurance_header')->where('id', $data->id)->count();

                if ($data->status == 'active' AND $countId == 1) {
                    return '
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="'.route('insurance.edit', $data->tran_insurance_header_id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_insurance' . $data->tran_insurance_header_id . '"><i class="fa fa-trash m-r-5"></i> Delete</a>
                            </div>
                    </div>';
                } elseif ($data->status == 'need_action') {
                    return '
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_insurance' . $data->tran_insurance_header_id . '"><i class="fa fa-trash m-r-5"></i> Delete</a>
                            </div>
                    </div>';
                } else {
                    return '';
                }

                // <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_department"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
            })
            ->addColumn('tran_insurance_header_id', function ($data) {
                // if($data->status != 'need_action'){
                //     return '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#detail_police' . $data->tran_insurance_header_id . '"><u>'.$data->tran_insurance_header_id.'</u></a>
                //     ';
                // } else {
                //     return $data->tran_insurance_header_id;
                // }

                return '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#detail_police' . $data->tran_insurance_header_id . '"><u>'.$data->tran_insurance_header_id.'</u></a>
                    ';
            })
            ->addColumn('date_before_60_days', function ($data) {
                return Carbon::parse($data->date_before_60_days)->format('d M Y');
            })
            ->addColumn('selisihDays', function ($data) {
                $dueDate = Carbon::parse($data->expirydate);
                $today = Carbon::now();
                return $dueDate->diffInDays($today);
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
                    return '<span class="badge bg-inverse-secondary">NOT ACTIVE</span>';
                } elseif ($edit_status->status == 'need_action') {
                    // return '<a href="#">NEED ACTION</a>';
                    return '<a class="btn btn-info btn-sm btn-need-action" href="'.route('insurance.form_need_action', $edit_status->tran_insurance_header_id).'">NEED ACTION</a>';
                    // return '<a href="#"><span class="badge bg-inverse-info">NEED ACTION</span></a>';
                    // return '<span class="badge bg-inverse-info">NEED ACTION</span>';
                } elseif ($edit_status->status == 'expired') {
                    return '<span class="badge bg-inverse-danger">EXPIRED</span>';
                } elseif ($edit_status->status == 'active') {
                    return '<span class="badge bg-inverse-success">ACTIVE</span>';
                } elseif ($edit_status->status == 'existing') {
                    return '<span class="badge bg-inverse-warning">EXISTING POLICY</span>';
                }
            })
            ->addColumn('remark_color', function ($data) {
                $today = $data->today;
                $date_before_60_days = Carbon::parse($data->date_before_60_days);
                $date_before_31_days = Carbon::parse($data->date_before_31_days);
                $date_before_30_days = Carbon::parse($data->date_before_30_days);
                $date_before_10_days = Carbon::parse($data->date_before_10_days);
                $date_after_10_days = Carbon::parse($data->date_after_10_days);
                $dueDate = Carbon::parse($data->expirydate);
                $selisihHari = $dueDate->diffInDays($today);
                $status = $data->status;
                if($today >= $date_before_60_days AND $today < $date_before_30_days AND ($status != 'not_active')){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    ';
                }
                elseif($today >= $date_before_30_days AND $today < $date_before_10_days AND ($status != 'not_active')){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    ';
                }
                elseif($today >= $date_before_10_days AND $today <= $date_after_10_days AND ($status != 'not_active')){
                    return '
                        <div class="progress progress-lg">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    ';
                }
                elseif($today >= $date_after_10_days){
                    return '
                        Lebih dari 10 hari
                    ';
                }
                // elseif($today >= $date_after_10_days){
                //     $Updateexpired = TranInsuranceHeader::where('policynumber', $data->policynumber)->first();
                //     // return $updateTransOld;
                //     $Updateexpired->update([
                //         'status' => 'expired',
                //     ]);
                // }
            })
            // ->order([1, 'desc'])
            ->rawColumns(['action','status','remark_color','tran_insurance_header_id'])
            ->make(true);
        }



        $today = Carbon::now()->format('Y-m-d');
        $ins_type = DB::connection('mysql')->table('mst_insurance_type')->get();
        $ins_broker = DB::connection('mysql')->table('mst_insurance_broker')->get();
        $ins_insurer = DB::connection('mysql')->table('mst_insurance_insurer')->get();
        $company = DB::connection('mysql')->table('ms_nav_companies')->where('companycode', '!=', '---')->get();
        $activeIns = DB::connection('mysql')->table('tran_insurance_header')->where('status', '=', 'active')->count();
        $needActionIns = DB::connection('mysql')->table('tran_insurance_header')->where('status', '=', 'need_action')->count();
        $ExpiredIns = DB::connection('mysql')->table('tran_insurance_header')->where('status', '=', 'expired')->count();
        $ExistingIns = DB::connection('mysql')->table('tran_insurance_header')->where('status', '=', 'existing')->count();
        $todayActiveIns = DB::connection('mysql')->table('tran_insurance_header')->where('status', '=', 'active')->whereDate('createat', now()->toDateString())->count();
        $totalIns = DB::connection('mysql')->table('tran_insurance_header')->count();
        $trans_ins_header = DB::connection('mysql')->table('tran_insurance_header')->get();
        $insurancePayment = DB::connection('mysql')->table('tran_insurance_payment')->get();
        return view('insurance.view', compact('insurancePayment','trans_ins_header','ins_type','ins_broker','ins_insurer','company','activeIns','needActionIns','ExistingIns','ExpiredIns','todayActiveIns','totalIns'));
    }

    public function form_add_renewal()
    {

        $ins_type = DB::connection('mysql')->table('mst_insurance_type')->get();
        $ins_broker = DB::connection('mysql')->table('mst_insurance_broker')->get();
        $ins_insurer = DB::connection('mysql')->table('mst_insurance_insurer')->get();
        $company = DB::connection('mysql')->table('ms_nav_companies')->where('companycode', '!=', '---')->get();
        $PoliceInsuranceAuto = $this->PoliceInsuranceAuto();
        // $idAuto = $this->IdAuto();
        return view('insurance.form_add', compact('ins_type','ins_broker','ins_insurer','company','PoliceInsuranceAuto'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'tran_insurance_header_id'                    => ['required'],
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
            ]);


            if ($validator->fails()) {
                return redirect('insurance/form_add_renewal')
                            ->withErrors($validator)
                            ->withInput();
            }


            // Renewal Insurance
            $str = Str::random();
            $inception_date = Carbon::parse($request->inception_date);
            $expiry_date = Carbon::parse($request->expiry_date);
            $selisih = $expiry_date->diffInDays($inception_date);
            // return $selisih;
            $SLMInsurance = TranInsuranceHeader::create([
                'id'                        => $this->IdAuto(),
                'tran_insurance_header_id'  => $request->tran_insurance_header_id,
                'policynumber'              => $request->policy_number,
                'insurancetype'             => $request->insurance_type,
                'company'                   => $request->entity,
                'inceptiondate'             => $request->inception_date,
                'expirydate'                => $request->expiry_date,
                'durations'                 => $selisih,
                'broker'                    => $request->broker,
                'insurer'                   => $request->insurer,
                'status'                    => $request->status,
                'fullypaid'                 => $request->fully_paid,
                'remark'                    => $request->remarks,
                'createat'                  => Carbon::now(),
                'createby'                  => auth()->user()->name,
                'updateat'                  => Carbon::now(),
                'updateby'                  => auth()->user()->name,
            ]);
            $lastInsertid_Insurance = $SLMInsurance->id;

            if($request->fully_paid == "no"){
                for ($i=0; $i < count($request->installment); $i++) {
                    TranInsurancePayment::create([
                        'tran_insurance_header_id'  => $request->tran_insurance_header_id,
                        'insurancetype'             => $request->insurance_type,
                        'company'                   => $request->entity,
                        'broker'                    => $request->broker,
                        'insurer'                   => $request->insurer,
                        'installment_ke'            => $request->installment[$i],
                        'amount'                    => $request->line_amount[$i],
                        'total_amount'              => $request->line_amount[$i],
                        'duedate'                   => $request->duedate[$i],
                        'durations'                 => $selisih,
                        // 'status'                    => 'pending',
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
                    TranInsurancePayment::create([
                        'tran_insurance_header_id'  => $request->tran_insurance_header_id,
                        'insurancetype'             => $request->insurance_type,
                        'company'                   => $request->entity,
                        'broker'                    => $request->broker,
                        'insurer'                   => $request->insurer,
                        'installment_ke'            => 'Fully Paid',
                        'amount'                    => $request->line_amount[$i],
                        'total_amount'              => $request->line_amount[$i],
                        'duedate'                   => $request->duedate[$i],
                        'durations'                 => $selisih,
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
            return redirect('Insurance/RenewalMonitoring')->with('success', 'Data Renewal Insurance "'.$request->policy_number.'" berhasil di Tambahkan !');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return redirect('Insurance/RenewalMonitoring')->with(['error' => 'Data Renewal Insurance gagal di Tambahkan !']);
        }
    }

    public function edit(Request $request, $tran_insurance_header_id)
    {
        $TranInsuranceHeader = TranInsuranceHeader::where('tran_insurance_header_id', $tran_insurance_header_id)->first();
        $TranInsurancePayment = TranInsurancePayment::where('tran_insurance_header_id', $tran_insurance_header_id)->orderby('installment_ke', 'asc')->get();
        $ins_type = DB::connection('mysql')->table('mst_insurance_type')->get();
        $ins_broker = DB::connection('mysql')->table('mst_insurance_broker')->get();
        $ins_insurer = DB::connection('mysql')->table('mst_insurance_insurer')->get();
        $company = DB::connection('mysql')->table('ms_nav_companies')->where('companycode', '!=', '---')->get();

        return view('insurance.form_edit', compact('TranInsuranceHeader','TranInsurancePayment','ins_type','ins_broker','ins_insurer','company'));
    }

    public function update(Request $request)
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
                'line_amount'           => ['required'],
            ]);


            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }


            // Update Renewal Insurance
            $str = Str::random();
            $inception_date = Carbon::parse($request->inception_date);
            $expiry_date = Carbon::parse($request->expiry_date);
            $selisih = $expiry_date->diffInDays($inception_date);
            // return $selisih;
            $updateInsurance = TranInsuranceHeader::where('tran_insurance_header_id', $request->tran_insurance_header_id)->first();
            $updateInsurance->update([
                'policynumber'              => $request->policy_number,
                'insurancetype'             => $request->insurance_type,
                'company'                   => $request->entity,
                'inceptiondate'             => $request->inception_date,
                'expirydate'                => $request->expiry_date,
                'broker'                    => $request->broker,
                'insurer'                   => $request->insurer,
                'status'                    => $request->status,
                'fullypaid'                 => $request->fully_paid,
                'remark'                    => $request->remarks,
                'createat'                  => Carbon::now(),
                'createby'                  => auth()->user()->name,
                'updateat'                  => Carbon::now(),
                'updateby'                  => auth()->user()->name,
            ]);
            $lastInsertid_Insurance = $updateInsurance->id;

            $deletePayment = TranInsurancePayment::where('tran_insurance_header_id', $request->tran_insurance_header_id)->get();
            $deletePayment->each->delete();

            if($request->fully_paid == "no"){
                for ($i=0; $i < count($request->installment); $i++) {
                    TranInsurancePayment::create([
                        'tran_insurance_header_id'  => $request->tran_insurance_header_id,
                        'insurancetype'             => $request->insurance_type,
                        'company'                   => $request->entity,
                        'broker'                    => $request->broker,
                        'insurer'                   => $request->insurer,
                        'installment_ke'            => $request->installment[$i],
                        'amount'                    => $request->line_amount[$i],
                        'total_amount'              => $request->line_amount[$i],
                        'duedate'                   => $request->duedate[$i],
                        'durations'                 => $selisih,
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
                    TranInsurancePayment::create([
                        'tran_insurance_header_id'  => $request->tran_insurance_header_id,
                        'insurancetype'             => $request->insurance_type,
                        'company'                   => $request->entity,
                        'broker'                    => $request->broker,
                        'insurer'                   => $request->insurer,
                        'installment_ke'            => 'Fully Paid',
                        'amount'                    => $request->line_amount[$i],
                        'total_amount'              => $request->line_amount[$i],
                        'duedate'                   => $request->duedate[$i],
                        'durations'                 => $selisih,
                        'status_payment'            => 'pending',
                        'remark'                    => $request->remarks,
                        'createat'                  => Carbon::now(),
                        'createby'                  => auth()->user()->name,
                        'updateat'                  => Carbon::now(),
                        'updateby'                  => auth()->user()->name,
                    ]);
                }
            }

            DB::commit();
            // Alert::success('Success', 'Data Renewal insurance telah ditambahkan');
            toast()->success('Data has been Update successfully!', 'Congrats '.auth()->user()->name.'');
            // return redirect()->back();
            return redirect('Insurance/RenewalMonitoring')->with('success', 'Data Renewal Insurance "'.$request->tran_insurance_header_id.'" berhasil di Update !');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return redirect('Insurance/RenewalMonitoring')->with(['error' => 'Data Renewal Insurance gagal di Tambahkan !']);
        }
    }



    public function get_renewal()
    {
        $result = TranInsuranceHeader::
            select(
                'id',
                DB::raw('DATE_SUB(expirydate, INTERVAL 60 DAY) as date_before_60_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 31 DAY) as date_before_31_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 11 DAY) as date_before_11_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 10 DAY) as date_before_10_days'),
                DB::raw('DATE_ADD(expirydate, INTERVAL 10 DAY) as date_after_10_days'),
                DB::raw('CURDATE() as today'),
                'tran_insurance_header_id',
                'expirydate',
                'policynumber',
                'insurancetype',
                'company',
                'inceptiondate',
                'expirydate',
                'durations',
                'status',
            )
            ->get();

            foreach ($result as $item) {
                $filtered = $result->where('status', '=','active')
                    ->where('date_before_60_days', '<=', $item->today)
                    ->where('date_after_10_days', '>=', $item->today);
            }
        // return $filteredValidation;

        DB::beginTransaction();
        try {

            if ($filtered->isEmpty()) {
                return response()->json([
                    'message' => 'Data Renewal insurance tidak ada yang perlu diperpanjang !!',
                    'icon' => 'error',
                ]);
            }

            foreach ($filtered as $value) {
                $dueTglPerpanjang = date('Y-m-d', strtotime('+1 years', strtotime($value->expirydate)));
                $incDate = Carbon::parse($value->inceptiondate);
                $expDate = Carbon::parse($value->expirydate);
                $selisihHari = $expDate->diffInDays($incDate);

                // UPDATE EXISTING
                $updateTransOld = TranInsuranceHeader::where('tran_insurance_header_id', $value->tran_insurance_header_id)->first();
                // return $updateTransOld;
                $updateTransOld->update([
                    'status' => 'existing',
                ]);

                $TranInsuranceHeader = TranInsuranceHeader::create([
                    'id'                => $value->id,
                    'tran_insurance_header_id'      => $this->PoliceInsuranceAuto(),
                    'policynumber'      => $value->policynumber,
                    'insurancetype'     => $value->insurancetype,
                    'company'           => $value->company,
                    'inceptiondate'     => $value->expirydate,
                    'expirydate'        => $dueTglPerpanjang,
                    'durations'         => $selisihHari,
                    'broker'            => '',
                    'insurer'           => '',
                    'status'            => 'need_action',
                    'fullypaid'         => '',
                    'remark'            => '',
                    'createat'          => Carbon::now(),
                    'createby'          => auth()->user()->name,
                    'updateat'          => Carbon::now(),
                    'updateby'          => auth()->user()->name,
                ]);
                $lastInsertid_Insurance = $TranInsuranceHeader->id;
            }
            DB::commit();
            // Berikan respons
            return response()->json([
                // "redirect" => url("insurance/form_add_renewal"),
                // 'message' => 'Data '.$DateNow.' and '.$endDateNow.' berhasil disimpan',
                'message' => 'Data Renewal Insurance berhasil di Generate !!',
                'icon' => 'success',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function testing(Request $request)
    {
        $result = TranInsuranceHeader::
            select(
                'id',
                DB::raw('DATE_SUB(expirydate, INTERVAL 60 DAY) as date_before_60_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 31 DAY) as date_before_31_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 11 DAY) as date_before_11_days'),
                DB::raw('DATE_SUB(expirydate, INTERVAL 10 DAY) as date_before_10_days'),
                DB::raw('DATE_ADD(expirydate, INTERVAL 10 DAY) as date_after_10_days'),
                DB::raw('CURDATE() as today'),
                'expirydate',
                'policynumber',
                'insurancetype',
                'company',
                'inceptiondate',
                'expirydate',
                'durations',
                'status',
            )
            ->get();

        // return $result;

        foreach ($result as $item) {
            $filtered = $result->where('status', '=','active')
                ->where('date_before_60_days', '<=', $item->today)
                ->where('date_after_10_days', '>=', $item->today);
        }

        return $filtered;


        DB::beginTransaction();
        try {
            foreach ($filtered as $value) {
                $dueTglPerpanjang = date('Y-m-d', strtotime('+1 years', strtotime($value->expirydate)));
                # code...
                // // $SLMInsurance = TranInsuranceHeader::create([
                // //     'policynumber'      => $this->PoliceInsuranceAuto(),
                // //     'oldtransnumber'    => $value->policynumber,
                // //     'insurancetype'     => $value->insurancetype,
                // //     'company'           => $value->company,
                // //     'inceptiondate'     => $value->expirydate,
                // //     'expirydate'        => $dueTglPerpanjang,
                // //     'durations'         => '0',
                // //     'broker'            => '',
                // //     'insurer'           => '',
                // //     'status'            => 'need_action',
                // //     'fullypaid'         => '',
                // //     'remark'            => '',
                // //     'createat'          => Carbon::now(),
                // //     'createby'          => auth()->user()->name,
                // //     'updateat'          => Carbon::now(),
                // //     'updateby'          => auth()->user()->name,
                // // ]);
                // $lastInsertid_Insurance = $SLMInsurance->id;

                // return $value->policynumber;
                $updateTransOld = TranInsuranceHeader::where('policynumber', $value->policynumber)->first();
                return $updateTransOld;
                $updateTransOld->update([
                    'status' => 'existing',
                ]);
                // $updateTransOld = TranInsuranceHeader::where('policynumber', $policynumber)->first();
                // return $updateTransOld;

            }
            DB::commit();
            // Berikan respons
            return response()->json([
                // "redirect" => url("insurance/form_add_renewal"),
                // 'message' => 'Data '.$DateNow.' and '.$endDateNow.' berhasil disimpan',
                'message' => 'Data Renewal Insurance berhasil di Generate !!',
                // 'data' => $SaveBroker
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function form_need_action(Request $request, $id)
    {
        $ins_type = DB::connection('mysql')->table('mst_insurance_type')->get();
        $ins_broker = DB::connection('mysql')->table('mst_insurance_broker')->get();
        $ins_insurer = DB::connection('mysql')->table('mst_insurance_insurer')->get();
        $company = DB::connection('mysql')->table('ms_nav_companies')->where('companycode', '!=', '---')->get();
        $TranInsuranceHeader = DB::table('tran_insurance_header')->where('tran_insurance_header_id', $id)->first();

        return view('insurance.form_needAction', compact('ins_type','ins_broker','ins_insurer','company','TranInsuranceHeader'));
    }

    public function save_needAction(Request $request)
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
                'line_amount'           => ['required'],
            ]);


            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }


            // Update Renewal Insurance
            $inception_date = Carbon::parse($request->inception_date);
            $expiry_date = Carbon::parse($request->expiry_date);
            $selisih = $expiry_date->diffInDays($inception_date);
            // return $selisih;
            $updateInsurance = TranInsuranceHeader::where('tran_insurance_header_id', $request->tran_insurance_header_id)->first();
            // return $updateInsurance;
            $updateInsurance->update([
                'policynumber'      => $request->policy_number,
                'insurancetype'     => $request->insurance_type,
                'company'           => $request->entity,
                'inceptiondate'     => $request->inception_date,
                'expirydate'        => $request->expiry_date,
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
            // $lastInsertid_Insurance = $updateInsurance->id;

            if($request->fully_paid == "no"){
                for ($i=0; $i < count($request->installment); $i++) {
                    TranInsurancePayment::create([
                        'tran_insurance_header_id'  => $request->tran_insurance_header_id,
                        'insurancetype'             => $request->insurance_type,
                        'policynumber'              => $request->policy_number,
                        'company'                   => $request->entity,
                        'broker'                    => $request->broker,
                        'insurer'                   => $request->insurer,
                        'installment_ke'            => $request->installment[$i],
                        'amount'                    => $request->line_amount[$i],
                        'total_amount'              => $request->line_amount[$i],
                        'duedate'                   => $request->duedate[$i],
                        'durations'                 => $selisih,
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
                    TranInsurancePayment::create([
                        'tran_insurance_header_id'  => $request->tran_insurance_header_id,
                        'insurancetype'             => $request->insurance_type,
                        'policynumber'              => $request->policy_number,
                        'company'                   => $request->entity,
                        'broker'                    => $request->broker,
                        'insurer'                   => $request->insurer,
                        'installment_ke'            => 'Fully Paid',
                        // 'duedate'                   => Carbon::createFromFormat('m/d/Y', $request->expiry_date)->format('Y-m-d'),
                        'amount'                    => $request->line_amount[$i],
                        'total_amount'              => $request->line_amount[$i],
                        'duedate'                   => $request->duedate[$i],
                        'durations'                 => $selisih,
                        'status_payment'            => 'pending',
                        'remark'                    => $request->remarks,
                        'createat'                  => Carbon::now(),
                        'createby'                  => auth()->user()->name,
                        'updateat'                  => Carbon::now(),
                        'updateby'                  => auth()->user()->name,
                    ]);
                }
            }

            DB::commit();
            // Alert::success('Success', 'Data Renewal insurance telah ditambahkan');
            toast()->success('Data has been Update Need Action successfully!', 'Congrats '.auth()->user()->name.'');
            // return redirect()->back();
            return redirect('Insurance/RenewalMonitoring')->with('success', 'Data Need Action Insurance "'.$request->policy_number.'" berhasil di Update !');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return redirect('Insurance/RenewalMonitoring')->with(['error' => 'Data Renewal Insurance gagal di Tambahkan !']);
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
            // "redirect" => url("insurance/form_add_renewal"),
            'message' => 'Data berhasil disimpan',
            'data' => $SaveBroker
        ]);
    }
}
