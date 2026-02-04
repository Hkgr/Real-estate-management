<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        @page { size: A4; margin: 12mm 10mm; }

        body { font-family: cairo, sans-serif; direction: rtl; text-align: right; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f5f5f5; width: 28%; }
        .title { font-size: 18px; font-weight: 700; margin: 0 0 10px; }
        .meta { margin: 0 0 14px; color: #555; }
        .ltr { direction: ltr; unicode-bidi: isolate; display: inline-block; }
        .sep { margin: 0 8px; color: #777; }
    </style>
</head>
<body>
    <div class="title">بطاقة العقار</div>

    <div class="meta">
        رقم المحضر:
        <strong class="ltr">{{ $record->card_record_number }}</strong>
    </div>

    <table>
        <tr><th>المحافظة</th><td>{{ $record->card_governorate }}</td></tr>
        <tr><th>اسم المنطقة</th><td>{{ $record->card_region_name }}</td></tr>
        <tr><th>المقسم</th><td>{{ $record->card_subdivision ?: '—' }}</td></tr>
        <tr><th>حالة العقار</th><td>{{ $record->card_status === 'frozen' ? 'مجمد' : 'فاعل' }}</td></tr>
        <tr><th>نوع الاستثمار</th><td>{{ $record->card_investment_type ?: '—' }}</td></tr>
        <tr>
            <th>طريقة الشراء</th>
            <td>
                @php
                    $purchaseMethodLabel = match ($record->card_purchase_method) {
                        'regular_contract' => 'عقد عادي',
                        'court_judgment' => 'حكم قضائي',
                        'commercial_register_contract' => 'عقد سجل تجاري',
                        default => '—',
                    };
                    $areaUnitLabel = match ($record->card_area_unit) {
                        'percentage' => '%',
                        'shares' => 'سهم',
                        default => 'م²',
                    };
                @endphp
                {{ $purchaseMethodLabel }}
            </td>
        </tr>
        <tr><th>المساحة الكلية</th><td><span class="ltr">{{ number_format((float)$record->card_total_area, 2) }}</span> {{ $areaUnitLabel }}</td></tr>
        <tr><th>تفصيل العقار</th><td>{{ $record->card_property_details ?: '—' }}</td></tr>
        <tr>
            <th>رابط خريطة Google</th>
            <td>
                @if (filled($record->card_google_maps_url))
                    <a href="{{ $record->card_google_maps_url }}" class="ltr" target="_blank" rel="noopener">
                        {{ $record->card_google_maps_url }}
                    </a>
                @else
                    —
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
