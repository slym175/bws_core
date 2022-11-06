<div class="card">
    <div class="card-body p-5 px-10">
        <div class="table-responsive">
            <table class="table table-row-bordered gy-5 mb-0">
                <thead>
                <tr class="fw-semibold fs-6 text-muted">
                    <th data-column-name="id">#</th>
                    @foreach(@$columns as $column)
                        <th data-column-name="{{ $column->getName() }}">{{ $column->getLabel() }}</th>
                    @endforeach
                    <th class="text-end">Operations</th>
                </tr>
                </thead>
                <tbody>
                    @foreach(@$data as $item)
                        <td>{{ $loop->iteration }}</td>
                        @foreach(@$columns as $column)
                            <td>{{ $column->getCallback()($item) }}</td>
                        @endforeach
                        <td class="text-end">
                            @include('bws@core::utilities.crud.page.actions', ['table_actions' => $actions])
                        </td>
                    @endforeach
                </tbody>
            </table>
            @if($data instanceof \Illuminate\Contracts\Pagination\Paginator)
            {{ @$data->links() }}
                @endif
        </div>
    </div>
</div>
