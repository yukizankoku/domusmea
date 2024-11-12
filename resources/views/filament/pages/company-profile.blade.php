<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }} <!-- Menampilkan form yang didefinisikan di getFormSchema -->

        @if (!$isReadonly)
            <x-filament::button type="submit" class="mt-4">
                Simpan Perubahan
            </x-filament::button>
        @endif
    </form>
</x-filament-panels::page>
