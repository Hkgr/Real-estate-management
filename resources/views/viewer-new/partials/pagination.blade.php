@if (isset($paginator) && method_exists($paginator, 'links'))
    <div class="vn-pagination-wrap">
        {{ $paginator->links() }}
    </div>
@endif
