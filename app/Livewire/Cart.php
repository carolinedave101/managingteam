<?php

namespace App\Livewire;

use Livewire\Component;

class Cart extends Component
{
    public array $items = [];

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount(): void
    {
        $this->loadCart();
    }

    public function loadCart(): void
    {
        $this->items = session()->get('cart', []);
        $this->dispatch('cart-loaded-from-server', items: $this->items);
    }

    public function addItem(string $id, string $name, float $price, int $quantity = 1, string $type = 'membership', array $metadata = []): void
    {
        $cart = session()->get('cart', []);
        $existingKey = null;

        foreach ($cart as $key => $item) {
            if ($item['id'] === $id) {
                $existingKey = $key;
                break;
            }
        }

        if ($existingKey !== null) {
            $cart[$existingKey]['quantity'] += $quantity;
        } else {
            $cart[] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'type' => $type,
                'metadata' => $metadata,
            ];
        }

        session()->put('cart', $cart);
        $this->items = $cart;
        $this->dispatch('cart-updated');
    }

    public function removeItem(string $id): void
    {
        $cart = collect(session()->get('cart', []))
            ->reject(fn ($item) => $item['id'] === $id)
            ->values()
            ->toArray();

        session()->put('cart', $cart);
        $this->items = $cart;
        $this->dispatch('cart-updated');
    }

    public function updateQuantity(string $id, int $quantity): void
    {
        $cart = session()->get('cart', []);
        foreach ($cart as $key => $item) {
            if ($item['id'] === $id) {
                $cart[$key]['quantity'] = max(1, $quantity);
                break;
            }
        }
        session()->put('cart', $cart);
        $this->items = $cart;
    }

    public function clearCart(): void
    {
        session()->forget('cart');
        $this->items = [];
        $this->dispatch('cart-updated');
    }

    public function getTotalItemsProperty(): int
    {
        return collect($this->items)->sum('quantity');
    }

    public function getTotalPriceProperty(): float
    {
        return collect($this->items)->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
