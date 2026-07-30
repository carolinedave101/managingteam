<div class="rounded-xl bg-white/90 shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Campaign Progress</h3>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
            @if($status === 'sending') bg-blue-100 text-blue-700
            @elseif($status === 'completed') bg-emerald-100 text-emerald-700
            @elseif($status === 'paused') bg-amber-100 text-amber-700
            @else bg-gray-100 text-gray-600
            @endif">
            <span class="w-1.5 h-1.5 rounded-full
                @if($status === 'sending') bg-blue-500 animate-pulse
                @elseif($status === 'completed') bg-emerald-500
                @elseif($status === 'paused') bg-amber-500
                @else bg-gray-400
                @endif">
            </span>
            {{ ucfirst($status) }}
        </span>
    </div>

    @if($totalRecipients > 0)
        <div class="mb-4">
            <div class="flex justify-between text-sm text-gray-600 mb-1.5">
                <span>{{ number_format($sentCount + $failedCount) }} / {{ number_format($totalRecipients) }}</span>
                <span>{{ $progressPercent }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                <div class="h-full rounded-full transition-all duration-500 ease-out"
                     style="width: {{ $progressPercent }}%; background: linear-gradient(135deg, #22c55e, #16a34a);">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="text-center p-3 bg-emerald-50 rounded-lg">
                <div class="text-2xl font-bold text-emerald-600">{{ number_format($sentCount) }}</div>
                <div class="text-xs text-emerald-600/70">Sent</div>
            </div>
            <div class="text-center p-3 bg-red-50 rounded-lg">
                <div class="text-2xl font-bold text-red-600">{{ number_format($failedCount) }}</div>
                <div class="text-xs text-red-600/70">Failed</div>
            </div>
            <div class="text-center p-3 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-600">{{ number_format(max(0, $totalRecipients - $sentCount - $failedCount)) }}</div>
                <div class="text-xs text-gray-600/70">Pending</div>
            </div>
        </div>

        <div class="flex gap-4 text-xs text-gray-500 mb-4">
            <span>📨 {{ $hourlySent }}/{{ $hourlyLimit }} sent this hour</span>
            <span>📅 {{ $dailySent }}/{{ $dailyLimit }} sent today</span>
        </div>

        @if($status === 'sending')
            <button wire:click="processBatch"
                    class="w-full px-4 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-medium text-sm">
                Process Next Batch
            </button>
        @endif

        @if($status === 'completed')
            <div class="text-center p-3 bg-emerald-50 rounded-lg text-emerald-700 text-sm font-medium">
                ✅ Campaign completed — all emails processed
            </div>
        @endif
    @else
        <p class="text-gray-400 text-sm text-center py-4">No recipients in this campaign.</p>
    @endif
</div>