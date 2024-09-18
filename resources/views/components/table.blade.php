<div class="mt-4">
    <div class="flex justify-center mt-6">
        <div class="w-full -my-2 py-2 overflow-x-auto space-y-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="align-middle inline-block w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="w-full bg-white">
                    <thead>
                        <tr>
                            {{ $headers }}
                        </tr>
                    </thead>
                    <tbody>
                        {{ $slot }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
