<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransactionJob implements ShouldQueue
{
    use Queueable;
    private string $currency_code;

    /**
     * Create a new job instance.
     */
    public function __construct($currency_code)
    {
        //
        $this->currency_code = $currency_code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        var_dump($this->currency_code);
//        dd('Transaction job running');
    }
}
