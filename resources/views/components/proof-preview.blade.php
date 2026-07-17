@props(['path' => null, 'size' => 'sm'])

@if (!$path)
    <span class="text-gray-400">—</span>
@elseif ($path === 'wallet')
    <span class="text-emerald-600 font-medium">✅ Wallet</span>
@else
    @php
        $url = \Illuminate\Support\Facades\Storage::url($path);
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $isPdf = $ext === 'pdf';
    @endphp

    @if ($size === 'sm')
        @if ($isImage)
            <a href="{{ $url }}" target="_blank">
                <img src="{{ $url }}" class="w-14 h-14 object-cover rounded border hover:opacity-75 transition" title="Click to view full size">
            </a>
        @elseif ($isPdf)
            <a href="{{ $url }}" target="_blank" class="inline-flex items-center gap-1 text-primary-600 underline text-xs">
                <span>📄</span> PDF
            </a>
        @else
            <a href="{{ $url }}" target="_blank" class="text-primary-600 underline text-xs">📎 View</a>
        @endif
    @else
        @if ($isImage)
            <a href="{{ $url }}" target="_blank">
                <img src="{{ $url }}" class="max-w-xs max-h-48 rounded-lg border shadow-sm hover:opacity-90 transition" title="Click to view full size">
            </a>
        @elseif ($isPdf)
            <a href="{{ $url }}" target="_blank" class="inline-flex items-center gap-2 text-primary-600 underline font-medium">
                <span class="text-2xl">📄</span> View PDF Document
            </a>
        @else
            <a href="{{ $url }}" target="_blank" class="text-primary-600 underline font-medium">📎 View Proof File</a>
        @endif
    @endif
@endif
