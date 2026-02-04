<x-filament-panels::page>
    {{-- شريط البحث --}}
    {{ $this->form }}

    @php
        $p = $this->property;
        $loc = (string) ($p->location ?? '');
        $date = optional($p->purchase_date)->format('Y-m-d');
        $maps = ($p->latitude && $p->longitude) ? ('https://www.google.com/maps?q=' . $p->latitude . ',' . $p->longitude) : null;

        $fields = [
            [
                'label' => 'اسم المنطقة',
                'value' => $p->region_name,
            ],
            [
                'label' => 'رقم المنطقة العقارية',
                'value' => $p->cadastral_zone_number,
            ],
            [
                'label' => 'المساحة الكلية',
                'value' => $p->total_area,
                'format' => fn ($value) => number_format((float) $value, 2) . ' م²',
            ],
            [
                'label' => 'المساحة المملوكة',
                'value' => $p->owned_area,
                'format' => fn ($value) => number_format((float) $value, 2) . ' م²',
            ],
            [
                'label' => 'نسبة الملكية',
                'value' => $p->ownership_percentage,
                'format' => fn ($value) => number_format((float) $value, 2) . '%',
            ],
            [
                'label' => 'تاريخ الشراء',
                'value' => $date,
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

        <x-filament::grid default="1" md="2" xl="3" class="gap-4">
            @foreach ($fields as $field)
                @php
                    $value = $field['value'] ?? null;
                    $display = $value;
                    if (! is_null($value) && ($field['format'] ?? null)) {
                        $display = $field['format']($value);
                    }
                @endphp

                @if (! is_null($value) && $value !== '')
                    <x-filament::card class="space-y-1 bg-gray-50/70 dark:bg-gray-900/40">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            {{ $field['label'] }}
                        </p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $display }}
                        </p>
                    </x-filament::card>
                @endif
            @endforeach

            @if ($loc !== '' || $maps)
                <x-filament::card class="space-y-2 bg-amber-50/60 dark:bg-gray-900/40">
                    <div class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-o-map-pin" class="h-4 w-4 text-amber-600" />
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">موقع العقار</p>
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
                <x-filament::card class="space-y-1 bg-sky-50/60 dark:bg-gray-900/40">
                    <div class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-o-globe-alt" class="h-4 w-4 text-sky-600" />
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">الإحداثيات</p>
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
