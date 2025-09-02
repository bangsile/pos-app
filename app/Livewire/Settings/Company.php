<?php

namespace App\Livewire\Settings;

use App\Models\Company as CompanyModel;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Company extends Component
{
    public string $name = '';
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $address = null;

    public ?CompanyModel $company = null;

    public function mount(): void
    {
        if ($company = Auth::user()->company) {
            $this->company = $company;
            $this->fill($company->only(['name', 'email', 'phone', 'address']));
        }
    }

    public function save(): void
    {
        $this->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
                'phone' => ['nullable', 'string'],
                'address' => ['nullable', 'string'],
            ],
            [
                'required' => ':attribute wajib diisi.',
                'lowercase' => ':attribute harus berupa huruf kecil.',
                'email' => 'Email tidak valid.',
                'string' => ':attribute harus berupa string.',
            ],
            [
                'name' => 'Nama',
                'email' => 'Email',
                'phone' => 'Telepon/HP',
                'address' => 'Alamat',
            ]
        );

        $user = Auth::user();

        // Buat baru atau update company
        $company = CompanyModel::updateOrCreate(
            ['id' => $user->company_id],
            [
                'name' => $this->name,
                'phone' => $this->phone ?: null,
                'email' => $this->email ?: null,
                'address' => $this->address ?: null,
            ]
        );

        // Jika user belum punya company, kaitkan & buat subscription trial
        if (!$user->company_id) {
            $user->company()->associate($company)->save();
            $company->update(['subscription_expired_at' => now()->addDays(30)->endOfDay()]);
            $company->save();
            Subscription::create([
                'company_id' => $company->id,
                'plan' => 'trial',
                'start_date' => now()->startOfDay(),
                'end_date' => now()->addDays(30)->endOfDay(),
            ]);
        }

        $this->dispatch('company-updated');
        $this->redirect(route('settings.company'), true);
    }
}
