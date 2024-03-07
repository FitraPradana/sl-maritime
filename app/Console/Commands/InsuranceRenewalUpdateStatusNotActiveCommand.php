<?php

namespace App\Console\Commands;

use App\Models\TranInsuranceHeader;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsuranceRenewalUpdateStatusNotActiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insurance-renewal-update-status-not-active-command';

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
