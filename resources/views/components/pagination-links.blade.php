@props(['resource', 'state' => null])

@if (isset($state) && filled($state) && $state->paginate)
    <section class="table-pagination">
        {{ $resource->links() }}
    </section>
@endif