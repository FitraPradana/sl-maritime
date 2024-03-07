<?php

namespace App\Console\Commands;

use App\Mail\GetRenewalInsuranceMail;
use App\Models\MSTInsuranceType;
use App\Models\TranInsuranceHeader;
use App\Models\TranInsurancePayment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InsuranceRenewalNotifH_60Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insurance-renewal-notif-h_60-command';

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
                ->where('date_before_60_days', '<=', $item->today)
                ->where('date_before_30_days', '>', $item->today)
                ->where('status', '=', 'existing')
                ->where('stat_need', '=', 'need_action');
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
            $flag = 'GREEN';

            $mailData = [
                // 'email' => ['muhammad.fitrah@sl-maritime.com', 'pradanafitrah45@gmail.com'],
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
