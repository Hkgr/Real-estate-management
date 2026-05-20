@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير العقارات')
@section('topbar_title', 'تقرير العقارات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @php
        $paginator = $properties ?? null;
        $hasPaginator = $paginator && method_exists($paginator, 'total');

        $totalResults = $hasPaginator ? $paginator->total() : 0;
        $currentPage = $hasPaginator ? $paginator->currentPage() : 1;
        $lastPage = $hasPaginator ? $paginator->lastPage() : 1;
        $currentCount = $hasPaginator ? $paginator->count() : 0;

        $filterLabels = [
            'q' => 'بحث شامل', 'country' => 'الدولة', 'governorate' => 'المحافظة', 'region' => 'المنطقة', 'status' => 'الحالة',
            'investment_type' => 'نوع الاستثمار', 'purchase_method' => 'طريقة الشراء', 'min_area' => 'المساحة من', 'max_area' => 'المساحة إلى',
            'min_value' => 'القيمة من', 'max_value' => 'القيمة إلى', 'date_from' => 'من تاريخ', 'date_to' => 'إلى تاريخ',
            'has_owners' => 'لديه ملاك', 'has_signals' => 'لديه إشارات', 'has_files' => 'لديه ملفات',
        ];

        $activeFilters = [];
        foreach ($filterLabels as $key => $label) {
            $value = $filters[$key] ?? null;
            if (in_array($key, ['has_owners', 'has_signals', 'has_files'], true)) {
                if ($value === null || $value === '') continue;
                if ($value === true || $value === 1 || $value === '1') $value = 'نعم';
                elseif ($value === false || $value === 0 || $value === '0') $value = 'لا';
                else continue;
            } elseif ($value === null || $value === '') continue;
            $activeFilters[] = ['label' => $label, 'value' => $value];
        }

        $columnOptions = [
            'id' => 'ID العقار', 'property_name' => 'اسم العقار', 'property_country' => 'الدولة', 'card_governorate' => 'المحافظة',
            'card_region_name' => 'المنطقة', 'card_subdivision' => 'التقسيم', 'card_record_number' => 'رقم المحضر',
            'card_property_number' => 'رقم العقار', 'card_total_area' => 'المساحة', 'card_area_unit' => 'وحدة المساحة',
            'total_property_value_usd' => 'القيمة الإجمالية', 'owned_property_value_usd' => 'القيمة المملوكة', 'actual_price_usd' => 'السعر الفعلي',
            'estimated_price_usd' => 'السعر التقريبي', 'card_status' => 'الحالة', 'card_investment_type' => 'نوع الاستثمار',
            'card_purchase_method' => 'طريقة الشراء', 'card_sale_date' => 'تاريخ البيع', 'final_balance' => 'الرصيد النهائي',
            'card_google_maps_url' => 'الخريطة', 'owners_count' => 'الملاك', 'operations_count' => 'العمليات', 'signals_count' => 'الإشارات',
            'files_count' => 'الملفات', 'installments_count' => 'الدفعات', 'updated_at' => 'آخر تحديث', 'card_property_details' => 'ملاحظات', 'actions' => 'الإجراءات',
        ];
    @endphp

    <section class="vn-properties-report">
        <header class="vn-report-hero">
            <div class="vn-report-hero__content"><p>تقرير العقارات الكامل</p><h1>تقرير العقارات</h1></div>
            <div class="vn-report-hero__meta"><span>إجمالي النتائج: {{ number_format((int) $totalResults) }}</span></div>
        </header>

        <section class="vn-report-toolbar" aria-label="شريط أدوات تقرير العقارات">
            <div class="vn-report-toolbar__search"><span>🔍</span><input id="filter-q" type="text" name="q" form="vn-properties-report-generator-form" value="{{ $filters['q'] ?? '' }}" placeholder="بحث شامل" /><button type="button" class="vn-report-toolbar-button" data-properties-clear-search>مسح</button></div>
            <div class="vn-report-toolbar__actions">
                <button type="button" class="vn-report-toolbar-button vn-report-toolbar-button--primary" data-report-generator-toggle aria-expanded="true" aria-controls="vn-properties-generator-panel">مولد تقارير</button>
                <button type="button" class="vn-report-toolbar-button vn-report-toolbar-button--disabled" disabled>تصدير</button>
                <button type="button" class="vn-report-toolbar-button" data-properties-fullscreen>ملء الشاشة</button>
            </div>
        </section>

        <section id="vn-properties-generator-panel" class="vn-report-generator is-open" data-report-generator-panel>
            <form id="vn-properties-report-generator-form" method="GET" action="{{ route('viewer-new.reports.properties') }}" data-report-generator-form>
                <div class="vn-report-generator__filters">... 
                    <div><label for="filter-country">الدولة</label><select id="filter-country" name="country"><option value="">الكل</option>@foreach (($countryOptions ?? []) as $option)<option value="{{ $option }}" @selected(($filters['country'] ?? '') === (string) $option)>{{ $option }}</option>@endforeach</select></div>
                    <div><label for="filter-governorate">المحافظة</label><select id="filter-governorate" name="governorate"><option value="">الكل</option>@foreach (($governorateOptions ?? []) as $option)<option value="{{ $option }}" @selected(($filters['governorate'] ?? '') === (string) $option)>{{ $option }}</option>@endforeach</select></div>
                    <div><label for="filter-region">المنطقة</label><select id="filter-region" name="region"><option value="">الكل</option>@foreach (($regionOptions ?? []) as $option)<option value="{{ $option }}" @selected(($filters['region'] ?? '') === (string) $option)>{{ $option }}</option>@endforeach</select></div>
                    <div><label for="filter-status">الحالة</label><select id="filter-status" name="status"><option value="">الكل</option>@foreach (($statusOptions ?? []) as $option)<option value="{{ $option }}" @selected(($filters['status'] ?? '') === (string) $option)>{{ $option }}</option>@endforeach</select></div>
                    <div><label for="filter-investment-type">نوع الاستثمار</label><select id="filter-investment-type" name="investment_type"><option value="">الكل</option>@foreach (($investmentTypeOptions ?? []) as $option)<option value="{{ $option }}" @selected(($filters['investment_type'] ?? '') === (string) $option)>{{ $option }}</option>@endforeach</select></div>
                    <div><label for="filter-purchase-method">طريقة الشراء</label><select id="filter-purchase-method" name="purchase_method"><option value="">الكل</option>@foreach (($purchaseMethodOptions ?? []) as $option)<option value="{{ $option }}" @selected(($filters['purchase_method'] ?? '') === (string) $option)>{{ $option }}</option>@endforeach</select></div>
                </div>
                <div class="vn-report-generator__columns" data-column-picker>@foreach ($columnOptions as $key => $label)<label class="vn-report-column-option"><input type="checkbox" data-column-toggle value="{{ $key }}" checked><span>{{ $label }}</span></label>@endforeach</div>
                <div class="vn-report-generator__actions"><button type="submit" class="vn-report-secondary-button">تطبيق الفلاتر</button><a href="{{ route('viewer-new.reports.properties') }}" class="vn-report-secondary-button">إعادة تعيين</a><button type="button" class="vn-report-secondary-button" data-reset-columns>إعادة الافتراضي</button><button type="button" class="vn-report-generate-button" data-generate-report>توليد تقرير</button></div>
            </form>
        </section>

        <section class="vn-active-filter-chips">@if (count($activeFilters) > 0) @foreach ($activeFilters as $activeFilter)<span class="vn-active-filter-chip">{{ $activeFilter['label'] }}: {{ $activeFilter['value'] }}</span>@endforeach @else <p>لا توجد فلاتر مفعّلة حالياً.</p> @endif</section>
        <section class="vn-results-summary"><span>عدد النتائج الكلي: {{ number_format((int) $totalResults) }}</span><span>الصفحة الحالية: {{ $currentPage }}</span><span>آخر صفحة: {{ $lastPage }}</span><span>عدد السجلات المعروضة: {{ $currentCount }}</span></section>

        @if ($currentCount > 0)
        <div class="vn-table-responsive vn-properties-table"><table><thead><tr>@foreach($columnOptions as $key=>$label)<th data-column-key="{{ $key }}">{{ $label }}</th>@endforeach</tr></thead><tbody>
        @foreach ($properties as $property)
            @php
                $areaUnitRaw = strtolower((string) (($columns['card_area_unit'] ?? false) ? ($property->card_area_unit ?? '') : ''));
                $areaUnit = match ($areaUnitRaw) { 'meters', 'square_meter' => 'م²', 'shares' => 'سهم', 'percentage' => '%', default => ($areaUnitRaw !== '' ? $areaUnitRaw : '—')};
                $statusRaw = (string) (($columns['card_status'] ?? false) ? ($property->card_status ?? '') : ''); $s = strtolower(trim($statusRaw)); $statusClass='vn-status-badge--muted';
                if (in_array($s,['active','نشط'],true)) $statusClass='vn-status-badge--success'; elseif (in_array($s,['frozen','مجمد'],true)) $statusClass='vn-status-badge--warning'; elseif (in_array($s,['sold','closed','cancelled','مباع','مغلق','ملغى'],true)) $statusClass='vn-status-badge--danger';
                $propertyOperations = collect($operationsByProperty[$property->id] ?? []); $propertySignals = collect($signalsByProperty[$property->id] ?? []); $propertyFiles = collect($filesByProperty[$property->id] ?? []); $propertyInstallments = collect($installmentsByProperty[$property->id] ?? []); $operationOwners = collect($operationOwnersByProperty[$property->id] ?? []);
                $operationsRowId='operations-row-'.$property->id; $signalsRowId='signals-row-'.$property->id; $filesRowId='files-row-'.$property->id; $installmentsRowId='installments-row-'.$property->id;
            @endphp
            <tr>
            <td data-column-key="id">{{ $property->id ?? '—' }}</td><td data-column-key="property_name">{{ ($columns['property_name'] ?? false) ? ($property->property_name ?: '—') : '—' }}</td><td data-column-key="property_country">{{ ($columns['property_country'] ?? false) ? ($property->property_country ?: '—') : '—' }}</td><td data-column-key="card_governorate">{{ ($columns['card_governorate'] ?? false) ? ($property->card_governorate ?: '—') : '—' }}</td><td data-column-key="card_region_name">{{ ($columns['card_region_name'] ?? false) ? ($property->card_region_name ?: '—') : '—' }}</td><td data-column-key="card_subdivision">{{ ($columns['card_subdivision'] ?? false) ? ($property->card_subdivision ?: '—') : '—' }}</td><td data-column-key="card_record_number">{{ ($columns['card_record_number'] ?? false) ? ($property->card_record_number ?: '—') : '—' }}</td><td data-column-key="card_property_number">{{ ($columns['card_property_number'] ?? false) ? ($property->card_property_number ?: '—') : '—' }}</td><td data-column-key="card_total_area">{{ (($columns['card_total_area'] ?? false) && filled($property->card_total_area)) ? number_format((float)$property->card_total_area,2) : '—' }}</td><td data-column-key="card_area_unit">{{ ($columns['card_area_unit'] ?? false) ? $areaUnit : '—' }}</td><td data-column-key="total_property_value_usd">{{ (($columns['total_property_value_usd'] ?? false) && filled($property->total_property_value_usd)) ? number_format((float)$property->total_property_value_usd,2).' $' : '—' }}</td><td data-column-key="owned_property_value_usd">{{ (($columns['owned_property_value_usd'] ?? false) && filled($property->owned_property_value_usd)) ? number_format((float)$property->owned_property_value_usd,2).' $' : '—' }}</td><td data-column-key="actual_price_usd">{{ (($columns['actual_price_usd'] ?? false) && filled($property->actual_price_usd)) ? number_format((float)$property->actual_price_usd,2).' $' : '—' }}</td><td data-column-key="estimated_price_usd">{{ (($columns['estimated_price_usd'] ?? false) && filled($property->estimated_price_usd)) ? number_format((float)$property->estimated_price_usd,2).' $' : '—' }}</td><td data-column-key="card_status"><span class="vn-status-badge {{ $statusClass }}">{{ $statusRaw !== '' ? $statusRaw : '—' }}</span></td><td data-column-key="card_investment_type">{{ ($columns['card_investment_type'] ?? false) ? ($property->card_investment_type ?: '—') : '—' }}</td><td data-column-key="card_purchase_method">{{ ($columns['card_purchase_method'] ?? false) ? ($property->card_purchase_method ?: '—') : '—' }}</td><td data-column-key="card_sale_date">{{ ($columns['card_sale_date'] ?? false) ? ($property->card_sale_date ?: '—') : '—' }}</td><td data-column-key="final_balance">{{ (($columns['final_balance'] ?? false) && filled($property->final_balance)) ? number_format((float)$property->final_balance,2).' $' : '—' }}</td><td data-column-key="card_google_maps_url">{{ (($columns['card_google_maps_url'] ?? false) && filled($property->card_google_maps_url)) ? 'متاح' : '—' }}</td>
            <td data-column-key="owners_count">{{ $operationOwners->count() > 0 ? number_format($operationOwners->count()).' مالك' : '—' }}</td>
            <td data-column-key="operations_count"><div class="vn-related-inline"><span class="vn-related-inline__count">{{ number_format($propertyOperations->count()) }} عمليات</span>@if($propertyOperations->isNotEmpty())<button type="button" class="vn-related-inline__toggle" data-property-operations-toggle data-target="{{ $operationsRowId }}" aria-expanded="false" aria-controls="{{ $operationsRowId }}">▾</button>@endif</div></td>
            <td data-column-key="signals_count"><div class="vn-related-inline"><span class="vn-related-inline__count">{{ number_format($propertySignals->count()) }} إشارات</span>@if($propertySignals->isNotEmpty())<button type="button" class="vn-related-inline__toggle" data-property-signals-toggle data-target="{{ $signalsRowId }}" aria-expanded="false" aria-controls="{{ $signalsRowId }}">▾</button>@endif</div></td>
            <td data-column-key="files_count"><div class="vn-related-inline"><span class="vn-related-inline__count">{{ number_format($propertyFiles->count()) }} ملفات</span>@if($propertyFiles->isNotEmpty())<button type="button" class="vn-related-inline__toggle" data-property-files-toggle data-target="{{ $filesRowId }}" aria-expanded="false" aria-controls="{{ $filesRowId }}">▾</button>@endif</div></td>
            <td data-column-key="installments_count"><div class="vn-related-inline"><span class="vn-related-inline__count">{{ number_format($propertyInstallments->count()) }} دفعات</span>@if($propertyInstallments->isNotEmpty())<button type="button" class="vn-related-inline__toggle" data-property-installments-toggle data-target="{{ $installmentsRowId }}" aria-expanded="false" aria-controls="{{ $installmentsRowId }}">▾</button>@endif</div></td>
            <td data-column-key="updated_at">{{ ($columns['updated_at'] ?? false) && $property->updated_at ? $property->updated_at->format('Y-m-d H:i') : '—' }}</td><td data-column-key="card_property_details">{{ ($columns['card_property_details'] ?? false) ? ($property->card_property_details ?: '—') : '—' }}</td><td data-column-key="actions">—</td></tr>
            @foreach ([['row'=>$operationsRowId,'list'=>$propertyOperations,'title'=>'العمليات المرتبطة','class'=>'vn-property-operations-row'],['row'=>$signalsRowId,'list'=>$propertySignals,'title'=>'الإشارات المرتبطة','class'=>'vn-property-signals-row'],['row'=>$filesRowId,'list'=>$propertyFiles,'title'=>'الملفات المرتبطة','class'=>'vn-property-files-row'],['row'=>$installmentsRowId,'list'=>$propertyInstallments,'title'=>'الدفعات المرتبطة','class'=>'vn-property-installments-row']] as $related)
                @if($related['list']->isNotEmpty())
                <tr class="{{ $related['class'] }}" id="{{ $related['row'] }}" hidden><td colspan="28"><div class="vn-child-panel"><div class="vn-child-panel__header"><h4 class="vn-child-panel__title">{{ $related['title'] }}</h4></div><div class="vn-child-table">{{ $related['list']->count() }} سجل</div></div></td></tr>
                @endif
            @endforeach
        @endforeach
        </tbody></table></div>
        @include('viewer-new.partials.pagination', ['paginator' => $properties ?? null])
        @else @include('viewer-new.partials.empty-state', ['message' => 'لم يتم العثور على عقارات وفقاً لعوامل البحث الحالية.']) @endif
    </section>
@endsection
