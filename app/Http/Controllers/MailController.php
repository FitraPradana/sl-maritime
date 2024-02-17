<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;
use App\Mail\GetRenewalInsuranceMail;
use App\Mail\GetRenewalInsurancetoAccountingMail;
use App\Mail\GetRenewalMail;
use App\Models\MSTInsuranceType;
use App\Models\TranInsuranceHeader;
use App\Models\TranInsurancePayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];
        Mail::to('pradanafitrah45@gmail.com')->send(new DemoMail($mailData));
        dd("Email is sent successfully.");
    }

    public function actionGetRenewalInsurance()
    {

        $result = TranInsuranceHeader::select(
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

        foreach ($result as $item) {
            $filtered = $result->where('status', '=', 'active')
                ->where('date_before_60_days', '<=', $item->today)
                ->where('date_after_10_days', '>=', $item->today);
        }

        // return $filtered;

        foreach ($filtered as $value) {
            $dueTglPerpanjang = date('Y-m-d', strtotime('+1 years', strtotime($value->expirydate)));
            $incDate = Carbon::parse($value->inceptiondate);
            $expDate = Carbon::parse($value->expirydate);
            $diff = $expDate->diffInDays(Carbon::now());
            $diffForHumans = Carbon::parse($value->expirydate)->diffForHumans(Carbon::now());
            $type = MSTInsuranceType::where('typecode', $value->insurancetype)->first();
            $installment = collect(TranInsurancePayment::select('installment_ke')->where('policynumber', '=', 'P-INS/2024/10002')->orderby('installment_ke', 'asc')->get());
            $installmentImplode = $installment->implode('installment_ke', '/ ');
            $today = $value->today;
            $date_before_60_days = Carbon::parse($value->date_before_60_days);
            $date_before_30_days = Carbon::parse($value->date_before_30_days);
            $date_before_10_days = Carbon::parse($value->date_before_10_days);
            $date_after_10_days = Carbon::parse($value->date_after_10_days);
            $dueDate = Carbon::parse($value->expirydate);
            $selisihHari = $dueDate->diffInDays($today);
            if ($today >= $date_before_60_days and $today < $date_before_30_days) {
                $flag = 'GREEN';;
            } elseif ($today >= $date_before_30_days and $today < $date_before_10_days) {
                $flag = 'YELLOW';
            } elseif ($today >= $date_before_10_days and $today <= $date_after_10_days) {
                $flag = 'RED';
            }

            $mailData = [
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






            // Payment Monitoring
            // $resultPayment = TranInsurancePayment::select(
            //     DB::raw('DATE_SUB(duedate, INTERVAL 30 DAY) as date_before_30_days'),
            //     DB::raw('DATE_SUB(duedate, INTERVAL 16 DAY) as date_before_16_days'),
            //     DB::raw('DATE_SUB(duedate, INTERVAL 15 DAY) as date_before_15_days'),
            //     DB::raw('DATE_SUB(duedate, INTERVAL 8 DAY) as date_before_8_days'),
            //     DB::raw('DATE_SUB(duedate, INTERVAL 7 DAY) as date_before_7_days'),
            //     DB::raw('DATE_ADD(duedate, INTERVAL 7 DAY) as date_after_7_days'),
            //     DB::raw('CURDATE() as today'),
            //     'policynumber',
            //     'insurancetype',
            //     'installment_ke',
            //     'company',
            //     'amount',
            //     'duedate',
            //     'durations',
            //     'paymentdate',
            //     'status_payment',
            // )
            //     ->get();

            // foreach ($resultPayment as $val) {
            //     $filteredPayment = $resultPayment->where('status', '=', 'active')
            //         ->where('date_before_30_days', '<=', $item->today)
            //         ->where('date_after_7_days', '>=', $item->today);
            // }

            // if ($diff <= 3) {
            // $insurancePayment = TranInsurancePayment::where('policynumber', '=', 'P-INS/2024/10002')->get();
            $insurancePayment = TranInsurancePayment::where('policynumber', $value->policynumber)->get();
            foreach ($insurancePayment as $key => $val) {
                $subjectAccounting = '[Insurance] (' . $val->installment_ke . ') Installment for Policy (' . $type->typename . ') | Period (' . Carbon::parse($value->expirydate)->format('d M Y') . ' - ' . Carbon::parse($dueTglPerpanjang)->format('d M Y') . ')';
                Mail::to(['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'])->send(new GetRenewalInsurancetoAccountingMail($mailData, $subjectAccounting));
            }
            // }
        }
        Alert::success('Renewal Insurance Mail', 'Email is sent successfully.');
        return redirect()->back();
    }
}
