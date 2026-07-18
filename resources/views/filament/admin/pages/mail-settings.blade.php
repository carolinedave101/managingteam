<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200">
            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-amber-800">
                Changes take effect immediately. The system auto-retries on port failure (587 → 465 → log).
            </p>
        </div>

        {{ $this->form }}

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:24px;">
            <x-filament::button
                type="submit"
                wire:click="save"
                color="primary"
                icon="heroicon-o-check-circle"
            >
                Save Settings
            </x-filament::button>
            <x-filament::button
                wire:click="sendTest"
                color="gray"
                icon="heroicon-o-paper-airplane"
            >
                Send Test Email
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
