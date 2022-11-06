<form
    @if(isset($id) && $id) id="{{ $id }}" @endif
    @if(isset($action) && $action) action="{{ $action }}" @endif
    @if(isset($method) && $method) method="{{ $method != 'GET' ? 'POST' : $method }}" @endif
    @if(isset($enctype) && $enctype) enctype="{{ $enctype }}" @endif
    @if(isset($className) && $className) class="{{ $className }}" @endif
>
    @csrf
    @method($method)
    <div class="row">
        <div class="@if(isset($actions) && $actions && count($actions)) col-lg-9 col-md-8 @else col-lg-12 @endif">
            <div class="card">
                <div class="card-body">
                    {{ do_action($before_form_fields_hook) }}
                    @if(isset($fields) && $fields)
                        @foreach($fields as $field)
                            {{ $field->render() }}
                        @endforeach
                    @endif
                    {{ do_action($after_form_fields_hook) }}
                </div>
            </div>
        </div>
        @if(isset($actions) && $actions && count($actions))
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('bws/core::core.form.action.container_title') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            @foreach($actions as $action)
                                {{ $action->render() }}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</form>
