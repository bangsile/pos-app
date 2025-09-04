<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Outlet</flux:heading>
        <flux:subheading size="lg" class="mb-6">Daftar Outlet</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <x-notification class="mb-3" />

    <div class="flex flex-col-reverse sm:flex-row gap-3 justify-between">
        <flux:modal.trigger name="create-outlet">
            <flux:button :loading="false" variant="primary">Tambah Outlet</flux:button>
        </flux:modal.trigger>

        <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Cari nama outlet" class="w-full sm:max-w-xs" />
    </div>

    <x-table>
        <x-slot name="head">
            <x-table.head>Nama</x-table.head>
            <x-table.head>Alamat</x-table.head>
            <x-table.head>Telepon/HP</x-table.head>
            <x-table.head>Aksi</x-table.head>
        </x-slot>
        <x-slot name="body">
            @forelse ($outlets as $outlet)
                <x-table.row>
                    <x-table.data>{{ $outlet->name }}</x-table.data>
                    <x-table.data>{{ $outlet->address ?? '-' }}</x-table.data>
                    <x-table.data>{{ $outlet->phone ?? '-' }}</x-table.data>
                    <x-table.data>
                        <div class="flex gap-1 sm:gap-2">
                            <flux:button icon="pencil-square" size="xs" variant="primary" color="blue"
                                wire:click="onUpdate('{{ $outlet->id }}', '{{ $outlet->name }}','{{ $outlet->address }}','{{ $outlet->phone }}')"
                                :loading="false" />
                            <flux:button icon="trash" size="xs" variant="danger"
                                wire:click="onDelete('{{ $outlet->id }}','{{ $outlet->name }}')"
                                :loading="false" />
                        </div>
                    </x-table.data>
                </x-table.row>
            @empty
                <tr>
                    <td colspan="9" class="py-2">
                        <p class="text-center text-zinc-500 ">Tidak ada data</p>
                    </td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    <div class="mt-4">
        {{ $outlets->links('components.pagination-custom') }}
    </div>

    {{-- Create --}}
    <flux:modal name="create-outlet" class="md:w-96" @close="resetForm">
        <form wire:submit="create">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Tambah Outlet</flux:heading>
                    <flux:text class="mt-2">Tambahkan outlet baru.</flux:text>
                </div>

                <flux:input wire:model="name" label="Nama*" />
                <flux:input wire:model="phone" label="Telepon/HP" />
                <flux:input wire:model="address" label="Alamat" />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Tambah</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    {{-- Update --}}
    <flux:modal name="update-outlet" class="md:w-96" @close="resetForm">
        <form wire:submit="confirmUpdate">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Ubah Outlet</flux:heading>
                    <flux:text class="mt-2">Ubah data outlet.</flux:text>
                </div>

                <flux:input wire:model="name" label="Nama*" />
                <flux:input wire:model="phone" label="Telepon/HP" />
                <flux:input wire:model="address" label="Alamat" />

                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <form wire:submit="confirmUpdate">
                        <input type="hidden" wire:model="id">
                        <flux:button type="submit" variant="danger">Simpan</flux:button>
                    </form>
                </div>
            </div>
        </form>
    </flux:modal>

    {{-- Delete --}}
    <flux:modal name="delete-outlet" class="min-w-[22rem]" @close="resetForm" @cancel="resetForm">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Outlet?</flux:heading>
                <flux:text class="mt-2">
                    <p>Anda akan menghapus outlet {{ $name }}.</p>
                    <p>Data yang dihapus tidak dapat dikembalikan.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <form wire:submit="confirmDelete">
                    <flux:button type="submit" variant="danger">Hapus</flux:button>
                </form>
            </div>
        </div>
    </flux:modal>
</section>
