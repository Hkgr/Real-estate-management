<x-filament-panels::page>
    <div class="space-y-5">
        <div dir="rtl" class="w-full flex flex-wrap items-center justify-end gap-6 py-2 m-5">
            {{ $this->createAction() }}
            {{ $this->searchAction() }}
            {{ $this->updateAction() }}
            {{ $this->deleteAction() }}

            <x-filament::badge color="gray" class="ml-4 px-3 py-1">
                {{ $currentRecordId ? ('محمّل: #' . $currentRecordId) : 'لا يوجد سجل محمّل' }}
            </x-filament::badge>
        </div>

        <x-filament::section>
            {{ $this->form }}
        </x-filament::section>
    </div>
</x-filament-panels::page>
