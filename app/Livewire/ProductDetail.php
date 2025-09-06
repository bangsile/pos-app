<?php

namespace App\Livewire;

use App\Models\ProductStockPrice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProductDetail extends Component
{
    use WithPagination;

    public string $companyId = '';
    public string $code = '';

    public function mount($code)
    {
        $this->code = $code;
        $this->companyId = Auth::user()->company->id;
    }

    public function getDetailsProperty()
    {
        $code = $this->code;
        $companyId = $this->companyId;
        $details = ProductStockPrice::whereHas(
            'product',
            function ($q) use ($code, $companyId) {
                $q->where('code', $code)
                    ->where('company_id', $companyId);
                ;
            }
        )->paginate(10);
        if (!$details[0])
            abort(404);
        
        return $details;
    }
    
    public function render()
    {
        return view('livewire.product-detail', [
            'details' => $this->details
        ]);
    }
}
