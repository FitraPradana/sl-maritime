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
use App\Mail\GetRenewalInsurancetoAccountingMail;

class InsurancePaymentNotifH_7Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insurance-payment-notif-h_7-command';

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
}
