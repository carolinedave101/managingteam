<x-filament-panels::page>
    <div class="space-y-4">
        <div class="flex items-center gap-3 p-4 rounded-xl bg-blue-50 border border-blue-200">
            <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-blue-800">
                Use these demo accounts to test any celebrity portal. The password is <strong>demo1234!</strong> for all accounts. Click the copy icon to copy email or password.
            </p>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
