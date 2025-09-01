<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout heading="Profil" subheading="Perbarui nama dan email Anda">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" label="Nama" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" label="Email" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            Email anda belum diverifikasi.

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                Klik di sini untuk mengirim email konfirmasi.
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                Link verifikasi telah dikirim ke email anda.
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">Simpan</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    Tersimpan
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
