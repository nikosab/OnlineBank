<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(
            'accounts.index',
            [
                'accounts' => Account::where('user_id', Auth::id())->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $currencies = TransactionController::getExchangeRates()->keys();
        return view(
            'accounts.create',
            [
                'currencies' => $currencies
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!$request->currency_code) {
            return back()->withErrors(['currency_code' => 'Currency code not found']);
        }
        if (!$request->type) {
            return back()->withErrors(['type' => 'Account type not found']);
        }

        $validator = Validator::make($request->all(), [
            'currency_code' => ['required', 'string', 'size:3'],
            'type' => ['required', 'in:checking,saving,investment']
        ]);

        if ($validator->fails()) {
            return redirect('/accounts/create')
                ->withErrors($validator)
                ->withInput();
        }

        do {
            $accountNumber = '44AA' . rand(10000000, 99999999);
        } while (Account::where('number', $accountNumber)->exists());

        $account = [
            'user_id' => Auth::id(),
            'number' => $accountNumber,
            'currency_code' => $request->currency_code,
            'type' => $request->type,
            'balance' => 0.00
        ];

        Account::create($account);

        return redirect('/accounts')->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account): View
    {
        $transactions = Transaction::where( 'sender', $account->number)
            ->orWhere('receiver', $account->number)
            ->with(['senderAccount', 'receiverAccount'])
            ->get();
        return view('accounts.show', [
            'account' => $account,
            'transactions' => $transactions
        ]);
    }

//    /**
//     * Show the form for editing the specified resource.
//     */
//    public function edit(Account $account)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(Request $request, Account $account)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(Account $account)
//    {
//        //
//    }
}
