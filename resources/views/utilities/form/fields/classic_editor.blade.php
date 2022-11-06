<div class="mb-10">
    <div class="mb-3 d-inline-flex align-items-center w-100">
        {{
            \Bws\Core\Facades\Fields\LabelField::make($name)
                ->label($label)
                ->className('form-label')
                ->render()
        }}
        <div class="d-inline-block editor-action-item ms-auto">
            {{
                \Bws\Core\Facades\Fields\ActionField::make('btn_open_gallery')
                    ->formAction('javascript:;')
                    ->label('Add media')
                    ->className('btn_gallery btn btn-primary btn-sm')
                    ->attributes([
                        'data-result' => $name,
                        'data-multiple' => 'true',
                        'data-editor' => $name,
                        'data-action' => 'media-insert-ckeditor'
                    ])
                    ->icon('bi bi-image')->render()
            }}
        </div>
        <div class="d-inline-block editor-action-item ms-2">
            <a href="javascript:;"
               class="btn btn-success menu-dropdown btn-sm"
               data-kt-menu-trigger="click"
               data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                <i class="fas fa-code"></i> Add shortcode
                <span class="svg-icon svg-icon-5 m-0 ms-2">
                    <i class="bi bi-caret-down-fill"></i>
                </span>
            </a>
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 mw-200px py-4"
                data-kt-menu="true" data-popper-placement="top-end">
                @php
                    $shortcodes = collect(app('shortcode.compiler')->getRegistered())->map(function ($registered, $name) {
                        $registered['name'] = $name;
                        return $registered;
                    })->groupBy('attributes.group');
                @endphp
                @foreach($shortcodes as $group => $shortcodes_group)
                    @foreach($shortcodes_group as $shortcode_name => $shortcode)
                        <div class="menu-item px-3">
                            <a href="javascript:;" data-shortcode="{{ $shortcode['name'] }}"
                               data-editor="{{ $name }}"
                               data-result="{{ $name }}" data-action="shortcode-insert-ckeditor"
                               class="menu-link px-3 d-inline-flex w-100 btn_shortcode"
                               data-kt-docs-table-filter="edit_row">
                                <i class="fas fa-code me-3"></i>
                                <p class="text-nowrap d-inline-block m-0">{{ $shortcode['display_name'] }}</p>
                            </a>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
    {{
        \Bws\Core\Facades\Fields\Textarea::make($name)->id($name)
            ->className($name.'-editor use-editor form-control')
            ->placeholder(function (){
                return 'Enter content...';
            })->render()
    }}
</div>
@include('bws@core::utilities.form.fields.error_field', [
    'name' => $name
])
@push('js')
    @once
        <script src="{!! asset('vendor/bws/core/plugins/custom/ckeditor/ckeditor-classic.bundle.js') !!}"></script>
        <script type="text/javascript">
            let _use_editor = [];
            $(document).ready(function () {
                document.querySelectorAll('.use-editor').forEach((use_editor) => {
                    let __editor = $(use_editor).attr('name');
                    ClassicEditor
                        .create(use_editor)
                        .then(editor => {
                            _use_editor[__editor] = editor;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });
            })
        </script>
    @endonce
@endpush
