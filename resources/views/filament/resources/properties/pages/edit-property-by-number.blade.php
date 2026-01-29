<x-filament-panels::page>
    <div class="px-10">
        <form wire:submit.prevent="save" class="space-y-6">
            {{ $this->form }}

<div class="flex justify-end" style="margin-top: 1rem;">
    <x-filament::button type="submit" icon="heroicon-o-check">
        حفظ التعديلات
    </x-filament::button>
</div>

        </form>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
