@props(['resource', 'state' => null])

@if ($resource instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <section class="table-pagination">
        {{ $resource->links() }}
    </section>
@endif