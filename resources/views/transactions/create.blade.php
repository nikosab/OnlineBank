<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send money') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf

        <div class="mt-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center mt-4 space-x-8">
                <div class="py-6">

                    <!-- Senders Account -->
                    <div>
                        <x-input-label for="sender" :value="__('Account')"/>
                        <select id="sender" name="sender" required class="rounded-md">
                            @foreach($accounts as $account)
                                <option value="{{ $account['number'] }}"
                                        data-currency="{{ $account['currency_code'] }}"
                                        data-balance="{{ number_format($account['balance'], 2) }}">
                                    {{ $account['number'] }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('sender')" class="mt-2"/>
                    </div>
                </div>
                @php
                    $firstAccount = $accounts[0];
                @endphp
                <div>
                    <x-input-label :value="__('Currency Code')"/>
                    <span id="currency_code" class="block mt-1 w-full">{{ $firstAccount['currency_code'] }}</span>
                </div>

                <div>
                    <x-input-label :value="__('Balance')"/>
                    <span id="balance" class="block mt-1 w-full">{{ number_format($firstAccount['balance'], 2) }}</span>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const senderSelect = document.getElementById('sender');
                        const currencyCodeSpan = document.getElementById('currency_code');
                        const balanceSpan = document.getElementById('balance');

                        function updateDisplay() {
                            const selectedOption = senderSelect.options[senderSelect.selectedIndex];
                            const currencyCode = selectedOption.getAttribute('data-currency');
                            const balance = selectedOption.getAttribute('data-balance');

                            currencyCodeSpan.textContent = currencyCode;
                            balanceSpan.textContent = balance;
                        }

                        updateDisplay();

                        senderSelect.addEventListener('change', updateDisplay);
                    });
                </script>
            </div>

            <!-- Amount -->
            <div>
                <x-input-label for="amount" :value="__('Amount')"/>
                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                              :value="old('amount')"
                              required step="0.01" autofocus/>
                <x-input-error :messages="$errors->get('amount')" class="mt-2"/>
            </div>

            <!-- Account number -->
            <div>
                <x-input-label for="receiver" :value="__('Account number')"/>
                <x-text-input id="receiver" class="block mt-1 w-full" type="text" name="receiver"
                              :value="old('receiver')"
                              required autofocus/>
                <x-input-error :messages="$errors->get('receiver')" class="mt-2"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Send') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-app-layout>
