@extends('bws@core::layouts.base')

@section('title', 'Permission list')

@push('css')
@endpush

@section('page_action')
    <a href="" class="btn btn-sm btn-primary">
        <i class="bi bi-plus"></i>
        Load permissions
    </a>
@endsection

@section('content')
    {{
        \Bws\Core\Facades\Datatables\Datatable::make($data)
            ->addColumn(
                \Bws\Core\Facades\Datatables\Column::make('name', 'Name', function ($item) {
                    return $item->name;
                })
            )->addColumn(
                \Bws\Core\Facades\Datatables\Column::make('display_name', 'Display name', function ($item) {
                    return $item->display_name;
                })
            )->render()
    }}
@endsection

@push('js')
@endpush
