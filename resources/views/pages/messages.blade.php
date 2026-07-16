<x-app-layout>
    <div class="bg-gradient-to-b from-pink-50 to-white min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2"><span class="gradient-text">Messages</span></h1>
                    <p class="text-gray-500">Send and receive messages with the community.</p>
                </div>
                <button onclick="document.getElementById('new-message').classList.remove('hidden')" class="bg-pink-600 text-white px-6 py-3 rounded-xl hover:bg-pink-700 text-sm font-semibold shadow-lg shadow-pink-200 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    New Message
                </button>
            </div>

            <div id="new-message" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
                <div class="bg-white rounded-2xl p-8 max-w-lg w-full mx-4 shadow-2xl" onclick="event.stopPropagation()">
                    <h2 class="text-xl font-bold mb-2">New Message</h2>
                    <p class="text-gray-500 text-sm mb-6">Send a message to the community or admin.</p>
                    <form method="POST" action="{{ route('messages.store') }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="subject" value="Subject" />
                            <input id="subject" name="subject" type="text" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Message subject" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="content" value="Message" />
                            <textarea id="content" name="content" rows="5" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Type your message..."></textarea>
                        </div>
                        <div class="flex gap-3">
                            <x-primary-button class="flex-1 justify-center py-3">Send Message</x-primary-button>
                            <button type="button" onclick="this.closest('#new-message').classList.add('hidden')" class="px-5 py-3 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($messages->isEmpty())
                <div class="text-center py-20">
                    <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg">No messages yet.</p>
                    <p class="text-gray-400 text-sm mt-2">Click "New Message" to send your first one!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($messages as $msg)
                        <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($msg->sender_id === auth()->id() ? 'You' : ($msg->sender?->name ?? 'A'), 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $msg->subject }}</p>
                                        <p class="text-xs text-gray-400">
                                            {{ $msg->sender_id === auth()->id() ? 'You' : $msg->sender?->name }}
                                            &rarr;
                                            {{ $msg->receiver_id === auth()->id() ? 'You' : $msg->receiver?->name ?? 'Admin' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 flex-shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 text-sm leading-relaxed">{{ Str::limit($msg->content, 100) }}</p>
                            <div class="flex gap-2 mt-3">
                                @if (!$msg->is_read && $msg->receiver_id === auth()->id())
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full font-medium">New</span>
                                @endif
                                @if ($msg->payment_complete)
                                    <span class="text-xs bg-green-100 text-green-700 px-2.5 py-1 rounded-full font-medium">Payment Complete</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
