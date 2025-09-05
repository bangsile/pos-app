<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Kategori</flux:heading>
        <flux:subheading size="lg" class="mb-6">Daftar Kategori Produk</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <x-notification class="mb-3" />

    <div class="flex flex-col-reverse sm:flex-row gap-3 justify-between">
        <flux:modal.trigger name="create-category">
            <flux:button :loading="false" variant="primary">Tambah Kategori</flux:button>
        </flux:modal.trigger>

        <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Cari kategori"
            class="w-full sm:max-w-xs" />
    </div>

    <x-table>
        <x-slot name="head">
            <x-table.head>Nama</x-table.head>
            <x-table.head>Jumlah Produk</x-table.head>
            <x-table.head>Aksi</x-table.head>
        </x-slot>
        <x-slot name="body">
            @forelse ($categories as $category)
                <x-table.row>
                    <x-table.data>{{ $category->name }}</x-table.data>
                    <x-table.data>
                        {{ $category->products->count() }}
                    </x-table.data>
                    <x-table.data>
                        <div class="flex gap-1 sm:gap-2">
                            <flux:button icon="pencil-square" size="xs" variant="primary" color="blue"
                                wire:click="onUpdate('{{ $category->id }}', '{{ $category->name }}')"
                                :loading="false" />
                            <flux:button icon="trash" size="xs" variant="danger"
                                wire:click="onDelete('{{ $category->id }}','{{ $category->name }}')"
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
        {{ $categories->links('components.pagination-custom') }}
    </div>

    {{-- Create --}}
    <flux:modal name="create-category" class="md:w-96" @close="resetForm">
        <form wire:submit="create">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Tambah Kategori</flux:heading>
                    <flux:text class="mt-2">Tambahkan kategori baru.</flux:text>
                </div>

                <flux:input wire:model="name" label="Nama" />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Tambah</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    {{-- Update --}}
    <flux:modal name="update-category" class="md:w-96" @close="resetForm">
        <form wire:submit="confirmUpdate">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Ubah Kategori</flux:heading>
                    <flux:text class="mt-2">Ubah data kategori.</flux:text>
                </div>

                <flux:input wire:model="name" label="Nama" />

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
    <flux:modal name="delete-category" class="min-w-[22rem]" @close="resetForm" @cancel="resetForm">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Kategori?</flux:heading>
                <flux:text class="mt-2">
                    <p>Anda akan menghapus kategori {{ $name }}.</p>
                    <p>Menghapus kategori juga akan menghapus semua produk yang termasuk di dalamnya.</p>
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
