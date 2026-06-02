@extends('viewer-new.layouts.app')

@section('page_title', 'بطاقة العقار')
@section('extra_styles')
    @vite(['resources/css/viewer-new/property-show.css'])
@endsection
@section('extra_scripts')
    @vite(['resources/js/viewer-new/property-show.js'])
@endsection
@section('topbar_title', 'بطاقة العقار')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports.properties'))
@section('back_label', 'العودة إلى تقرير العقارات')

@section('content')
    @php
        $empty = '—';
        $formatDate = static fn ($value) => $value ? (method_exists($value, 'format') ? $value->format('Y-m-d') : (string) $value) : '—';
        $formatDateTime = static fn ($value) => $value ? (method_exists($value, 'format') ? $value->format('Y-m-d H:i') : (string) $value) : '—';
        $formatMoney = static fn ($value) => filled($value) && is_numeric($value) ? number_format((float) $value, 2) . ' $' : '—';
        $formatNumber = static fn ($value) => filled($value) && is_numeric($value) ? number_format((float) $value, 2) : '—';
        $valueOrEmpty = static fn ($value) => filled((string) ($value ?? '')) ? $value : '—';

        $recordNumber = $valueOrEmpty($property->card_record_number ?? null);
        $propertyTitle = $valueOrEmpty($property->property_name ?? null);
        $propertyNotes = trim((string) ($property->card_property_details ?? ''));
        $mapUrl = null;
        if (filled($property->card_google_maps_url)) {
            $candidateMapUrl = trim((string) $property->card_google_maps_url);
            $lowerMapUrl = strtolower($candidateMapUrl);
            if (str_starts_with($lowerMapUrl, 'http://') || str_starts_with($lowerMapUrl, 'https://')) {
                $mapUrl = $candidateMapUrl;
            }
        }

        $areaUnitRaw = strtolower((string) ($property->card_area_unit ?? ''));
        $areaUnit = match ($areaUnitRaw) {
            'meters', 'square_meter' => 'م²',
            'shares' => 'سهم',
            'percentage' => '%',
            default => filled($areaUnitRaw) ? $property->card_area_unit : '—',
        };

        $statusRaw = (string) ($property->card_status ?? '');
        $statusNormalized = strtolower(trim($statusRaw));
        $statusClass = 'vn-property-show-status--muted';
        $statusLabel = filled($statusRaw) ? $statusRaw : '—';
        if (in_array($statusNormalized, ['active', 'نشط'], true)) {
            $statusClass = 'vn-property-show-status--success';
            $statusLabel = 'نشط';
        } elseif (in_array($statusNormalized, ['frozen', 'مجمد'], true)) {
            $statusClass = 'vn-property-show-status--warning';
            $statusLabel = 'مجمد';
        } elseif (in_array($statusNormalized, ['sold', 'closed', 'cancelled', 'مباع', 'مغلق', 'ملغى'], true)) {
            $statusClass = 'vn-property-show-status--danger';
        }

        $details = [
            ['label' => 'ID العقار', 'value' => $property->id ?? '—'],
            ['label' => 'اسم العقار', 'value' => $propertyTitle],
            ['label' => 'رقم المحضر', 'value' => $recordNumber],
            ['label' => 'رقم العقار', 'value' => $valueOrEmpty($property->card_property_number ?? null)],
            ['label' => 'الدولة', 'value' => $valueOrEmpty($property->property_country ?? null)],
            ['label' => 'المحافظة', 'value' => $valueOrEmpty($property->card_governorate ?? null)],
            ['label' => 'المنطقة', 'value' => $valueOrEmpty($property->card_region_name ?? null)],
            ['label' => 'التقسيم', 'value' => $valueOrEmpty($property->card_subdivision ?? null)],
            ['label' => 'المساحة', 'value' => $formatNumber($property->card_total_area ?? null)],
            ['label' => 'وحدة المساحة', 'value' => $areaUnit],
            ['label' => 'نوع الاستثمار', 'value' => $valueOrEmpty($property->card_investment_type ?? null)],
            ['label' => 'طريقة الشراء', 'value' => $valueOrEmpty($property->card_purchase_method ?? null)],
            ['label' => 'تاريخ البيع', 'value' => $formatDate($property->card_sale_date ?? null)],
            ['label' => 'آخر تحديث', 'value' => $formatDateTime($property->updated_at ?? null)],
        ];

        $financialDetails = [
            ['label' => 'القيمة الإجمالية', 'value' => $formatMoney($property->total_property_value_usd ?? null)],
            ['label' => 'القيمة المملوكة', 'value' => $formatMoney($property->owned_property_value_usd ?? null)],
            ['label' => 'السعر الفعلي', 'value' => $formatMoney($property->actual_price_usd ?? null)],
            ['label' => 'السعر التقريبي', 'value' => $formatMoney($property->estimated_price_usd ?? null)],
            ['label' => 'الرصيد النهائي', 'value' => $formatMoney($property->final_balance ?? null)],
            ['label' => 'إجمالي أسهم العمليات', 'value' => $formatNumber($property->operations_total_shares ?? null)],
        ];
    @endphp

    <section class="vn-property-show" aria-labelledby="vn-property-show-title" data-property-print-root data-property-id="{{ $property->id ?? '' }}" data-property-record-number="{{ $recordNumber }}">
        <header class="vn-property-show__hero">
            <div>
                <div class="vn-property-show__actions" data-print-exclude>
                    <a href="{{ route('viewer-new.reports.properties') }}" class="vn-property-show__back">← العودة إلى تقرير العقارات</a>
                    <button type="button" class="vn-property-show__pdf-button" data-property-pdf-export aria-label="تصدير بطاقة العقار بصيغة PDF">تصدير PDF</button>
                </div>
                <p class="vn-property-show__eyebrow">بطاقة عقار مستقلة</p>
                <h1 id="vn-property-show-title">بطاقة العقار</h1>
                <p class="vn-property-show__record">رقم المحضر: <strong>{{ $recordNumber }}</strong></p>
                @if ($propertyTitle !== '—')
                    <p class="vn-property-show__subtitle">{{ $propertyTitle }}</p>
                @else
                    <p class="vn-property-show__subtitle">عقار رقم {{ $property->id ?? '—' }}</p>
                @endif
            </div>
            <div class="vn-property-show__summary" aria-label="ملخص العقار">
                <span>رقم المحضر</span>
                <strong>{{ $recordNumber }}</strong>
                <span class="vn-property-show-status {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>
        </header>

        <article class="vn-property-show-card" aria-label="تفاصيل العقار الأساسية">
            <div class="vn-property-show-card__head">
                <h2>بيانات العقار</h2>
                @if ($mapUrl)
                    <a href="{{ $mapUrl }}" class="vn-property-show-card__map" target="_blank" rel="noopener noreferrer" aria-label="فتح موقع العقار على الخريطة">الخريطة</a>
                @endif
            </div>
            <div class="vn-property-show-grid">
                @foreach ($details as $detail)
                    <div class="vn-property-show-field">
                        <span>{{ $detail['label'] }}</span>
                        <strong>{{ $detail['value'] }}</strong>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="vn-property-show-card" aria-label="البيانات المالية">
            <div class="vn-property-show-card__head">
                <h2>البيانات المالية</h2>
            </div>
            <div class="vn-property-show-grid vn-property-show-grid--financial">
                @foreach ($financialDetails as $detail)
                    <div class="vn-property-show-field">
                        <span>{{ $detail['label'] }}</span>
                        <strong>{{ $detail['value'] }}</strong>
                    </div>
                @endforeach
            </div>
        </article>

        @if ($property->owners->isNotEmpty())
            <article class="vn-property-show-card" aria-label="الملاك وحصص الملكية">
                <div class="vn-property-show-card__head">
                    <h2>الملاك وحصص الملكية</h2>
                    <span class="vn-property-show-count">{{ number_format($property->owners->count()) }} سجل</span>
                </div>
                <div class="vn-property-show-table-wrap">
                    <table class="vn-property-show-table">
                        <thead>
                            <tr>
                                <th>المالك</th>
                                <th>نوع المالك</th>
                                <th>نسبة الملكية</th>
                                <th>مقياس الملكية</th>
                                <th>حالي</th>
                                <th>طريقة الشراء</th>
                                <th>تاريخ الشراء</th>
                                <th>تاريخ البيع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($property->owners as $owner)
                                @php
                                    $ownerName = filled((string) ($owner->display_name ?? '')) ? $owner->display_name : 'مالك #' . ($owner->id ?? '—');
                                    $pivot = $owner->pivot;
                                @endphp
                                <tr>
                                    <td>{{ $ownerName }}</td>
                                    <td>{{ $valueOrEmpty($owner->owner_type ?? null) }}</td>
                                    <td>{{ $formatNumber($pivot->ownership_percentage ?? null) }}%</td>
                                    <td>{{ $valueOrEmpty($pivot->ownership_metric ?? null) }}</td>
                                    <td>{{ ($pivot->is_current ?? false) ? 'نعم' : 'لا' }}</td>
                                    <td>{{ $valueOrEmpty($pivot->purchase_method ?? null) }}</td>
                                    <td>{{ $formatDate($pivot->purchase_date ?? null) }}</td>
                                    <td>{{ $formatDate($pivot->sale_date ?? null) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        @endif

        @if ($property->operations->isNotEmpty())
            <article class="vn-property-show-card" aria-label="العمليات المرتبطة">
                <div class="vn-property-show-card__head">
                    <h2>العمليات المرتبطة</h2>
                    <span class="vn-property-show-count">{{ number_format($property->operations->count()) }} سجل</span>
                </div>
                <div class="vn-property-show-table-wrap">
                    <table class="vn-property-show-table vn-property-show-table--wide">
                        <thead>
                            <tr>
                                <th>نوع العملية</th>
                                <th>طريقة العملية</th>
                                <th>الكمية</th>
                                <th>الوحدة</th>
                                <th>رقم الدعوى</th>
                                <th>رقم القرار</th>
                                <th>الجهة</th>
                                <th>تاريخ الحكم</th>
                                <th>الملاك السابقون</th>
                                <th>الملاك الجدد</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($property->operations as $operation)
                                @php
                                    $oldOwnersLabel = $operation->oldOwners
                                        ->map(fn ($owner) => $owner->display_name ?: ('مالك #' . ($owner->id ?? '—')))
                                        ->filter()
                                        ->implode('، ');
                                    $newOwnersLabel = $operation->newOwners
                                        ->map(fn ($owner) => $owner->display_name ?: ('مالك #' . ($owner->id ?? '—')))
                                        ->filter()
                                        ->implode('، ');
                                    $operationNotes = filled($operation->judgment_notes ?? null)
                                        ? $operation->judgment_notes
                                        : ($operation->contract_notes ?? null);
                                @endphp
                                <tr>
                                    <td>{{ $valueOrEmpty($operation->operation_type ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($operation->operation_method ?? null) }}</td>
                                    <td>{{ $formatNumber($operation->transaction_amount ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($operation->transaction_unit ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($operation->case_number ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($operation->decision_number ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($operation->authority ?? null) }}</td>
                                    <td>{{ $formatDate($operation->judgment_date ?? null) }}</td>
                                    <td>{{ $oldOwnersLabel ?: '—' }}</td>
                                    <td>{{ $newOwnersLabel ?: '—' }}</td>
                                    <td class="vn-property-show-table__notes">{{ $valueOrEmpty($operationNotes ?? null) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        @endif

        @if ($property->signals->isNotEmpty())
            <article class="vn-property-show-card" aria-label="الإشارات المرتبطة">
                <div class="vn-property-show-card__head">
                    <h2>الإشارات المرتبطة</h2>
                    <span class="vn-property-show-count">{{ number_format($property->signals->count()) }} سجل</span>
                </div>
                <div class="vn-property-show-table-wrap">
                    <table class="vn-property-show-table vn-property-show-table--wide">
                        <thead>
                            <tr>
                                <th>رقم الإشارة</th>
                                <th>نوع الإشارة</th>
                                <th>تاريخ الإشارة</th>
                                <th>صاحب الإشارة</th>
                                <th>المتضرر</th>
                                <th>مصدر الإشارة</th>
                                <th>رقم المصدر</th>
                                <th>تاريخ المصدر</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($property->signals as $signal)
                                <tr>
                                    <td>{{ $valueOrEmpty($signal->signal_id ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($signal->type ?? null) }}</td>
                                    <td>{{ $formatDate($signal->signal_date ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($signal->signal_owners_label ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($signal->signal_victims_label ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($signal->signal_source ?? null) }}</td>
                                    <td>{{ $valueOrEmpty($signal->signal_source_number ?? null) }}</td>
                                    <td>{{ $formatDate($signal->signal_source_date ?? null) }}</td>
                                    <td class="vn-property-show-table__notes">{{ $valueOrEmpty($signal->signal_notes ?? null) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        @endif

        @if ($property->files->isNotEmpty())
            @php $canDownloadPropertyFiles = \Illuminate\Support\Facades\Route::has('property-card-files.download'); @endphp
            <article class="vn-property-show-card" aria-label="المرفقات">
                <div class="vn-property-show-card__head">
                    <h2>المرفقات</h2>
                    <span class="vn-property-show-count">{{ number_format($property->files->count()) }} ملف</span>
                </div>
                <div class="vn-property-show-table-wrap">
                    <table class="vn-property-show-table">
                        <thead>
                            <tr>
                                <th>اسم الملف</th>
                                <th>النوع</th>
                                <th>تاريخ الإصدار</th>
                                <th data-print-exclude>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($property->files as $file)
                                <tr>
                                    <td>{{ $valueOrEmpty($file->file_name ?? null) }}</td>
                                    <td>{{ filled($file->mime_type ?? null) ? $file->mime_type : 'ملف' }}</td>
                                    <td>{{ $formatDate($file->issued_at ?? null) }}</td>
                                    <td data-print-exclude>
                                        @if ($canDownloadPropertyFiles)
                                            <a class="vn-property-show-table__action" href="{{ route('property-card-files.download', $file) }}" aria-label="تحميل المرفق {{ $valueOrEmpty($file->file_name ?? null) }}">تحميل</a>
                                        @else
                                            <span class="vn-property-show-table__muted">غير متاح</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        @endif

        @if ($propertyNotes !== '')
            <article class="vn-property-show-card" aria-label="ملاحظات العقار">
                <div class="vn-property-show-card__head">
                    <h2>ملاحظات</h2>
                </div>
                <p class="vn-property-show-note vn-property-show-note--main">{{ $propertyNotes }}</p>
            </article>
        @endif
    </section>
@endsection
