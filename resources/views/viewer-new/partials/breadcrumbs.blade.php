@php
    $items = is_array($items ?? null) ? $items : [];
@endphp

@if(!empty($items))
    <nav class="vn-breadcrumb" aria-label="التنقل التفصيلي">
        <ol class="vn-breadcrumb__list">
            @foreach($items as $index => $item)
                @php
                    $isLast = $loop->last;
                    $label = $item['label'] ?? '';
                    $url = $item['url'] ?? null;
                @endphp

                <li class="vn-breadcrumb__item">
                    @if(!$isLast && !empty($url))
                        <a href="{{ $url }}" class="vn-breadcrumb__link">{{ $label }}</a>
                    @else
                        <span class="vn-breadcrumb__current" @if($isLast) aria-current="page" @endif>{{ $label }}</span>
                    @endif

                    @unless($isLast)
                        <span class="vn-breadcrumb__separator" aria-hidden="true">‹</span>
                    @endunless
                </li>
            @endforeach
        </ol>
    </nav>
@endif
