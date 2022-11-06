@extends('bws@core::layouts.base', ['isAuthPage' => true])
@section('title', 'Login')

@push('css')
    <style>
        body {
            background-image: url('/vendor/bws/core/media/auth/bg10.jpeg');
        }

        [data-theme="dark"] body {
            background-image: url('/vendor/bws/core/media/auth/bg10-dark.jpeg');
        }

        #auth_register_form .card-body {
            padding: 0;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        @include('bws@core::pages.auth.partials.leftside')
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10">
                <div class="w-md-400px">
                    {{
                        \Bws\Core\Facades\Form::id('auth_register_form')
                            ->className('form w-100')
                            ->routeAction('admin.register')
                            ->attributes(['novalidate'=>'novalidate'])
                            ->method('POST')
                            ->fields([
                                \Bws\Core\Facades\Fields\HtmlField::content(function () {
                                    echo    '<div class="text-center mb-11">
                                                    <h1 class="text-dark fw-bolder mb-3">'.trans('bws/core::core.auth.sign_up').'</h1>
                                                <div class="text-gray-500 fw-semibold fs-6">'.trans('bws/core::core.auth.slogan').'</div>
                                            </div>';
                                }),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('fv-row mb-8')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\TextField::make('name')
                                            ->className('form-control bg-transparent')
                                            ->placeholder(trans('bws/core::core.auth.name'))
                                            ->setValue(@old('name') ?? '')
                                    ]),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('fv-row mb-8')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\TextField::make('email', 'email')
                                            ->className('form-control bg-transparent')
                                            ->placeholder(trans('bws/core::core.auth.email'))
                                            ->setValue(@old('email') ?? '')
                                    ]),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('fv-row mb-8')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\TextField::make('username')
                                            ->className('form-control bg-transparent')
                                            ->placeholder(trans('bws/core::core.auth.username'))
                                            ->setValue(@old('username') ?? '')
                                    ]),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('fv-row mb-8')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\TextField::make('password', 'password')
                                            ->className('form-control bg-transparent')
                                            ->placeholder(trans('bws/core::core.auth.password'))
                                    ]),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('fv-row mb-8')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\TextField::make('password_confirmation', 'password')
                                            ->className('form-control bg-transparent')
                                            ->placeholder(trans('bws/core::core.auth.password_confirmation'))
                                    ]),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('d-grid mb-10')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\ActionField::make('auth_register_form_submit', 'submit')
                                            ->className('btn btn-primary')
                                            ->label(trans('bws/core::core.auth.sign_up'))
                                    ]),
                            ])
                            ->render()
                    }}
                    @if(can_create_account())
                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            <span>{{ trans('bws/core::core.auth.has_account') }}</span>
                            <a href="{{ router_url('admin.login') }}" class="link-primary">
                                {{ trans('bws/core::core.auth.sign_in') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
