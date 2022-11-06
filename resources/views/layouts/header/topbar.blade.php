<div class="d-flex align-items-center flex-row-auto">
    <div class="d-flex align-items-center ms-1">
        <div
            class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px"
            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <span class="svg-icon svg-icon-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"/>
                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                          fill="currentColor"/>
                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                          fill="currentColor"/>
                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                          fill="currentColor"/>
                </svg>
            </span>
        </div>
        <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px"
             data-kt-menu="true">
            <div class="p-3">
                Hello
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center ms-1">
        <a href="#"
           class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px"
           data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
           data-kt-menu-placement="bottom-end">
            <span class="svg-icon theme-light-show svg-icon-2">
                <i class="bi bi-brightness-high-fill"></i>
            </span>
            <span class="svg-icon theme-dark-show svg-icon-2">
                <i class="bi bi-moon-stars-fill"></i>
            </span>
        </a>
        <div
            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
            data-kt-menu="true" data-kt-element="theme-mode-menu">
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                   data-kt-value="light">
                    <span class="menu-icon" data-kt-element="icon">
                        <span class="svg-icon svg-icon-3">
                            <i class="bi bi-brightness-high-fill"></i>
                        </span>
                    </span>
                    <span class="menu-title">Light</span>
                </a>
            </div>
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                   data-kt-value="dark">
                    <span class="menu-icon" data-kt-element="icon">
                        <span class="svg-icon svg-icon-3">
                            <i class="bi bi-moon-stars-fill"></i>
                        </span>
                    </span>
                    <span class="menu-title">Dark</span>
                </a>
            </div>
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                   data-kt-value="system">
                    <span class="menu-icon" data-kt-element="icon">
                        <span class="svg-icon svg-icon-3">
                            <i class="bi bi-gear-wide-connected"></i>
                        </span>
                    </span>
                    <span class="menu-title">System</span>
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center ms-1" id="kt_header_user_menu_toggle">
        @php
            $name = 'Admin';
            if(auth()->check() && auth()->user()->name) $name = auth()->user()->name;
            $avatar = ui_avatar($name);
        @endphp
        <div
            class="btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 py-2 px-2 px-md-3"
            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <div class="symbol symbol-30px symbol-md-40px">
                <img src="{{ $avatar }}" alt="image"/>
            </div>
        </div>
        <div
            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true">
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <div class="symbol symbol-50px me-5">
                        <img alt="Logo" src="{{ $avatar }}"/>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">
                            {{ auth('web')->check() ? auth('web')->user()->name : 'Guess'}}
                        </div>
                        <a href="#"
                           class="fw-semibold text-muted text-hover-primary fs-7">{{ auth('web')->check() ? auth('web')->user()->email : 'email' }}</a>
                    </div>
                </div>
            </div>
            <div class="separator my-2"></div>
            @php
                $languages = config('bws/core.supported_languages', []);
                $supported_locales = collect(config('bws/core.languages', []))->filter(function ($language, $key) use ($languages) {
                    return in_array($key, $languages);
                })->toArray();
            @endphp
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                 data-kt-menu-placement="left-start">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">Language
                        <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                            {{ __($supported_locales[app()->getLocale()]['display']) }}
                            <img class="w-15px h-15px rounded-1 ms-2"
                                 src="{{ asset('vendor/bws/core/media/flags/' . $supported_locales[app()->getLocale()]['flag-icon'] . '.svg') }}"
                                 alt="{{ __($supported_locales[app()->getLocale()]['display']) }}"/>
                        </span>
                    </span>
                </a>
                @if(count($supported_locales) - 1)
                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        @foreach ($supported_locales as $lang => $language)
                            @if ($lang != app()->getLocale())
                                <div class="menu-item px-3">
                                    <a href="{{ route('admin.languages.update', ['language' => $lang]) }}"
                                       class="menu-link d-flex px-5">
                                <span class="symbol symbol-20px me-4">
                                    <img class="rounded-1"
                                         src="{{ asset('vendor/bws/core/media/flags/' . $language['flag-icon'] . '.svg') }}"
                                         alt="{{ __($language['display']) }}"/>
                                </span>
                                        {{ __($language['display']) }}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="menu-item px-5">
                <form id="post_logout_form" action="{{ router_url('admin.logout') }}" method="POST">
                    @csrf
                </form>
                <a href="javascript:;" onclick="document.getElementById('post_logout_form').submit();"
                   class="menu-link px-5">Sign Out</a>
            </div>
        </div>
    </div>
</div>
