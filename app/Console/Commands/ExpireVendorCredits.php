<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireVendorCredits extends Command
{
    protected $signature = 'expire:vendor-credits';
    protected $description = 'Expire vendor free credits after 45 days';

    public function handle()
    {
        $affected = DB::table('vendor_reg')
            ->whereNotNull('credit_expiry_at')
            ->where('credit_expiry_at', '<', now())
            ->where('lead_balance', '>', 0)
            ->update([
                'lead_balance' => 0,
                'updated_at'   => now()
            ]);

        $this->info("Expired credits updated for {$affected} vendors.");
    }
}
