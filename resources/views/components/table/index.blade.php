<div class="relative overflow-x-auto mt-5 rounded-lg border border-zinc-200 dark:border-zinc-700">
    <table class="w-full text-sm text-left text-zinc-500 dark:text-zinc-400">
        <thead class="text-xs text-zinc-700 uppercase bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-400">
            <tr>
                @isset($head)
                    {{ $head }}
                @endisset
            </tr>
        </thead>
        <tbody>
            @isset($body)
                {{ $body }}
            @endisset
        </tbody>
    </table>
</div>
