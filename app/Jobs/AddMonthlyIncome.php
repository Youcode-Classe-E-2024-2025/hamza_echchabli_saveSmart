<?php
namespace App\Jobs;

use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddMonthlyIncome implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $today = Carbon::now()->startOfMonth(); // Get the 1st day of the current month
        $updatedCount = 0;

        DB::transaction(function () use ($today, &$updatedCount) {
            Profile::where('monthly_income', '>', 0)->chunk(200, function ($profiles) use ($today, &$updatedCount) {
                foreach ($profiles as $profile) {
                    if ($profile->updated_at->lt($today)) {
                        $profile->balance += $profile->monthly_income;
                        $profile->save();
                        $updatedCount++;
                    }
                }
            });
        });

        Log::info('AddMonthlyIncome job completed. Updated ' . $updatedCount . ' profiles.');
    }
}