<x-filament-panels::page>
    <div>
        {{ $this->form }}

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:24px;">
            <x-filament::button
                type="submit"
                wire:click="send"
                color="primary"
                icon="heroicon-o-paper-airplane"
            >
                Send Email
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
