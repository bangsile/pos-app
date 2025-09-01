<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout heading="Tampilan" subheading="Perbarui pengaturan tampilan untuk akun Anda">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">Terang</flux:radio>
            <flux:radio value="dark" icon="moon">Gelap</flux:radio>
            <flux:radio value="system" icon="computer-desktop">Sistem</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>
