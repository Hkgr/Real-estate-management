<section class="vn-report-metrics">
    @foreach (($items ?? []) as $item)
        <article class="vn-metric-card">
            <span>{{ $item['label'] ?? '—' }}</span>
            <strong>{{ $item['value'] ?? '—' }}</strong>
        </article>
    @endforeach
</section>
