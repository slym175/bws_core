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

        #auth_forgot_password_form .card-body {
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
                    @if(session()->has('status'))
                        <x-bwscore-alert message="{{ session('status') }}"></x-bwscore-alert>
                    @endif
                    {{
                        \Bws\Core\Facades\Form::id('auth_forgot_password_form')
                            ->className('form w-100')
                            ->routeAction('admin.password.email')
                            ->attributes(['novalidate'=>'novalidate'])
                            ->method('POST')
                            ->fields([
                                \Bws\Core\Facades\Fields\HtmlField::content(function () {
                                    echo    '<div class="text-center mb-11">
                                                    <h1 class="text-dark fw-bolder mb-3">'.trans('bws/core::core.auth.forgot_password').'</h1>
                                                <div class="text-gray-500 fw-semibold fs-6">'.trans('bws/core::core.auth.slogan').'</div>
                                            </div>';
                                }),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('fv-row mb-8')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\TextField::make('email', 'email')
                                            ->className('form-control bg-transparent')
                                            ->placeholder(trans('bws/core::core.auth.email'))
                                            ->setValue(@old('email') ?? '')
                                    ]),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('d-grid mb-10')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\ActionField::make('auth_forgot_password_form_submit', 'submit')
                                            ->className('btn btn-primary')
                                            ->label(trans('bws/core::core.auth.send_forgot_password'))
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
