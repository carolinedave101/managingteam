<x-app-layout>
    <div class="mesh-gradient min-h-screen py-12 relative overflow-hidden">
        <div class="absolute top-20 left-10 w-64 h-64 bg-rose-200/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
        <div class="absolute bottom-20 right-10 w-48 h-48 bg-pink-200/20 rounded-full blur-3xl animate-blob-reverse pointer-events-none"></div>

        <div class="max-w-3xl mx-auto px-4">
            {{-- Header --}}
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2"><span class="gradient-text gradient-text-gold">My Profile</span></h1>
                <p class="text-gray-500">Manage your personal information and profile photo</p>
            </div>

            {{-- Profile form --}}
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl border-2 border-gray-200 shadow-lg p-6 sm:p-8">
                <form method="POST" action="{{ url()->current() }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('patch')

                    {{-- Avatar upload --}}
                    <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-100">
                        <div class="relative group">
                            <div x-data="{ preview: null }">
                                <label for="avatar" class="cursor-pointer block">
                                    <div class="relative">
                                        {{-- Current avatar or preview --}}
                                        <div x-show="!preview">
                                            <x-user-avatar :user="$user" size="xl" class="!w-24 !h-24 !text-2xl !ring-4 !ring-white !shadow-xl" />
                                        </div>
                                        <template x-if="preview">
                                            <img :src="preview" class="w-24 h-24 rounded-full object-cover ring-4 ring-white shadow-xl" />
                                        </template>
                                        {{-- Hover overlay --}}
                                        <div class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                    </div>
                                </label>
                                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden"
                                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }">
                            </div>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="font-bold text-gray-900 text-lg">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
                            <p class="text-xs text-gray-400 mt-2">Click your photo to upload a new one. JPEG, PNG, or WebP. Max 2MB.</p>
                            @error('avatar')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Form fields --}}
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-input-label for="name" value="Full Name" />
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                    class="form-input mt-1.5 @error('name') form-input-error @enderror" />
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input-label for="email" value="Email Address" />
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                    class="form-input mt-1.5 @error('email') form-input-error @enderror" />
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <x-input-label for="phone" value="Phone Number" />
                            <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}"
                                class="form-input mt-1.5 @error('phone') form-input-error @enderror"
                                placeholder="e.g., +1 (555) 123-4567" />
                            <p class="text-xs text-gray-400 mt-1.5">Optional. Used for event notifications and meetup coordination.</p>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary !py-2.5 !px-6 animate-shine">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Save Changes
                        </button>
                        @if ($celebrity)
                            <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" class="btn-ghost !py-2.5 !px-6">Cancel</a>
                        @endif
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                               class="text-sm text-green-600 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Saved!
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Password section --}}
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl border-2 border-gray-200 shadow-lg p-6 sm:p-8 mt-6">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Danger zone --}}
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl border-2 border-red-200 shadow-lg p-6 sm:p-8 mt-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
