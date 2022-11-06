@extends('bws@core::layouts.base', ['isAuthPage' => true])
@section('title', 'Login')

@push('css')
    <style>
        #auth_resend_verification_form .card-body {
            padding: 0;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-lg-row flex-column-fluid flex-center">
        <div class="d-flex flex-column flex-center text-center p-10">
            <div class="card card-flush w-lg-650px py-5">
                <div class="card-body py-15 py-lg-20">
                    <div class="mb-14">
                        <a href="javascript:;" class="">
                            <img alt="Logo" src="{{ asset('/vendor/bws/core/media/logos/custom-2.svg') }}" class="h-40px"/>
                        </a>
                    </div>
                        <h1 class="fw-bolder text-gray-900 mb-5">{{ trans('bws/core::core.auth.verify_email') }}</h1>
                    <div class="mb-0">
                        <img src="{{ asset('/vendor/bws/core/media/auth/please-verify-your-email.png') }}"
                             class="mw-100 mh-300px theme-light-show" alt=""/>
                        <img src="{{ asset('/vendor/bws/core/media/auth/please-verify-your-email-dark.png') }}"
                             class="mw-100 mh-300px theme-dark-show" alt=""/>
                    </div>
                    {{
                        \Bws\Core\Facades\Form::id('auth_resend_verification_form')
                            ->className('form w-100')
                            ->routeAction('admin.verification.resend')
                            ->attributes(['novalidate'=>'novalidate'])
                            ->method('POST')
                            ->fields([
                                \Bws\Core\Facades\Fields\HtmlField::content(function () {
                                    if(session()->has('resent')) {
                                        echo '<small class="fs-5 mb-3 d-block">'. trans('bws/core::core.auth.resent_verify_email') .'</small>';
                                    }
                                }),
                                \Bws\Core\Facades\Fields\FieldsGroup::className('d-grid mb-10 d-flex flex-center gap-5')
                                    ->fields([
                                        \Bws\Core\Facades\Fields\ActionField::make('auth_resend_verification_form_submit', 'submit')
                                            ->className('btn btn-primary')
                                            ->label(trans('bws/core::core.auth.send_another_request')),
                                        \Bws\Core\Facades\Fields\ActionField::make('auth_resend_verification_form_cancel', 'button')
                                            ->className('btn btn-secondary')
                                            ->attributes([
                                                'onclick' => 'backToHome("'.(\App\Providers\RouteServiceProvider::HOME).'")'
                                            ])
                                            ->label(trans('bws/core::core.auth.skip_for_now'))
                                    ]),
                            ])
                            ->render()
                    }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function backToHome(url) {
            window.location.href = url
        }
    </script>
@endpush
