<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Company;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('pengaturan', 'pengaturan/profil');

    Route::get('pengaturan/profil', Profile::class)->name('settings.profile');
    Route::get('pengaturan/password', Password::class)->name('settings.password');
    Route::get('pengaturan/tampilan', Appearance::class)->name('settings.appearance');
    Route::get('pengaturan/bisnis', Company::class )->middleware('role:admin')->name('settings.company');
});

require __DIR__ . '/auth.php';
