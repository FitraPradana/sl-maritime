<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Mail;
use App\Mail\DemoMail;
use App\Mail\GetRenewalInsuranceMail;
use App\Mail\GetRenewalInsurancetoAccountingMail;
use App\Models\MSTInsuranceType;
use App\Models\TranInsuranceHeader;
use App\Models\TranInsurancePayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TESTController extends Controller
{
    protected $InsuranceController;

    public function __construct(InsuranceController $InsuranceController)
    {
        $this->InsuranceController = $InsuranceController;
    }

    public function test_send_email()
    {
        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];

        Mail::to('pradanafitrah45@gmail.com')->send(new DemoMail($mailData));

        dd("Email is sent successfully.");
    }

    public function phising()
    {
        return view('ITManagement.phising.index');
    }

    public function coba_insert()
    {
        DB::table('employees')->insert([
            'absentno' => 'John Doe',
            'empname' => 'john@example.com',
            'empemail' => 'john@example.com',
        ]);
    }

    public function coba_send_email()
    {
        $mailData = [
            'email' => "pradanafitrah45@gmail.com",
            'title' => 'Otomatic Email Insurance',
            'body' => 'This is for testing email Every 15 Second'
        ];

        Mail::send('emails.demoMailAutomatic', $mailData, function ($message) use ($mailData) {
            $message->from('noreply@sl-maritime.com', 'Insurance Monitoring');

            $message->to($mailData["email"], $mailData["email"])
                ->subject($mailData["title"]);
        });
        dd("Email is sent successfully.");
    }

    public function cekDataNotifInsuranceH_60()
    {
        $result = DB::connection('mysql')
            ->table('tran_insurance_header as a')
            ->select(
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 60 DAY) as date_before_60_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 31 DAY) as date_before_31_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 11 DAY) as date_before_11_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 10 DAY) as date_before_10_days'),
                DB::raw('DATE_ADD(a.expirydate, INTERVAL 10 DAY) as date_after_10_days'),
                DB::raw('CURDATE() as today'),
                'a.*',
                'b.status as stat_need',
            )
            ->leftJoin('tran_insurance_header as b', 'a.id', '=', 'b.id')
            ->get();

        // return $result;

        foreach ($result as $item) {
            $filtered = $result
                ->where('date_before_60_days', '<=', $item->today)
                ->where('date_before_30_days', '>', $item->today)
                ->where('status', '=', 'existing')
                ->where('stat_need', '=', 'need_action');
        }

        return $filtered;

        foreach ($filtered as $value) {
            $dueTglPerpanjang = date('Y-m-d', strtotime('+1 years', strtotime($value->expirydate)));
            $incDate = Carbon::parse($value->inceptiondate);
            $expDate = Carbon::parse($value->expirydate);
            $diff = $expDate->diffInDays(Carbon::now());
            $diffForHumans = Carbon::parse($value->expirydate)->diffForHumans(Carbon::now());
            $type = MSTInsuranceType::where('typecode', $value->insurancetype)->first();
            $installment = collect(TranInsurancePayment::select('installment_ke')->where('tran_insurance_header_id', '=', $value->tran_insurance_header_id)->orderby('updateat', 'asc')->get());
            $installmentImplode = $installment->implode('installment_ke', '/ ');
            $today = $value->today;
            $date_before_60_days = Carbon::parse($value->date_before_60_days);
            $date_before_30_days = Carbon::parse($value->date_before_30_days);
            $date_before_10_days = Carbon::parse($value->date_before_10_days);
            $date_after_10_days = Carbon::parse($value->date_after_10_days);
            $dueDate = Carbon::parse($value->expirydate);
            $selisihHari = $dueDate->diffInDays($today);
            $flag = 'GREEN';

            $mailData = [
                'email' => ['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'],
                'title' => 'Dear All, ',
                'body' => 'This is for Department Insurance PT Sinarmas LDA Maritime',
            ];
            $subject = 'FLAG[' . $flag . '][NEED ACTION] Renewal Policy (' . $type->typename . ') | Period (' . Carbon::parse($value->expirydate)->format('d M Y') . ' - ' . Carbon::parse($dueTglPerpanjang)->format('d M Y') . ')';
            $mailData["policynumber"] = $value->policynumber;
            $mailData["insurancetype"] = $type->typename;
            $mailData["period"] = '(' . Carbon::parse($value->expirydate)->format('d M Y') . ' - ' . Carbon::parse($dueTglPerpanjang)->format('d M Y') . ')';
            $mailData["countdown"] = $diff;
            Mail::to(['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'])
                ->send(new GetRenewalInsuranceMail($mailData, $subject));
        }
    }

    public function cekDataNotifInsuranceH_30()
    {
        $result = DB::connection('mysql')
            ->table('tran_insurance_header as a')
            ->select(
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 60 DAY) as date_before_60_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 31 DAY) as date_before_31_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 11 DAY) as date_before_11_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 10 DAY) as date_before_10_days'),
                DB::raw('DATE_ADD(a.expirydate, INTERVAL 10 DAY) as date_after_10_days'),
                DB::raw('CURDATE() as today'),
                'a.*',
                'b.status as stat_need',
            )
            ->leftJoin('tran_insurance_header as b', 'a.id', '=', 'b.id')
            ->get();

        // return $result;

        foreach ($result as $item) {
            $filtered = $result
                ->where('date_before_30_days', '<=', $item->today)
                ->where('date_before_10_days', '>', $item->today)
                ->where('status', '=', 'existing')
                ->where('stat_need', '=', 'need_action');
        }

        return $filtered;
    }

    public function cekDataNotifInsuranceH_10()
    {
        $result = DB::connection('mysql')
            ->table('tran_insurance_header as a')
            ->select(
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 60 DAY) as date_before_60_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 31 DAY) as date_before_31_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 11 DAY) as date_before_11_days'),
                DB::raw('DATE_SUB(a.expirydate, INTERVAL 10 DAY) as date_before_10_days'),
                DB::raw('DATE_ADD(a.expirydate, INTERVAL 10 DAY) as date_after_10_days'),
                DB::raw('CURDATE() as today'),
                'a.*',
                'b.status as stat_need',
            )
            ->leftJoin('tran_insurance_header as b', 'a.id', '=', 'b.id')
            ->get();

        foreach ($result as $item) {
            $filtered = $result
                ->where('date_before_10_days', '<=', $item->today)
                ->where('date_after_10_days', '>=', $item->today)
                ->where('status', '=', 'existing')
                ->where('stat_need', '=', 'need_action');
        }
        return $filtered;
    }

    public function cekDataNotifInsuranceH10()
    {
        $result = TranInsuranceHeader::select(
            'id',
            DB::raw('DATE_SUB(expirydate, INTERVAL 60 DAY) as date_before_60_days'),
            DB::raw('DATE_SUB(expirydate, INTERVAL 31 DAY) as date_before_31_days'),
            DB::raw('DATE_SUB(expirydate, INTERVAL 30 DAY) as date_before_30_days'),
            DB::raw('DATE_SUB(expirydate, INTERVAL 11 DAY) as date_before_11_days'),
            DB::raw('DATE_SUB(expirydate, INTERVAL 10 DAY) as date_before_10_days'),
            DB::raw('DATE_ADD(expirydate, INTERVAL 1 DAY) as date_after_1_days'),
            DB::raw('DATE_ADD(expirydate, INTERVAL 10 DAY) as date_after_10_days'),
            DB::raw('CURDATE() as today'),
            'tran_insurance_header_id',
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
            $filtered = $result->where('status', '=', 'existing')
                ->where('date_after_1_days', '<=', $item->today)
                ->where('date_after_10_days', '>=', $item->today);
        }
        return $filtered;
    }

    public function InsertNeedAction()
    {
        $result = TranInsuranceHeader::select(
            'id',
            DB::raw('DATE_SUB(expirydate, INTERVAL 60 DAY) as date_before_60_days'),
            DB::raw('DATE_SUB(expirydate, INTERVAL 31 DAY) as date_before_31_days'),
            DB::raw('DATE_SUB(expirydate, INTERVAL 30 DAY) as date_before_30_days'),
            DB::raw('DATE_SUB(expirydate, INTERVAL 11 DAY) as date_before_11_days'),
            DB::raw('DATE_SUB(expirydate, INTERVAL 10 DAY) as date_before_10_days'),
            DB::raw('DATE_ADD(expirydate, INTERVAL 1 DAY) as date_after_1_days'),
            DB::raw('DATE_ADD(expirydate, INTERVAL 10 DAY) as date_after_10_days'),
            DB::raw('CURDATE() as today'),
            'tran_insurance_header_id',
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
            $filtered = $result->where('status', '=', 'active')
                ->where('date_before_60_days', '<=', $item->today)
                ->where('date_after_10_days', '>=', $item->today);
        }

        // return $filtered;

        DB::beginTransaction();
        try {
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
                    'tran_insurance_header_id'      => $this->InsuranceController->PoliceInsuranceAuto(),
                    'policynumber'      => '',
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
                    'createby'          => 'Automatic System',
                    'updateat'          => Carbon::now(),
                    'updateby'          => 'Automatic System',
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function cekDataNotifInsurancePaymentH_30()
    {
        $result = DB::connection('mysql')
            ->table('tran_insurance_payment as a')
            ->select(
                DB::raw('DATE_SUB(a.duedate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 16 DAY) as date_before_16_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 15 DAY) as date_before_15_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 8 DAY) as date_before_8_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 7 DAY) as date_before_7_days'),
                DB::raw('DATE_ADD(a.duedate, INTERVAL 7 DAY) as date_after_7_days'),
                DB::raw('CURDATE() as today'),
                'a.*',
            )
            ->get();

        foreach ($result as $item) {
            $filtered = $result
                ->where('date_before_30_days', '<=', $item->today)
                ->where('date_before_15_days', '>', $item->today)
                ->where('status_payment', '=', 'pending');
        }

        // return $filtered;

        foreach ($filtered as $value) {
            $today = $value->today;
            $duedate = Carbon::parse($value->duedate);
            $diff = $duedate->diffInDays(Carbon::now());
            $type = MSTInsuranceType::where('typecode', $value->insurancetype)->first();
            $insurance = TranInsuranceHeader::where('tran_insurance_header_id', $value->tran_insurance_header_id)->first();
            $installment = collect(TranInsurancePayment::select('installment_ke')->where('tran_insurance_header_id', '=', $value->tran_insurance_header_id)->orderby('updateat', 'asc')->get());
            $selisihHari = $duedate->diffInDays($today);

            $mailData = [
                // 'email' => ['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'],
                'title' => 'Dear All, ',
                'body' => 'This is for Department Insurance PT Sinarmas LDA Maritime',
            ];
            $subjectAccounting = '[Insurance] (' . $value->installment_ke . ') Installment for Policy (' . $type->typename . ') | Period (' . Carbon::parse($insurance->inceptiondate)->format('d M Y') . ' - ' . Carbon::parse($insurance->expirydate)->format('d M Y') . ')';
            $mailData["policynumber"] = $insurance->policynumber;
            $mailData["insurancetype"] = $type->typename;
            $mailData["period"] = '(' . Carbon::parse($insurance->inceptiondate)->format('d M Y') . ' - ' . Carbon::parse($insurance->expirydate)->format('d M Y') . ')';
            $mailData["countdown"] = $diff;
            Mail::to(['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'])->send(new GetRenewalInsurancetoAccountingMail($mailData, $subjectAccounting));
        }
    }

    public function cekDataNotifInsurancePaymentH_15()
    {
        $result = DB::connection('mysql')
            ->table('tran_insurance_payment as a')
            ->select(
                DB::raw('DATE_SUB(a.duedate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 16 DAY) as date_before_16_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 15 DAY) as date_before_15_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 8 DAY) as date_before_8_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 7 DAY) as date_before_7_days'),
                DB::raw('DATE_ADD(a.duedate, INTERVAL 7 DAY) as date_after_7_days'),
                DB::raw('CURDATE() as today'),
                'a.*',
            )
            ->get();

        foreach ($result as $item) {
            $filtered = $result
                ->where('date_before_15_days', '<=', $item->today)
                ->where('date_before_7_days', '>', $item->today)
                ->where('status_payment', '=', 'pending');
        }

        // return $filtered;

        foreach ($filtered as $value) {
            $today = $value->today;
            $duedate = Carbon::parse($value->duedate);
            $diff = $duedate->diffInDays(Carbon::now());
            $type = MSTInsuranceType::where('typecode', $value->insurancetype)->first();
            $insurance = TranInsuranceHeader::where('tran_insurance_header_id', $value->tran_insurance_header_id)->first();
            $installment = collect(TranInsurancePayment::select('installment_ke')->where('tran_insurance_header_id', '=', $value->tran_insurance_header_id)->orderby('updateat', 'asc')->get());
            $selisihHari = $duedate->diffInDays($today);

            $mailData = [
                // 'email' => ['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'],
                'title' => 'Dear All, ',
                'body' => 'This is for Department Insurance PT Sinarmas LDA Maritime',
            ];
            $subjectAccounting = '[Insurance] (' . $value->installment_ke . ') Installment for Policy (' . $type->typename . ') | Period (' . Carbon::parse($insurance->inceptiondate)->format('d M Y') . ' - ' . Carbon::parse($insurance->expirydate)->format('d M Y') . ')';
            $mailData["policynumber"] = $insurance->policynumber;
            $mailData["insurancetype"] = $type->typename;
            $mailData["period"] = '(' . Carbon::parse($insurance->inceptiondate)->format('d M Y') . ' - ' . Carbon::parse($insurance->expirydate)->format('d M Y') . ')';
            $mailData["countdown"] = $diff;
            Mail::to(['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'])->send(new GetRenewalInsurancetoAccountingMail($mailData, $subjectAccounting));
        }
    }

    public function cekDataNotifInsurancePaymentH_7()
    {
        $result = DB::connection('mysql')
            ->table('tran_insurance_payment as a')
            ->select(
                DB::raw('DATE_SUB(a.duedate, INTERVAL 30 DAY) as date_before_30_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 16 DAY) as date_before_16_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 15 DAY) as date_before_15_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 8 DAY) as date_before_8_days'),
                DB::raw('DATE_SUB(a.duedate, INTERVAL 7 DAY) as date_before_7_days'),
                DB::raw('DATE_ADD(a.duedate, INTERVAL 7 DAY) as date_after_7_days'),
                DB::raw('CURDATE() as today'),
                'a.*',
            )
            ->get();

        foreach ($result as $item) {
            $filtered = $result
                ->where('date_before_7_days', '<=', $item->today)
                ->where('date_after_7_days', '>', $item->today)
                ->where('status_payment', '=', 'pending');
        }

        // return $filtered;

        foreach ($filtered as $value) {
            $today = $value->today;
            $duedate = Carbon::parse($value->duedate);
            $diff = $duedate->diffInDays(Carbon::now());
            $type = MSTInsuranceType::where('typecode', $value->insurancetype)->first();
            $insurance = TranInsuranceHeader::where('tran_insurance_header_id', $value->tran_insurance_header_id)->first();
            $installment = collect(TranInsurancePayment::select('installment_ke')->where('tran_insurance_header_id', '=', $value->tran_insurance_header_id)->orderby('updateat', 'asc')->get());
            $selisihHari = $duedate->diffInDays($today);

            $mailData = [
                // 'email' => ['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'],
                'title' => 'Dear All, ',
                'body' => 'This is for Department Insurance PT Sinarmas LDA Maritime',
            ];
            $subjectAccounting = '[Insurance] (' . $value->installment_ke . ') Installment for Policy (' . $type->typename . ') | Period (' . Carbon::parse($insurance->inceptiondate)->format('d M Y') . ' - ' . Carbon::parse($insurance->expirydate)->format('d M Y') . ')';
            $mailData["policynumber"] = $insurance->policynumber;
            $mailData["insurancetype"] = $type->typename;
            $mailData["period"] = '(' . Carbon::parse($insurance->inceptiondate)->format('d M Y') . ' - ' . Carbon::parse($insurance->expirydate)->format('d M Y') . ')';
            $mailData["countdown"] = $diff;
            Mail::to(['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'])->send(new GetRenewalInsurancetoAccountingMail($mailData, $subjectAccounting));
        }
    }

    public function UpdateExpired()
    {
        $result = DB::connection('mysql')
            ->table('tran_insurance_header as a')
            ->select(
                DB::raw('CURDATE() as today'),
                'a.*',
                'b.status as stat_need',
            )
            ->leftJoin('tran_insurance_header as b', 'a.id', '=', 'b.id')
            ->get();

        foreach ($result as $item) {
            $filtered = $result
                ->where('expirydate', '=', Carbon::parse($item->today))
                ->where('status', '=', 'existing')
                ->where('stat_need', '=', 'need_action');
        }
        return $filtered;

        foreach ($filtered as $value) {
            // UPDATE EXPIRED
            $updateTransOld = TranInsuranceHeader::where('tran_insurance_header_id', $value->tran_insurance_header_id)->first();
            $updateTransOld->update([
                'status' => 'expired',
            ]);
        }
    }

    public function UpdateNotActive()
    {
        $result = DB::connection('mysql')
            ->table('tran_insurance_header as a')
            ->select(
                DB::raw('CURDATE() as today'),
                'a.*',
                'b.status as stat_need',
            )
            ->leftJoin('tran_insurance_header as b', 'a.id', '=', 'b.id')
            ->get();

        foreach ($result as $item) {
            $filtered = $result
                ->where('expirydate', '=', Carbon::parse($item->today))
                ->where('status', '=', 'existing')
                ->where('stat_need', '=', 'active');
        }
        // return $filtered;

        foreach ($filtered as $value) {
            // UPDATE NOT ACTIVE
            $updateTransOld = TranInsuranceHeader::where('tran_insurance_header_id', $value->tran_insurance_header_id)->first();
            $updateTransOld->update([
                'status' => 'not_active',
            ]);
        }
    }
}
