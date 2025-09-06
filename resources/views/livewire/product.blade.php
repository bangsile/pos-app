<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Produk</flux:heading>
        <flux:subheading size="lg" class="mb-6">Daftar Produk</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <x-notification class="mb-3" />

    <div class="grid grid-cols-2 gap-2">
        <div class="w-20 order-1">
            <flux:select wire:model.live="perPage" class="">
                <flux:select.option value="10">10</flux:select.option>
                <flux:select.option value="20">20</flux:select.option>
                <flux:select.option value="30">50</flux:select.option>
            </flux:select>
        </div>
        <div class="justify-self-end order-2">
            <flux:select wire:model.live="filterCategory">
                <flux:select.option value="" wire:key="all">Semua Kategori</flux:select.option>
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}" wire:key="{{ $category->id }}">
                        {{ $category->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <div class="col-span-2 sm:col-span-1 items-stretch order-4 sm:order-3">
            <flux:modal.trigger name="create-product">
                <flux:button :loading="false" variant="primary" class="w-full sm:w-auto">Tambah Produk
                </flux:button>
            </flux:modal.trigger>
        </div>
        <div class="col-span-2 sm:col-span-1 sm:justify-self-end order-3 sm:order-4">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Cari produk"
                class="w-full sm:w-xs" />
        </div>
    </div>

    <x-table>
        <x-slot name="head">
            <x-table.head>Kode Produk</x-table.head>
            <x-table.head>Nama</x-table.head>
            <x-table.head>Barcode</x-table.head>
            <x-table.head>Kategori</x-table.head>
            <x-table.head>Aksi</x-table.head>
        </x-slot>
        <x-slot name="body">
            @forelse ($products as $product)
                <x-table.row>
                    <x-table.data>{{ $product->code }}</x-table.data>
                    <x-table.data>{{ $product->name }}</x-table.data>
                    <x-table.data>{{ $product->barcode ?? '-' }}</x-table.data>
                    <x-table.data>{{ $product->category->name }}</x-table.data>
                    <x-table.data>
                        <div class="flex gap-1 sm:gap-2">
                            <flux:button icon="pencil-square" size="xs" variant="primary" color="blue"
                                wire:click="onUpdate('{{ $product->id }}', '{{ $product->name }}',
                                '{{ $product->code }}','{{ $product->barcode }}','{{ $product->category->id }}')"
                                :loading="false" />
                            <flux:button icon="trash" size="xs" variant="danger"
                                wire:click="onDelete('{{ $product->id }}','{{ $product->name }}')"
                                :loading="false" />
                            <flux:button size="xs" variant="primary" href="{{ route('product.detail',$product->code) }}" wire:navigate>
                                Detail
                            </flux:button>
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
        {{ $products->links('components.pagination-custom') }}
    </div>

    {{-- Create --}}
    <flux:modal name="create-product" class="md:w-96" @close="resetForm">
        <form wire:submit="create">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Tambah Produk</flux:heading>
                    <flux:text class="mt-2">Tambahkan produk baru.</flux:text>
                </div>

                <flux:input wire:model="code" label="Kode Produk*" />
                <flux:input wire:model="name" label="Nama*" />
                <flux:input wire:model="barcode" label="Barcode" />
                <flux:field>
                    <flux:label>Kategori*</flux:label>
                    <flux:select wire:model="categoryId" placeholder="Pilih kategori">
                        @foreach ($categories as $category)
                            <flux:select.option value="{{ $category->id }}" wire:key="{{ $category->id }}">
                                {{ $category->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="categoryId" />
                </flux:field>

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Tambah</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    {{-- Update --}}
    <flux:modal name="update-product" class="md:w-96" @close="resetForm">
        <form wire:submit="confirmUpdate">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Ubah Produk</flux:heading>
                    <flux:text class="mt-2">Ubah data produk.</flux:text>
                </div>

                <flux:input wire:model="code" label="Kode Produk*" />
                <flux:input wire:model="name" label="Nama*" />
                <flux:input wire:model="barcode" label="Barcode" />
                <flux:field>
                    <flux:label>Kategori*</flux:label>
                    <flux:select wire:model="categoryId" placeholder="Pilih kategori">
                        @foreach ($categories as $category)
                            <flux:select.option value="{{ $category->id }}" wire:key="{{ $category->id }}">
                                {{ $category->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="categoryId" />
                </flux:field>

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
    <flux:modal name="delete-product" class="min-w-[22rem]" @close="resetForm" @cancel="resetForm">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Produk?</flux:heading>
                <flux:text class="mt-2">
                    <p>Anda akan menghapus produk {{ $name }}.</p>
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
