<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsTable extends Component
{
    use WithPagination;

    #[Url] 
    public string $q = '';

    #[Url] 
    public string $sort = 'id';

    #[Url] 
    public string $dir = 'desc';

    public function sortBy(string $field): void
    {
        $this->dir = ($this->sort === $field && $this->dir === 'asc') ? 'desc' : 'asc';
        $this->sort = $field;
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::with('category') // eager load categories
            ->when($this->q, fn($q) => $q->where('name','like',"%{$this->q}%"))
            ->orderBy($this->sort, $this->dir)
            ->paginate(10);

        return view('livewire.products-table', compact('products'));
    }
}
