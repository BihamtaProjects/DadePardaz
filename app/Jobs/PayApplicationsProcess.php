<?php

namespace App\Jobs;

use App\Http\Controllers\PaymentController;
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
        $oneDayAgo = Carbon::now()->subDays(1);

        $applications = Application::where('created_at', '>=', $oneDayAgo)
            ->andWhere('status', 1)
            ->pluck('id');

        $applications = Application::whereIn('id', $applications)->with('user')->get();
        $paymentController = new PaymentController();
        foreach ($applications as $application) {
             $paymentController->payToEachUser($application);
        }

        }

}
