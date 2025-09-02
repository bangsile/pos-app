<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout heading="Bisnis/Usaha" subheading="Informasi bisnis/usaha Anda.">
        <form wire:submit="save" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" label="Nama *" type="text" required autofocus autocomplete="name" />
            <flux:input wire:model="email" label="Email" type="email" autocomplete="email" />
            <flux:input wire:model="phone" label="Telepon/HP" type="text" autocomplete="name" />
            <flux:input wire:model="address" label="Alamat" type="text" autocomplete="name" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">Simpan</flux:button>
                </div>

                <x-action-message class="me-3" on="company-updated">
                    Tersimpan
                </x-action-message>
            </div>
        </form>

        <div class="relative mb-5">
            <flux:heading>Status Berlangganan</flux:heading>
            <div class="flex gap-1.5 mt-2 items-center">
                @if ($company)
                    @switch($company->status)
                        @case('active')
                            <flux:badge color="green" variant="pill">Aktif</flux:badge>
                        @break

                        @case('trial')
                            <flux:badge color="green" variant="pill">Uji Coba Gratis</flux:badge>
                            <flux:badge :color="$company->remainingDays > 3 ? 'yellow' : 'red'" variant="pill">
                                {{ $company->remainingDays }} Hari tersisa
                            </flux:badge>
                        @break

                        @case('suspended')
                            <flux:badge color="red" variant="pill">Kedaluarsa</flux:badge>
                        @break

                        @default
                            <flux:badge color="yellow" variant="pill">Belum Terdaftar</flux:badge>
                    @endswitch
                @else
                    <flux:badge color="yellow" variant="pill">Belum Terdaftar</flux:badge>
                @endif
            </div>
        </div>
    </x-settings.layout>
</section>
