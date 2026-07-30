<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Campaign Info Header --}}
        <div class="rounded-xl bg-white/90 shadow-sm border border-gray-200 p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $this->record->subject }}</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Celebrity: <strong>{{ $this->record->celebrity?->name }}</strong> &middot;
                        Created {{ $this->record->created_at->format('M d, Y g:i A') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($this->record->total_recipients) }}</div>
                    <div class="text-xs text-gray-500">Total Recipients</div>
                </div>
                <div class="p-3 bg-emerald-50 rounded-lg">
                    <div class="text-2xl font-bold text-emerald-600">{{ number_format($this->record->sent_count) }}</div>
                    <div class="text-xs text-emerald-600/70">Sent</div>
                </div>
                <div class="p-3 bg-red-50 rounded-lg">
                    <div class="text-2xl font-bold text-red-600">{{ number_format($this->record->failed_count) }}</div>
                    <div class="text-xs text-red-600/70">Failed</div>
                </div>
            </div>

            @if($this->record->total_recipients > 0)
                <div class="mt-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Progress</span>
                        <span>{{ $this->record->progressPercent() }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 ease-out"
                             style="width: {{ $this->record->progressPercent() }}%; background: linear-gradient(135deg, #22c55e, #16a34a);">
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex gap-4 mt-4 text-xs text-gray-500">
                <span>📨 {{ $this->record->hourly_sent_count }}/{{ $this->record->hourly_limit }} sent this hour</span>
                <span>📅 {{ $this->record->daily_sent_count }}/{{ $this->record->daily_limit }} sent today</span>
            </div>
        </div>

        {{-- Livewire Campaign Processor --}}
        @if(in_array($this->record->status, ['sending', 'paused', 'completed']))
            @livewire('campaign-processor', ['campaignId' => $this->record->id], key('campaign-'.$this->record->id))
        @endif

        {{-- Recipients Table --}}
        <div class="rounded-xl bg-white/90 shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recipients Breakdown</h3>

            @php
                $pending = $this->getRecipientsByStatus('pending');
                $sent = $this->getRecipientsByStatus('sent');
                $failed = $this->getRecipientsByStatus('failed');
            @endphp

            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-xl font-bold text-gray-600">{{ number_format($pending) }}</div>
                    <div class="text-xs text-gray-500">Pending</div>
                </div>
                <div class="p-3 bg-emerald-50 rounded-lg">
                    <div class="text-xl font-bold text-emerald-600">{{ number_format($sent) }}</div>
                    <div class="text-xs text-emerald-600/70">Sent</div>
                </div>
                <div class="p-3 bg-red-50 rounded-lg">
                    <div class="text-xl font-bold text-red-600">{{ number_format($failed) }}</div>
                    <div class="text-xs text-red-600/70">Failed</div>
                </div>
            </div>
        </div>

        {{-- Form (status management) --}}
        {{ $this->form }}
    </div>
</x-filament-panels::page>