<a href="javascript:;" class="btn btn-light btn-active-light-primary btn-sm menu-dropdown px-2 py-3 w-100px"
   data-kt-menu-trigger="click"
   data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
    Actions
    <span class="svg-icon svg-icon-5 m-0 ms-2">
        <i class="bi bi-caret-down-fill"></i>
    </span>
</a>
<div
    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 mw-200px py-2"
    data-kt-menu="true" data-popper-placement="top-end">
    @if($table_actions)
        @foreach($table_actions as $action)
            @php $action = collect($action); @endphp
            @if(!isset($action->permissions) || !$action->permissions || auth('web')->user()->can($action->permissions))
                <div class="menu-item px-2">
                    <a href="{{ isset($action->url) && $action->url ? $action->url : 'javascript:;' }}"
                       class="menu-link px-3 d-inline-flex w-100"
                       onclick="{{ isset($action->onclick) && $action->onclick ? $action->onclick : '' }}">
                        <span class="me-3">{!! $action->icon  !!}</span>
                        <p class="text-nowrap d-inline-block m-0">{{ $action->title }}</p>
                    </a>
                </div>
            @endif
        @endforeach
    @else
        <div class="menu-item px-3">
            <a href="javascript:;"
               class="menu-link px-3 d-inline-flex w-100" data-kt-docs-table-filter="edit_row">
                <p class="text-nowrap d-inline-block m-0">No actions</p>
            </a>
        </div>
    @endif
</div>
