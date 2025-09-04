<?php

namespace App\Livewire;

use App\Models\Outlet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OutletIndex extends Component
{
    use WithPagination;

    public string $name;
    public ?string $address = '';
    public ?string $phone = '';
    public string $id = '';
    public string $search = '';

    public function getOutletsProperty()
    {
        return Auth::user()
            ->company
            ->outlets()
            ->search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function resetForm()
    {
        $this->reset(['id', 'name', 'phone', 'address']);
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
            Outlet::create([
                'name' => $this->name,
                'address' => $this->address ?: null,
                'phone' => $this->phone ?: null,
                'company_id' => Auth::user()->company->id
            ]);
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil menambahkan outlet');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menambahkan outlet');
        }
        $this->resetForm();
        $this->modal('create-outlet')->close();
        $this->resetPage();
    }

    public function onUpdate($id, $name, $address, $phone)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address ?: null;
        $this->phone = $phone ?: null;
        $this->modal('update-outlet')->show();
    }

    public function confirmUpdate()
    {
        if (!$this->id)
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal memperbarui outlet');

        try {
            Outlet::find($this->id)->update([
                'name' => $this->name,
                'address' => $this->address ?: null,
                'phone' => $this->phone ?: null
            ]);
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil memperbarui outlet');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal memperbarui outlet');
        }
        $this->resetForm();
        $this->modal('update-outlet')->close();
    }

    public function onDelete($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->modal('delete-outlet')->show();
    }

    public function confirmDelete()
    {
        if (!$this->id)
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menghapus outlet');

        try {
            Outlet::find($this->id)->delete();
            $this->dispatch('show-notification', type: 'success', message: 'Berhasil menghapus outlet');
        } catch (\Throwable $th) {
            $this->dispatch('show-notification', type: 'danger', message: 'Gagal menghapus outlet');
        }
        $this->resetForm();
        $this->modal('delete-outlet')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.outlet', [
            'outlets' => $this->outlets
        ]);
    }
}
