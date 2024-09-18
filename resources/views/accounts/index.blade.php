<x-app-layout>
    @if (session('success'))
        <x-success :messages="session('success')" class="mt-2 px-4" />
    @endif
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Accounts') }}
            </h2>
            <a href="/accounts/create">
                    {{ __('Create Account') }}
            </a>
        </div>
    </x-slot>

    <x-table>
        <x-slot name="headers">
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Account number</th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Currency code</th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Balance</th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Account Type</th>
        </x-slot>

        @foreach($accounts as $account)
            <tr>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <a href="/accounts/{{ $account['id'] }}">
                        <div class="text-sm leading-5 text-gray-900">
                            {{ $account->number }}
                        </div>
                    </a>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $account['currency_code'] }}</span>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ number_format($account['balance'], 2) }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $account['type'] }}</td>
            </tr>
        @endforeach
    </x-table>
</x-app-layout>
