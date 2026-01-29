<x-filament-panels::page>
    <style>
        :root{
            --rwad:#f25f2c;
            --bd: rgba(0,0,0,.10);
            --muted: rgba(0,0,0,.60);
        }
        .dark :root{
            --bd: rgba(255,255,255,.12);
            --muted: rgba(255,255,255,.65);
        }
        .rwad-box{
            border:1px solid var(--bd);
            border-radius:16px;
            padding:16px;
            background: rgba(255,255,255,.70);
            backdrop-filter: blur(10px);
        }
        .dark .rwad-box{ background: rgba(17,24,39,.55); }

        .rwad-title{
            font-weight: 800;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .rwad-title b{ color: var(--rwad); }

        .rwad-row{
            display:flex;
            justify-content:space-between;
            gap: 12px;
            padding: 10px 0;
            border-top: 1px solid var(--bd);
        }
        .rwad-row:first-of-type{ border-top:0; padding-top:0; }
        .rwad-k{ font-size:12px; color: var(--muted); }
        .rwad-v{ font-size:13px; font-weight:700; word-break:break-word; }
        .rwad-link{ color: var(--rwad); font-weight:800; text-decoration: underline; text-underline-offset: 4px; }
    </style>

    {{-- شريط البحث --}}
    {{ $this->form }}

    @php
        $p = $this->property;
        $loc = (string) ($p->location ?? '');
        $date = optional($p->purchase_date)->format('Y-m-d') ?? '—';
        $maps = ($p->latitude && $p->longitude) ? ('https://www.google.com/maps?q='.$p->latitude.','.$p->longitude) : null;
    @endphp

    <div class="rwad-box" style="margin-top:14px;">
        <div class="rwad-title">
            عرض العقار <b>#{{ $p->property_number }}</b>
        </div>

        <div class="rwad-row">
            <div class="rwad-k">اسم المنطقة</div>
            <div class="rwad-v">{{ $p->region_name }}</div>
        </div>

        <div class="rwad-row">
            <div class="rwad-k">رقم المنطقة العقارية</div>
            <div class="rwad-v">{{ $p->cadastral_zone_number }}</div>
        </div>

        <div class="rwad-row">
            <div class="rwad-k">المساحة الكلية</div>
            <div class="rwad-v">{{ number_format((float) $p->total_area, 2) }} م²</div>
        </div>

        <div class="rwad-row">
            <div class="rwad-k">المساحة المملوكة</div>
            <div class="rwad-v">{{ number_format((float) $p->owned_area, 2) }} م²</div>
        </div>

        <div class="rwad-row">
            <div class="rwad-k">نسبة الملكية</div>
            <div class="rwad-v">{{ number_format((float) $p->ownership_percentage, 2) }}%</div>
        </div>

        <div class="rwad-row">
            <div class="rwad-k">تاريخ الشراء</div>
            <div class="rwad-v">{{ $date }}</div>
        </div>

        <div class="rwad-row">
            <div class="rwad-k">موقع العقار</div>
            <div class="rwad-v">
                @if($loc === '')
                    —
                @elseif(str_starts_with($loc, 'http://') || str_starts_with($loc, 'https://'))
                    <a class="rwad-link" href="{{ $loc }}" target="_blank" rel="noopener">فتح الرابط</a>
                @else
                    {{ $loc }}
                @endif
                @if($maps)
                    <div style="margin-top:6px;">
                        <a class="rwad-link" href="{{ $maps }}" target="_blank" rel="noopener">فتح الإحداثيات على الخرائط</a>
                    </div>
                @endif
            </div>
        </div>

        @if(!is_null($p->latitude) || !is_null($p->longitude))
            <div class="rwad-row">
                <div class="rwad-k">الإحداثيات</div>
                <div class="rwad-v">Lat: {{ $p->latitude ?? '—' }} | Lng: {{ $p->longitude ?? '—' }}</div>
            </div>
        @endif
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
