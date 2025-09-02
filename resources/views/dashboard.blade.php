<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @if (!auth()->user()->company_id)
                <div class="relative">
                    <flux:callout class="h-full">
                        <flux:callout.heading></flux:callout.heading>
                        <flux:callout.text>
                            Anda belum mengatur informasi Bisnis/Usaha Anda. Silahkan atur terlebih dahulu.
                        </flux:callout.text>

                        <x-slot name="actions">
                            <flux:button href="{{ route('settings.company') }}" icon:trailing="arrow-up-right">
                                Atur sekarang
                            </flux:button>
                        </x-slot>
                    </flux:callout>
                </div>
            @endif
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
