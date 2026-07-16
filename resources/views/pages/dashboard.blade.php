<x-app-layout>
    <div class="bg-gradient-to-b from-pink-50 to-white min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome back, <span class="gradient-text">{{ $user->name }}</span></h1>
                <p class="text-gray-500">Here's your fan dashboard overview.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $membership ? 'bg-green-100' : 'bg-gray-100' }}">
                            <svg class="w-6 h-6 {{ $membership ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Membership</p>
                            <p class="text-2xl font-bold {{ $membership ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $membership ? ucfirst($membership->tier) : 'None' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Messages</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $messages->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $user->is_verified ? 'bg-green-100' : 'bg-yellow-100' }}">
                            <svg class="w-6 h-6 {{ $user->is_verified ? 'text-green-600' : 'text-yellow-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Status</p>
                            <p class="text-2xl font-bold {{ $user->is_verified ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $user->is_verified ? 'Verified' : 'Unverified' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-900">Recent Messages</h2>
                        <a href="{{ route('messages') }}" class="text-pink-600 text-sm font-medium hover:text-pink-700 flex items-center gap-1">
                            View all
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if ($messages->isEmpty())
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500">No messages yet.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach ($messages as $msg)
                                <div class="flex justify-between items-start p-4 rounded-xl hover:bg-gray-50 transition">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate">{{ $msg->subject }}</p>
                                        <p class="text-gray-500 text-sm truncate">{{ Str::limit($msg->content, 80) }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400 flex-shrink-0 ml-4">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
