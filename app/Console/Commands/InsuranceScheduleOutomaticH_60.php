<?php

namespace App\Console\Commands;

use App\Mail\GetRenewalInsuranceMail;
use App\Mail\GetRenewalInsurancetoAccountingMail;
use App\Models\MSTInsuranceType;
use App\Models\TranInsuranceHeader;
use App\Models\TranInsurancePayment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InsuranceScheduleOutomaticH_60 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insurance-schedule-outomatic-h_60';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
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
        }
    }
}
