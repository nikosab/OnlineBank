<x-app-layout>
    @if (session('success'))
        <x-success :messages="session('success')" class="mt-2 px-4" />
    @endif
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Transactions') }}
            </h2>
            <a href="/transactions/create">
                {{ __('Send money') }}
            </a>
        </div>
    </x-slot>

    <x-table>
        <x-slot name="headers">
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Account number</th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Currency code</th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Amount</th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Type</th>
        </x-slot>

        @foreach($transactions as $transaction)
            <tr>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $transaction->sender }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $transaction->currency_code }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ number_format($transaction->amount, 2) }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">sent</td>
            </tr>
        @endforeach
    </x-table>
</x-app-layout>
