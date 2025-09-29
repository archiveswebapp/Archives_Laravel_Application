<?php

namespace App\Livewire;

use Livewire\Component;

class Cart extends Component
{
    public array $items = [];
    public float $total = 0;

    public function mount(): void
    {
        $this->items = session('cart', []);
        $this->recalc();
    }

    public function increment(int $id): void
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['qty']++;
            $this->persist();
        }
    }

    public function decrement(int $id): void
    {
        if (isset($this->items[$id]) && $this->items[$id]['qty'] > 1) {
            $this->items[$id]['qty']--;
            $this->persist();
        }
    }

    public function remove(int $id): void
    {
        unset($this->items[$id]);
        $this->persist();
    }

    public function clear(): void
    {
        $this->items = [];
        $this->persist();
    }

    protected function persist(): void
    {
        session(['cart' => $this->items]);
        $this->recalc();
    }

    protected function recalc(): void
    {
        $this->total = 0;
        foreach ($this->items as $row) {
            $this->total += ((float)$row['price']) * ((int)$row['qty']);
        }
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
