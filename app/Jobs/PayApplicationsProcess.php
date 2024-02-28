<?php

namespace App\Jobs;

use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PayApplicationsProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        $applications = Application::where('created_at', '>=', $sevenDaysAgo)
            ->andWhere('status', 1)
            ->get();

        foreach ($applications as $application){
            $user = User::where('id',$application->user_id)->first();

            // pay user the application price
        }


    }
}
