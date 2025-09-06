<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStockPrice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public string $name;
    public string $code;
    public string $barcode = '';
    public string $id = '';
    public string $search = '';
    public int $perPage = 10;
    public string $filterCategory = '';
    public ?Collection $categories;
    public string $categoryId = '';

    public function mount()
    {
        $categories = Auth::user()
            ->company
            ->categories()
            ->orderBy('name', 'asc')
            ->get();

        $this->categories = $categories;
    }

    public function getProductsProperty()
    {
        $query = Auth::user()
            ->company
            ->products()
            ->search($this->search)
            ->orderBy('name', 'asc');

        if (!empty($this->filterCategory)) {
            $query->where('category_id', $this->filterCategory);
        }

        return $query->paginate($this->perPage);
    }

    public function resetForm()
    {
        $this->reset(['id', 'name', 'code', 'barcode', 'categoryId']);
        $this->resetErrorBag();
    }

    public function create()
    {
        // $outletId = Auth::user()->company->outlets[0]->id;
        // $outletIdd = Auth::user()->company->outlets[1]->id;
        // $product = Product::first();
        // $result = $product->details()->createMany([
        //     ['outlet_id' => $outletId],
        //     ['outlet_id' => $outletIdd],
        // ]);
        // dd($result);
        // $outlets = Auth::user()->company->outlets;
        // $data = [];
        // foreach ($outlets as $outlet) {
        //     $data[] = [
        //         'outlet_id' => $outlet->id
        //     ];
        // }
        // dd($data);
        $this->validate([
            'name' => 'required',
            'code' => [
                    'required',
                    'uppercase',
                    Rule::unique('products')
                        // ->ignore($this->id)
                        ->where(fn($query) => $query->where('company_id', auth()->user()->company_id))
                ],
            'barcode' => [
                Rule::unique('products')
                    ->ignore($this->id)
                    ->where(fn($query) => $query->where('company_id', auth()->user()->company_id))
            ],
            'categoryId' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'code.required' => 'Kode produk wajib diisi.',
            'code.unique' => 'Kode produk sudah terdaftar.',
            'code.uppercase' => 'Kode wajib menggunakan huruf kapital.',
            'barcode.unique' => 'Barcode sudah terdaftar.',
            'categoryId.required' => 'Kategori wajib dipilih.'
        ]);
        try {
            $product = Product::create([
                'name' => $this->name,
                'code' => $this->code,
                'barcode' => $this->barcode ?: $this->code,
                'category_id' => $this->categoryId,
                'company_id' => Auth::user()->company->id
            ]);
            $outlets = Auth::user()->company->outlets;
            $data = [];
            foreach ($outlets as $outlet) {
                $data[] = [
                    'outlet_id' => $outlet->id
                ];
            }
            $product->details()->createMany($data);
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil menambahkan produk');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menambahkan produk');
        }
        $this->resetForm();
        $this->modal('create-product')->close();
        $this->resetPage();
    }

    public function onUpdate($id, $name, $code, $barcode, $categoryId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->barcode = $barcode;
        $this->categoryId = $categoryId;
        $this->modal('update-product')->show();
    }

    public function confirmUpdate()
    {
        if (!$this->id)
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal memperbarui produk');

        $this->validate([
            'name' => 'required',
            'code' => [
                'required',
                'uppercase',
                Rule::unique('products')
                    ->ignore($this->id)
                    ->where(fn($query) => $query->where('company_id', auth()->user()->company_id))
            ],
            'barcode' => [
                Rule::unique('products')
                    ->ignore($this->id)
                    ->where(fn($query) => $query->where('company_id', auth()->user()->company_id))
            ],
            'categoryId' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'code.required' => 'Kode produk wajib diisi.',
            'code.unique' => 'Kode produk sudah terdaftar.',
            'code.uppercase' => 'Kode wajib menggunakan huruf kapital.',
            'barcode.unique' => 'Barcode sudah terdaftar.',
            'categoryId.required' => 'Kategori wajib dipilih.'
        ]);

        try {
            Product::find($this->id)->update([
                'name' => $this->name,
                'code' => $this->code,
                'barcode' => $this->barcode ?: $this->code,
            ]);
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil memperbarui produk');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal memperbarui produk');
        }
        $this->resetForm();
        $this->modal('update-product')->close();
    }

    public function onDelete($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->modal('delete-product')->show();
    }

    public function confirmDelete()
    {
        if (!$this->id)
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menghapus produk');

        try {
            Product::find($this->id)->delete();
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil menghapus produk');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menghapus produk');
        }
        $this->resetForm();
        $this->modal('delete-product')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.product', [
            'products' => $this->products
        ]);
    }
}
