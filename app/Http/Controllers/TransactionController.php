<?php

namespace App\Http\Controllers;

//use App\Jobs\TransactionJob;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(): View
    {
        $accountNumbers = Account::where('user_id', Auth::id())->pluck('number');
        $transactions = Transaction::whereIn('sender', $accountNumbers)
            ->orWhereIn('receiver', $accountNumbers)
            ->orderBy('created_at', 'desc')
            ->get();
        return view(
            'transactions.index',
            compact('transactions')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $sender = strtoupper($request->input('sender'));
        $receiver = strtoupper($request->input('receiver'));

        $senderAccount = Account::where(
            'number',
            $sender
        );
        $receiverAccount = Account::where(
            'number',
            $receiver
        );

        if (!$senderAccount) {
            return back()->withErrors(['sender' => 'Sender account not found']);
        }
        if (!$receiverAccount) {
            return back()->withErrors(['receiver' => 'Receiver account not found']);
        }
        if ($sender === $receiver) {
            return back()->withErrors(['receiver' => 'Receiver account ' . $senderAccount->value('number') . ' is equal to sender account ' . $receiverAccount->value('number')]);
        }

        $validator = Validator::make($request->all(), [
            'sender' => ['required', 'string', 'size:12'],
            'receiver' => ['required', 'string', 'size:12'],
            'amount' => ['required', 'numeric', 'min:0.01',
                function ($attributes, $value, $fail) use ($senderAccount, $receiverAccount) {
                    if ($value > $senderAccount->value('balance')) {
                        $fail("You don't have enough money");
                    }
                }],
        ]);

        if ($validator->fails()) {
            return redirect('/transactions/create')
                ->withErrors($validator)
                ->withInput();
        }

        $receivedAmount = $request->amount;

//        dd('👍');
        $exchangeRates = self::getExchangeRates();
        if ($receiverAccount->value('currency_code') !== $senderAccount->value('currency_code')) {
            if ($senderAccount->value('currency_code') === 'EUR') {
                $rate = $exchangeRates->get($receiverAccount->value('currency_code'));
                $receivedAmount = $request->amount * $rate;
            } else {
                $exchangeRate = 1;
                if ($receiverAccount->value('currency_code') !== 'EUR') {
                    $exchangeRate = $exchangeRates->get($receiverAccount->value('currency_code'));
                }
                $rate = $exchangeRates->get($senderAccount->value('currency_code'));
                $receivedAmount = ($request->amount / $rate) * $exchangeRate;
            }
        }

        $transaction = [
            'sender' => $senderAccount->value('number'),
            'receiver' => $receiverAccount->value('number'),
            'amount' => $receivedAmount,
            'currency_code' => $receiverAccount->value('currency_code')
        ];

        $newBalanceSender = $senderAccount->value('balance') - $request->amount;
        $newBalanceReceiver = $receiverAccount->value('balance') + $receivedAmount;

        $senderAccount->get()->toQuery()->update([
            'balance' => $newBalanceSender,
        ]);
        $receiverAccount->get()->toQuery()->update([
            'balance' => $newBalanceReceiver,
        ]);

//        dispatch(new TransactionJob($senderAccount->get('currency_code')));
        Transaction::create($transaction);

        return redirect('/transactions')->with('success', 'Transaction successful.');
    }

    public function create(): View
    {
        return view(
            'transactions.create',
            [
                'accounts' => Account::where('user_id', Auth::id())->get()
            ]
        );
    }

    public static function getExchangeRates(): Collection
    {
        $currencies = Cache::get('exchange_rates', null);
        if (!$currencies) {
            $currencies = collect();
            $response = Http::get('https://www.bank.lv/vk/ecb.xml');
            $xml = simplexml_load_string($response->body());
            foreach ($xml->Currencies->Currency as $currency) {
                $currencies->put(
                    (string)$currency->ID,
                    (float)$currency->Rate
                );
            }
            Cache::put('exchange_rates', $currencies->toArray(), now()->addMinutes(24*60*60));
        }
        return collect($currencies);
    }
}
