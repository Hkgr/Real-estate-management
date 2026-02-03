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
        <tr><th>المالك السابق</th><td>{{ $record->card_previous_owner ?: '—' }}</td></tr>
        <tr><th>حالة العقار</th><td>{{ $record->card_status === 'frozen' ? 'مجمد' : 'فاعل' }}</td></tr>
        <tr><th>تاريخ الشراء</th><td><span class="ltr">{{ optional($record->card_purchase_date)->format('Y-m-d') ?: '—' }}</span></td></tr>
        <tr>
            <th>طريقة الشراء</th>
            <td>
                @php
                    $purchaseMethod = $record->ownerships->first()?->purchase_method;
                @endphp
                {{ $purchaseMethod === 'sale_contract' ? 'عقد بيع' : ($purchaseMethod === 'court_judgment' ? 'حكم قضائي' : '—') }}
            </td>
        </tr>
        <tr><th>المساحة الكلية</th><td><span class="ltr">{{ number_format((float)$record->card_total_area, 2) }}</span> م²</td></tr>
        <tr><th>المساحة المملوكة</th><td><span class="ltr">{{ number_format((float)$record->card_owned_area, 2) }}</span> م²</td></tr>
        <tr><th>الموقع</th><td>{{ $record->card_location }}</td></tr>
        <tr><th>الإحداثيات</th><td><span class="ltr">{{ $record->card_latitude ?: '—' }}</span> , <span class="ltr">{{ $record->card_longitude ?: '—' }}</span></td></tr>
    </table>
</body>
</html>
