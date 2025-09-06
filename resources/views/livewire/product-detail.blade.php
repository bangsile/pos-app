<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Produk - {{ $details[0]->product->name }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">Detail Stok dan Harga</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <x-notification class="mb-3" />

    <flux:button href="{{ route('product.index') }}" variant="primary" wire:navigate>Kembali</flux:button>

    <x-table>
        <x-slot name="head">
            <x-table.head>Outlet</x-table.head>
            <x-table.head>Harga</x-table.head>
            <x-table.head>Jumlah Stok</x-table.head>
        </x-slot>
        <x-slot name="body">
            @forelse ($details as $detail)
                <x-table.row>
                    <x-table.data>{{ $detail->outlet->name }}</x-table.data>
                    <x-table.data>{{ formatRupiah($detail->price) }}</x-table.data>
                    <x-table.data>{{ $detail->stock }}</x-table.data>
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
        {{ $details->links('components.pagination-custom') }}
    </div>
</section>
