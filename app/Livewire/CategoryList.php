<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

    public string $name;
    public string $id = '';
    public string $search = '';

    public function getCategoriesProperty()
    {
        return Auth::user()
            ->company
            ->categories()
            ->search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function resetForm()
    {
        $this->reset(['id', 'name']);
        $this->resetErrorBag();
    }

    public function create()
    {
        $this->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi.'
        ]);
        try {
            Category::create([
                'name' => $this->name,
                'company_id' => Auth::user()->company->id
            ]);
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil menambahkan kategori');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menambahkan kategori');
        }
        $this->resetForm();
        $this->modal('create-category')->close();
        $this->resetPage();
    }

    public function onUpdate($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->modal('update-category')->show();
    }

    public function confirmUpdate()
    {
        if (!$this->id)
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal memperbarui kategori');

        try {
            Category::find($this->id)->update([
                'name' => $this->name,
            ]);
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil memperbarui kategori');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal memperbarui kategori');
        }
        $this->resetForm();
        $this->modal('update-category')->close();
    }

    public function onDelete($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->modal('delete-category')->show();
    }

    public function confirmDelete()
    {
        if (!$this->id)
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menghapus kategori');

        try {
            Category::find($this->id)->delete();
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil menghapus kategori');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menghapus kategori');
        }
        $this->resetForm();
        $this->modal('delete-category')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.category', [
            'categories' => $this->categories
        ]);
    }
}
