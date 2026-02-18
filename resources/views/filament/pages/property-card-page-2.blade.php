<x-filament-panels::page>
    <style>
/*        [x-cloak]{ display:none !important; }

        @keyframes fiFadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fi-fade-up { animation: fiFadeUp .45s ease-out both; }
        .fi-delay-1 { animation-delay: .05s; }
        .fi-delay-2 { animation-delay: .12s; }
        .fi-delay-3 { animation-delay: .18s; }

        .fi-soft-hover { transition: transform .2s ease, box-shadow .2s ease; }
        .fi-soft-hover:hover { transform: translateY(-2px); } */
    </style>

    @php
        $recordId      = $currentRecordId;
        $recordNumber  = data_get($this->data, 'card_record_number');
        $governorate   = data_get($this->data, 'card_governorate');
        $regionName    = data_get($this->data, 'card_region_name');
        $status        = data_get($this->data, 'card_status', 'active');
        $investType    = data_get($this->data, 'card_investment_type');
        $mapsUrl       = data_get($this->data, 'card_google_maps_url');
        $finalBalance  = data_get($this->data, 'final_balance');
        $payments     = collect(data_get($this->data, 'payments', []));

        if ($finalBalance === null) {
            $finalBalance = $payments->sum(fn ($row) => (float) ($row['debit'] ?? 0))
                - $payments->sum(fn ($row) => (float) ($row['credit'] ?? 0));
        }

        $finalBalanceValue = (float) $finalBalance;
        $finalBalanceColor = $finalBalanceValue > 0 ? 'success' : ($finalBalanceValue < 0 ? 'danger' : 'gray');
        $finalBalanceLabel = number_format($finalBalanceValue, 2, '.', ',');

    @endphp


                    
    <div dir="rtl"
         x-data="{ mounted: false }"
         x-init="requestAnimationFrame(() => mounted = true)"
        class="space-y-6 rounded-2xl border border-gray-200/70 bg-gradient-to-br from-primary-50/40 via-white to-white p-4 shadow-sm dark:border-gray-700/70 dark:from-gray-900/40 dark:via-gray-900 dark:to-gray-900">
        {{-- Header (animated) --}}
        <x-filament::section
            x-cloak
            x-show="mounted"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="fi-soft-hover border border-gray-200/70 dark:border-gray-700/70"        >
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                <div class="flex items-start gap-3">
                    <div class="mt-0.5">
                        <x-filament::icon icon="heroicon-o-home-modern" class="h-7 w-7 text-primary-600" />
                    </div>

                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="text-lg font-bold text-gray-900 dark:text-white">
                                بطاقة العقار 2
                            </h1>

                            <x-filament::badge :color="$recordId ? 'success' : 'gray'">
                                {{ $recordId ? 'محمّل' : 'غير محمّل' }}
                            </x-filament::badge>

                            <x-filament::badge :color="$status === 'active' ? 'success' : 'warning'">
                                <span class="inline-flex items-center gap-1">
                                    <x-filament::icon
                                        :icon="$status === 'active' ? 'heroicon-o-check-circle' : 'heroicon-o-pause-circle'"
                                        class="h-4 w-4"
                                    />
                                    {{ $status === 'active' ? 'فاعل' : 'مجمد' }}
                                </span>
                            </x-filament::badge>

                            @if ($recordId)
                                <x-filament::badge color="primary">
                                    <span class="inline-flex items-center gap-1">
                                        <x-filament::icon icon="heroicon-o-hashtag" class="h-4 w-4" />
                                        #{{ $recordId }}
                                    </span>
                                </x-filament::badge>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            أدخل رقم المحضر ثم استخدم زر "بحث" من النافذة المنبثقة لتحميل السجل يدويًا، ثم أكمل البيانات ضمن أقسام مرتبة وقابلة للطي.
                        </p>
                       <div class="flex flex-wrap items-center gap-2 text-xs text-gray-600 dark:text-gray-300">
                            <span class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 shadow-sm ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-gray-700">
                                <x-filament::icon icon="heroicon-o-banknotes" class="h-4 w-4" />
                                <span>صافي الرصيد:</span>
                                <span class="{{ $finalBalanceValue > 0 ? 'text-success-600' : ($finalBalanceValue < 0 ? 'text-danger-600' : 'text-gray-600') }} font-semibold">
                                    $ {{ $finalBalanceLabel }}
                                </span>
                            </span>
                        </div>

                    </div>
                </div>

                {{-- Quick chips --}}
                <div class="flex flex-wrap items-center gap-2">
                    @if (filled($recordNumber))
                        <x-filament::badge color="gray">
                            <span class="inline-flex items-center gap-1">
                                <x-filament::icon icon="heroicon-o-key" class="h-4 w-4" />
                                {{ $recordNumber }}
                            </span>
                        </x-filament::badge>
                    @endif

                    @if (filled($governorate))
                        <x-filament::badge color="gray">
                            <span class="inline-flex items-center gap-1">
                                <x-filament::icon icon="heroicon-o-map" class="h-4 w-4" />
                                {{ $governorate }}
                            </span>
                        </x-filament::badge>
                    @endif

                    @if (filled($regionName))
                        <x-filament::badge color="gray">
                            <span class="inline-flex items-center gap-1">
                                <x-filament::icon icon="heroicon-o-map-pin" class="h-4 w-4" />
                                {{ $regionName }}
                            </span>
                        </x-filament::badge>
                    @endif

                    @if (filled($investType))
                        <x-filament::badge color="info">
                            <span class="inline-flex items-center gap-1">
                                <x-filament::icon icon="heroicon-o-building-office-2" class="h-4 w-4" />
                                {{ $investType }}
                            </span>
                        </x-filament::badge>
                    @endif

                    @if (filled($mapsUrl))
                        <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="no-underline">
                            <x-filament::badge color="primary">
                                <span class="inline-flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-o-globe-alt" class="h-4 w-4" />
                                    فتح الخريطة
                                </span>
                            </x-filament::badge>
                        </a>
                    @endif
                    <x-filament::badge :color="$finalBalanceColor">
                        <span class="inline-flex items-center gap-1">
                            <x-filament::icon icon="heroicon-o-currency-dollar" class="h-4 w-4" />
                            صافي الرصيد: $ {{ $finalBalanceLabel }}
                        </span>
                    </x-filament::badge>

                </div>
            </div>
        </x-filament::section>

        {{-- Sticky toolbar (animated) --}}
        <x-filament::section
            class="sticky top-2 z-20 fi-soft-hover border border-gray-200/70 dark:border-gray-700/70"
        x-cloak
            x-show="mounted"
            x-transition:enter="transition ease-out duration-500 delay-75"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <x-filament::icon icon="heroicon-o-information-circle" class="h-5 w-5 text-gray-500" />
                    <span>رفع الملفات متاح قبل/بعد الإنشاء، والتعديل عبر زر “تعديل”.</span>

                    <div wire:loading class="inline-flex items-center gap-2 ms-3">
                        <span class="text-xs text-gray-500">جارٍ المعالجة...</span>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end gap-2">
                    {{ $this->searchAction() }}
                    {{ $this->createAction() }}
                    {{ $this->updateAction() }}
                    {{ $this->deleteAction() }}
               {{--     {{ $this->uploadFileAction() }}
                    {{ $this->pdfBrowserAction() }}         --}}  
                </div>
            </div>
        </x-filament::section>

        {{-- Form (animated) --}}
        <x-filament::section
            class="sticky top-2 z-20 fi-soft-hover border border-gray-200/70 dark:border-gray-700/70"
        x-cloak
            x-show="mounted"
            x-transition:enter="transition ease-out duration-500 delay-150"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            {{ $this->form }}
                    <x-filament::section
            class="sticky top-2 z-20 fi-soft-hover border border-gray-200/70 dark:border-gray-700/70"
        x-cloak
            x-show="mounted"
            x-transition:enter="transition ease-out duration-500 delay-75"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <x-filament::icon icon="heroicon-o-information-circle" class="h-5 w-5 text-gray-500" />
                    <span>رفع الملفات متاح قبل/بعد الإنشاء، والتعديل عبر زر “تعديل”.</span>

                    <div wire:loading class="inline-flex items-center gap-2 ms-3">
                        <span class="text-xs text-gray-500">جارٍ المعالجة...</span>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end gap-2">
                    {{ $this->createAction() }}
                    {{ $this->searchAction() }}
                    {{ $this->updateAction() }}
                    {{ $this->deleteAction() }}
               {{--     {{ $this->uploadFileAction() }}
                    {{ $this->pdfBrowserAction() }}         --}}  
                </div>
            </div>
        </x-filament::section>
        </x-filament::section>


    </div>
    
</x-filament-panels::page>


