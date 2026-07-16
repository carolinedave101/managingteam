<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-900">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
        </svg>
        @if ($this->totalItems > 0)
            <span class="absolute -top-1 -right-1 bg-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ $this->totalItems }}
            </span>
        @endif
    </button>
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 border" x-cloak>
        <div class="p-4">
            <h3 class="font-semibold text-lg mb-3">Cart</h3>
            @if (empty($items))
                <p class="text-gray-500 text-sm">Your cart is empty</p>
            @else
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @foreach ($items as $item)
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <p class="font-medium">{{ $item['name'] }}</p>
                                <p class="text-gray-500">x{{ $item['quantity'] }}</p>
                            </div>
                            <div class="text-right">
                                <p>${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                <button wire:click="removeItem('{{ $item['id'] }}')" class="text-red-500 text-xs hover:underline">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="border-t mt-3 pt-3 flex justify-between font-semibold">
                    <span>Total</span>
                    <span>${{ number_format($this->totalPrice, 2) }}</span>
                </div>
                <button wire:click="clearCart" class="mt-2 text-xs text-gray-500 hover:text-red-500">Clear cart</button>
            @endif
        </div>
    </div>
</div>
