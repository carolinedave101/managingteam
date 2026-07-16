<?php

namespace App\Livewire;

use Livewire\Component;

class Toast extends Component
{
    protected $listeners = ['addToast', 'removeToast'];

    public function addToast(string $message, string $type = 'info'): void
    {
        $this->dispatch('notify', message: $message, type: $type);
    }

    public function removeToast(string $id): void
    {
        $this->dispatch('remove-toast', id: $id);
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
