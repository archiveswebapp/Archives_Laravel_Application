<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AddToCart extends Component
{
    public Product $product;
    public int $qty = 1;

    protected $rules = [
        'qty' => 'required|integer|min:1',
    ];

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    public function add()
    {
        $this->validate();

        $cart = session()->get('cart', []);
        $id   = $this->product->id;

        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id'    => $id,
                'name'  => $this->product->name,
                'price' => (float) $this->product->price,
                'qty'   => 0,
                'image' => $this->product->image,
            ];
        }

        $cart[$id]['qty'] += max(1, (int) $this->qty);

        session(['cart' => $cart]);

        
        $this->dispatch('cart-added', id: $id, qty: $this->qty);

        
        session()->flash('status', 'Item added to cart.');

        return redirect()->route('cart');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
