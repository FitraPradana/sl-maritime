<?php

namespace App\Console\Commands;

use App\Http\Controllers\InsuranceController;
use App\Models\TranInsuranceHeader;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsuranceRenewalInsertNeedActionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insurance-renewal-insert-need-action-command';

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
            $filtered = $result->where('status', '=','active')
                ->where('date_before_60_days', '<=', $item->today)
                ->where('date_after_10_days', '>=', $item->today);
        }

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

                $InsuranceController = new InsuranceController;
                $TranInsuranceHeader = TranInsuranceHeader::create([
                    'id'                => $value->id,
                    'tran_insurance_header_id'      => $InsuranceController->PoliceInsuranceAuto(),
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
}
