@extends('viewer-new.layouts.app')

@section('page_title', 'بطاقة العقار')
@section('extra_styles')
    @vite(['resources/css/viewer-new/property-show.css'])
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

    <section class="vn-property-show" aria-labelledby="vn-property-show-title">
        <header class="vn-property-show__hero">
            <div>
                <a href="{{ route('viewer-new.reports.properties') }}" class="vn-property-show__back">← العودة إلى تقرير العقارات</a>
                <p class="vn-property-show__eyebrow">بطاقة عقار مستقلة</p>
                <h1 id="vn-property-show-title">بطاقة العقار</h1>
                <p class="vn-property-show__subtitle">{{ $propertyTitle !== '—' ? $propertyTitle : 'عقار رقم ' . ($property->id ?? '—') }}</p>
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
                <div class="vn-property-show-list">
                    @foreach ($property->owners as $owner)
                        @php
                            $ownerName = filled((string) ($owner->display_name ?? '')) ? $owner->display_name : 'مالك #' . $owner->id;
                            $pivot = $owner->pivot;
                        @endphp
                        <section class="vn-property-show-list-item">
                            <div>
                                <h3>{{ $ownerName }}</h3>
                                <p>{{ $valueOrEmpty($owner->owner_type ?? null) }}</p>
                            </div>
                            <dl>
                                <div><dt>نسبة الملكية</dt><dd>{{ $formatNumber($pivot->ownership_percentage ?? null) }}%</dd></div>
                                <div><dt>مقياس الملكية</dt><dd>{{ $valueOrEmpty($pivot->ownership_metric ?? null) }}</dd></div>
                                <div><dt>حالي</dt><dd>{{ ($pivot->is_current ?? false) ? 'نعم' : 'لا' }}</dd></div>
                                <div><dt>طريقة الشراء</dt><dd>{{ $valueOrEmpty($pivot->purchase_method ?? null) }}</dd></div>
                                <div><dt>تاريخ الشراء</dt><dd>{{ $formatDate($pivot->purchase_date ?? null) }}</dd></div>
                                <div><dt>تاريخ البيع</dt><dd>{{ $formatDate($pivot->sale_date ?? null) }}</dd></div>
                            </dl>
                        </section>
                    @endforeach
                </div>
            </article>
        @endif

        @if ($property->operations->isNotEmpty())
            <article class="vn-property-show-card" aria-label="العمليات المرتبطة">
                <div class="vn-property-show-card__head">
                    <h2>العمليات المرتبطة</h2>
                    <span class="vn-property-show-count">{{ number_format($property->operations->count()) }} سجل</span>
                </div>
                <div class="vn-property-show-list">
                    @foreach ($property->operations as $operation)
                        <section class="vn-property-show-list-item">
                            <div>
                                <h3>{{ $valueOrEmpty($operation->operation_type ?? null) }}</h3>
                                <p>{{ $valueOrEmpty($operation->operation_method ?? null) }}</p>
                            </div>
                            <dl>
                                <div><dt>الكمية</dt><dd>{{ $formatNumber($operation->transaction_amount ?? null) }}</dd></div>
                                <div><dt>الوحدة</dt><dd>{{ $valueOrEmpty($operation->transaction_unit ?? null) }}</dd></div>
                                <div><dt>رقم الدعوى</dt><dd>{{ $valueOrEmpty($operation->case_number ?? null) }}</dd></div>
                                <div><dt>رقم القرار</dt><dd>{{ $valueOrEmpty($operation->decision_number ?? null) }}</dd></div>
                                <div><dt>الجهة</dt><dd>{{ $valueOrEmpty($operation->authority ?? null) }}</dd></div>
                                <div><dt>تاريخ الحكم</dt><dd>{{ $formatDate($operation->judgment_date ?? null) }}</dd></div>
                                <div><dt>الملاك السابقون</dt><dd>{{ $operation->oldOwners->map(fn ($owner) => $owner->display_name ?: ('مالك #' . $owner->id))->filter()->implode('، ') ?: '—' }}</dd></div>
                                <div><dt>الملاك الجدد</dt><dd>{{ $operation->newOwners->map(fn ($owner) => $owner->display_name ?: ('مالك #' . $owner->id))->filter()->implode('، ') ?: '—' }}</dd></div>
                            </dl>
                            @if (filled($operation->judgment_notes) || filled($operation->contract_notes))
                                <p class="vn-property-show-note">{{ filled($operation->judgment_notes) ? $operation->judgment_notes : $operation->contract_notes }}</p>
                            @endif
                        </section>
                    @endforeach
                </div>
            </article>
        @endif

        @if ($property->signals->isNotEmpty())
            <article class="vn-property-show-card" aria-label="الإشارات المرتبطة">
                <div class="vn-property-show-card__head">
                    <h2>الإشارات المرتبطة</h2>
                    <span class="vn-property-show-count">{{ number_format($property->signals->count()) }} سجل</span>
                </div>
                <div class="vn-property-show-list">
                    @foreach ($property->signals as $signal)
                        <section class="vn-property-show-list-item">
                            <div>
                                <h3>{{ $valueOrEmpty($signal->signal_id ?? null) }}</h3>
                                <p>{{ $valueOrEmpty($signal->type ?? null) }}</p>
                            </div>
                            <dl>
                                <div><dt>تاريخ الإشارة</dt><dd>{{ $formatDate($signal->signal_date ?? null) }}</dd></div>
                                <div><dt>صاحب الإشارة</dt><dd>{{ $valueOrEmpty($signal->signal_owners_label ?? null) }}</dd></div>
                                <div><dt>مصدر الإشارة</dt><dd>{{ $valueOrEmpty($signal->signal_source ?? null) }}</dd></div>
                                <div><dt>رقم المصدر</dt><dd>{{ $valueOrEmpty($signal->signal_source_number ?? null) }}</dd></div>
                                <div><dt>تاريخ المصدر</dt><dd>{{ $formatDate($signal->signal_source_date ?? null) }}</dd></div>
                                <div><dt>المتضرر</dt><dd>{{ $valueOrEmpty($signal->signal_victims_label ?? null) }}</dd></div>
                            </dl>
                            @if (filled($signal->signal_notes))
                                <p class="vn-property-show-note">{{ $signal->signal_notes }}</p>
                            @endif
                        </section>
                    @endforeach
                </div>
            </article>
        @endif

        @if ($property->files->isNotEmpty())
            <article class="vn-property-show-card" aria-label="المرفقات">
                <div class="vn-property-show-card__head">
                    <h2>المرفقات</h2>
                    <span class="vn-property-show-count">{{ number_format($property->files->count()) }} ملف</span>
                </div>
                <div class="vn-property-show-attachments">
                    @foreach ($property->files as $file)
                        <a class="vn-property-show-attachment" href="{{ route('property-card-files.download', $file) }}" aria-label="تحميل المرفق {{ $file->file_name }}">
                            <span>{{ $valueOrEmpty($file->file_name ?? null) }}</span>
                            <small>{{ $formatDate($file->issued_at ?? null) }} · {{ filled($file->mime_type) ? $file->mime_type : 'ملف' }}</small>
                        </a>
                    @endforeach
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
