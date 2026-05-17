<x-filament-panels::page>
    {{-- شريط البحث --}}
    {{ $this->form }}

    @php
        $p = $this->property;
        $loc = (string) ($p->location ?? '');
        $date = optional($p->purchase_date)->format('d/m/Y');
        $maps = ($p->latitude && $p->longitude) ? ('https://www.google.com/maps?q=' . $p->latitude . ',' . $p->longitude) : null;

        $fields = [
            [
                'label' => 'اسم المنطقة',
                'value' => $p->region_name,
                'icon' => 'heroicon-o-map',
                'icon_class' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300',
            ],
            [
                'label' => 'رقم المنطقة العقارية',
                'value' => $p->cadastral_zone_number,
                'icon' => 'heroicon-o-identification',
                'icon_class' => 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-300',
            ],
            [
                'label' => 'المساحة الكلية',
                'value' => $p->total_area,
                'format' => fn ($value) => number_format((float) $value, 2) . ' م²',
                'icon' => 'heroicon-o-arrows-pointing-out',
                'icon_class' => 'bg-sky-50 text-sky-600 dark:bg-sky-500/10 dark:text-sky-300',
            ],
            [
                'label' => 'المساحة المملوكة',
                'value' => $p->owned_area,
                'format' => fn ($value) => number_format((float) $value, 2) . ' م²',
                'icon' => 'heroicon-o-arrows-pointing-in',
                'icon_class' => 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-300',
            ],
            [
                'label' => 'نسبة الملكية',
                'value' => $p->ownership_percentage,
                'format' => fn ($value) => number_format((float) $value, 2) . '%',
                'icon' => 'heroicon-o-chart-pie',
                'icon_class' => 'bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-300',
            ],
            [
                'label' => 'تاريخ الشراء',
                'value' => $date,
                'icon' => 'heroicon-o-calendar-days',
                'icon_class' => 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-300',
            ],
        ];
    @endphp

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            بطاقة العقار
        </x-slot>

        <x-slot name="description">
            تنظيم الحقول الأساسية مع إظهار العناصر المتوفرة فقط.
        </x-slot>

        <x-slot name="headerEnd">
            <x-filament::badge color="primary" icon="heroicon-o-home">
                #{{ $p->property_number }}
            </x-filament::badge>
        </x-slot>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">             @foreach ($fields as $field)
                @php
                    $value = $field['value'] ?? null;
                    $display = $value;
                    if (! is_null($value) && ($field['format'] ?? null)) {
                        $display = $field['format']($value);
                    }
                @endphp

                @if (! is_null($value) && $value !== '')
                    <x-filament::card class="h-full border border-gray-200/70 bg-white/80 shadow-sm dark:border-gray-800 dark:bg-gray-900/40">
                        <div class="flex items-start gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ $field['icon_class'] }}">
                                <x-filament::icon icon="{{ $field['icon'] }}" class="h-5 w-5" />
                            </span>
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ $field['label'] }}
                                </p>
                                <p class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $display }}
                                </p>
                            </div>
                        </div>
                    </x-filament::card>
                @endif
            @endforeach

            @if ($loc !== '' || $maps)
                <x-filament::card class="space-y-3 border border-amber-100/80 bg-amber-50/60 shadow-sm dark:border-amber-500/10 dark:bg-gray-900/40">
                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300">
                            <x-filament::icon icon="heroicon-o-map-pin" class="h-4 w-4" />
                        </span>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">موقع العقار</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">تفاصيل العنوان</p>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                        @if ($loc === '')
                            —
                        @elseif (str_starts_with($loc, 'http://') || str_starts_with($loc, 'https://'))
                            <a class="text-primary-600 hover:text-primary-500 underline underline-offset-4" href="{{ $loc }}" target="_blank" rel="noopener">
                                فتح الرابط
                            </a>
                        @else
                            {{ $loc }}
                        @endif
                    </div>
                    @if ($maps)
                        <div>
                            <a class="text-primary-600 hover:text-primary-500 text-sm font-semibold underline underline-offset-4" href="{{ $maps }}" target="_blank" rel="noopener">
                                فتح الإحداثيات على الخرائط
                            </a>
                        </div>
                    @endif
                </x-filament::card>
            @endif

            @if (! is_null($p->latitude) || ! is_null($p->longitude))
                <x-filament::card class="space-y-2 border border-sky-100/80 bg-sky-50/60 shadow-sm dark:border-sky-500/10 dark:bg-gray-900/40">
                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-100 text-sky-700 dark:bg-sky-500/10 dark:text-sky-300">
                            <x-filament::icon icon="heroicon-o-globe-alt" class="h-4 w-4" />
                        </span>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">الإحداثيات</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">خط العرض والطول</p>
                        </div>
                    </div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        Lat: {{ $p->latitude ?? '—' }} | Lng: {{ $p->longitude ?? '—' }}
                    </p>
                </x-filament::card>
            @endif
        </x-filament::grid>
    </x-filament::section>

    <x-filament-actions::modals />
</x-filament-panels::page>
