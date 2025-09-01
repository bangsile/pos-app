<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout heading="Perbarui password"
        subheading="Pastikan akun Anda menggunakan password yang panjang dan acak untuk menjaga keamanan">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input wire:model="current_password" :label="__('Password saat ini')" type="password" required
                autocomplete="current-password" />
            <flux:input wire:model="password" :label="__('Password baru')" type="password" required
                autocomplete="new-password" />
            <flux:input wire:model="password_confirmation" :label="__('Konfirmasi password baru')" type="password"
                required autocomplete="new-password" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">Simpan</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    Tersimpan
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>