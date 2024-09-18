<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TransactionController;

class updateExchangeRatesApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-exchange';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch exchange rate data from API (Latvijas banka)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        TransactionController::getExchangeRates();
    }
}
