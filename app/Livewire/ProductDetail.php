<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProductDetail extends Component
{
    use WithPagination;

    public string $search = '';
    public Product $product;


    public function mount($code)
    {
        $companyId = Auth::user()->company->id;
        $product = Product::where('company_id', $companyId)
            ->where('code', $code)
            ->firstOrFail();
        dd($product);
        $this->product = $product;
    }

    // public function getProductsProperty()
    // {
    //     $query = Auth::user()
    //         ->company
    //         ->products()
    //         ->search($this->search)
    //         ->orderBy('name', 'asc');

    //     if (!empty($this->filterCategory)) {
    //         $query->where('category_id', $this->filterCategory);
    //     }

    //     return $query->paginate($this->perPage);
    // }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.product-detail', [
            'product' => $this->product
        ]);
    }
}
