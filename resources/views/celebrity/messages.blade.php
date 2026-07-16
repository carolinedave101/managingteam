<x-app-layout>
    <div class="mesh-gradient min-h-screen py-12 relative overflow-hidden">
        <div class="absolute top-20 left-10 w-64 h-64 bg-rose-200/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
        <div class="absolute bottom-20 right-10 w-48 h-48 bg-pink-200/20 rounded-full blur-3xl animate-blob-reverse pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 space-y-8">

            {{-- Header --}}
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2"><span class="gradient-text gradient-text-gold">Messages</span></h1>
                <p class="text-gray-500">Chat with the {{ $celebrity->name }} management team</p>
            </div>

            {{-- New Message Form (collapsible) --}}
            <div x-data="{ open: false }" class="bg-white/90 backdrop-blur-sm rounded-2xl border border-white/60 shadow-lg">
                <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">New Message</h2>
                            <p class="text-xs text-gray-400">Have a question? Send us a message.</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" x-bind:class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </button>
                <div x-show="open" x-collapse.duration.300ms>
                    <div class="px-5 pb-5 border-t border-gray-100 pt-5">
                        <form method="POST" action="{{ route('celebrity.messages.store', ['celebrity' => $celebrity->slug]) }}" novalidate x-data="formValidation">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="subject" value="Subject" />
                                    <input type="text" id="subject" name="subject" required
                                        x-on:input.debounce.300ms="validate('subject', $el.value, [validators.required])"
                                        x-on:blur="validate('subject', $el.value, [validators.required])"
                                        x-bind:class="inputClass('subject')"
                                        class="form-input mt-1"
                                        placeholder="e.g., Membership question, Event inquiry" />
                                    <template x-if="invalid('subject')">
                                        <p x-text="errors.subject" class="text-red-500 text-xs mt-1"></p>
                                    </template>
                                </div>
                                <div>
                                    <x-input-label for="content" value="Message" />
                                    <textarea id="content" name="content" rows="4" required
                                        x-on:input.debounce.300ms="validate('content', $el.value, [validators.required, validators.minLength(10)])"
                                        x-on:blur="validate('content', $el.value, [validators.required, validators.minLength(10)])"
                                        x-bind:class="inputClass('content')"
                                        class="form-input mt-1"
                                        placeholder="Hi team, I had a question about..."></textarea>
                                    <template x-if="invalid('content')">
                                        <p x-text="errors.content" class="text-red-500 text-xs mt-1"></p>
                                    </template>
                                </div>
                                <button type="submit" class="btn-primary w-full justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Conversation threads --}}
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Your Conversations</h2>
                        <p class="text-xs text-gray-400">{{ $threads->count() }} {{ Str::plural('conversation', $threads->count()) }} — tap to read and reply</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($threads as $thread)
                        @php
                            $lastReply = $thread->replies->last();
                            $hasUnread = !$thread->is_read || $thread->replies->contains(fn($r) => !$r->is_read);
                            $allMessages = collect([$thread])->concat($thread->replies);
                            $myInitial = strtoupper(substr(auth()->user()->name, 0, 1));
                            $me = auth()->user();
                        @endphp
                        <div x-data="{ expanded: false }"
                             class="bg-white/95 backdrop-blur-sm rounded-2xl border-2 shadow-sm overflow-hidden transition-all duration-300"
                             x-bind:class="expanded
                                ? 'border-rose-300 shadow-md shadow-rose-100/50'
                                : 'border-gray-200 {{ $hasUnread ? 'border-rose-300' : 'hover:border-gray-300' }}'">

                            {{-- Thread preview (collapsed state) --}}
                            <button @click="expanded = !expanded" class="w-full text-left p-4 hover:bg-gray-50/50 transition-colors duration-150">
                                <div class="flex items-start gap-3">
                                    {{-- Sender avatar --}}
                                    <div class="shrink-0">
                                        @if ($thread->sender_id === auth()->id())
                                            <x-user-avatar :user="$me" size="md" />
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold shadow-sm ring-2 ring-white/60">
                                                {{ substr($celebrity->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-bold text-gray-900 text-sm truncate">{{ $thread->subject }}</h3>
                                            @if ($hasUnread)
                                                <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs text-gray-400">{{ $thread->created_at->format('M d') }}</span>
                                            <span class="text-gray-300">·</span>
                                            <span class="text-xs {{ $thread->sender_id === auth()->id() ? 'text-rose-600' : 'text-purple-600' }}">
                                                {{ $thread->sender_id === auth()->id() ? 'You' : $celebrity->name . ' Team' }}
                                            </span>
                                        </div>
                                        {{-- Preview --}}
                                        <p class="text-sm text-gray-500 mt-1.5 line-clamp-1">
                                            @if ($lastReply)
                                                <span class="text-gray-400">{{ $lastReply->sender_id === auth()->id() ? 'You: ' : 'Team: ' }}</span>
                                                {{ Str::limit($lastReply->content, 80) }}
                                            @else
                                                <span class="text-gray-400">You: </span>
                                                {{ Str::limit($thread->content, 80) }}
                                            @endif
                                        </p>
                                    </div>

                                    {{-- Meta --}}
                                    <div class="flex flex-col items-end gap-1.5 shrink-0">
                                        @if ($thread->replies->count())
                                            <span class="text-xs font-bold {{ $hasUnread ? 'text-rose-600 bg-rose-50' : 'text-gray-500 bg-gray-100' }} px-2 py-0.5 rounded-full">
                                                {{ $thread->replies->count() }}
                                            </span>
                                        @endif
                                        <svg class="w-4 h-4 text-gray-300 transition-transform duration-300"
                                             x-bind:class="expanded ? 'rotate-180' : ''"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </button>

                            {{-- Expanded conversation --}}
                            <div x-show="expanded" x-collapse.duration.300ms>
                                <div class="border-t border-gray-100">
                                    {{-- Conversation timeline --}}
                                    <div class="px-4 py-5 bg-gradient-to-b from-gray-50/30 to-transparent">
                                        <div class="relative space-y-5">
                                            {{-- Vertical timeline line --}}
                                            <div class="absolute left-[17px] top-3 bottom-3 w-0.5 bg-gradient-to-b from-rose-200 via-purple-200 to-gray-200 rounded-full"></div>

                                            @foreach ($allMessages as $msg)
                                                @php
                                                    $isMe = $msg->sender_id === auth()->id();
                                                    $initial = $isMe ? $myInitial : substr($celebrity->name, 0, 1);
                                                @endphp
                                                <div class="relative flex items-start gap-3 pl-0">
                                                {{-- Timeline dot + avatar --}}
                                                <div class="relative z-10 shrink-0">
                                                    @if ($isMe)
                                                        <x-user-avatar :user="$me" size="md" class="!ring-2 !ring-white" />
                                                    @else
                                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold shadow-sm ring-2 ring-white">
                                                            {{ substr($celebrity->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>

                                                    {{-- Message bubble --}}
                                                    <div class="flex-1 min-w-0 pt-0.5">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <span class="text-xs font-bold {{ $isMe ? 'text-rose-600' : 'text-purple-600' }}">
                                                                {{ $isMe ? 'You' : $celebrity->name . ' Team' }}
                                                            </span>
                                                            <span class="text-[10px] text-gray-400">
                                                                {{ $msg->created_at->format('M d, g:i A') }}
                                                            </span>
                                                            @if ($msg->is_read && !$isMe)
                                                                <span class="text-[10px] text-green-500">Read</span>
                                                            @endif
                                                        </div>
                                                        <div class="inline-block max-w-[85%] {{ $isMe
                                                            ? 'bg-gradient-to-br from-rose-500 to-pink-600 text-white rounded-2xl rounded-tl-md'
                                                            : 'bg-white text-gray-800 rounded-2xl rounded-tr-md border border-gray-200' }}
                                                            px-4 py-2.5 text-sm leading-relaxed shadow-sm">
                                                            {{ $msg->content }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Reply form --}}
                                    <div class="px-4 py-3 border-t border-gray-100 bg-white">
                                        <form method="POST" action="{{ route('celebrity.messages.store', ['celebrity' => $celebrity->slug]) }}" novalidate x-data="formValidation" class="flex gap-2 items-center">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $thread->id }}">
                                            <input type="hidden" name="subject" value="Re: {{ $thread->subject }}">
                                            <div class="flex-1 relative">
                                                <input type="text" name="content" required placeholder="Type your reply..."
                                                    x-on:input.debounce.300ms="validate('reply{{ $thread->id }}', $el.value, [validators.required])"
                                                    x-on:blur="validate('reply{{ $thread->id }}', $el.value, [validators.required])"
                                                    x-bind:class="inputClass('reply{{ $thread->id }}')"
                                                    class="form-input !rounded-full !py-2.5 !pr-12" />
                                            </div>
                                            <button type="submit"
                                                    class="shrink-0 w-9 h-9 rounded-full bg-gradient-to-br from-rose-500 to-pink-600 text-white flex items-center justify-center shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-white/60 shadow-sm text-center py-16">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="font-bold text-gray-600 text-lg">No conversations yet</p>
                            <p class="text-sm text-gray-400 mt-1 max-w-sm mx-auto">Click <strong>"New Message"</strong> above to send your first message. We typically respond within 24 hours.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
