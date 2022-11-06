<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header"
     data-kt-sticky-offset="{default: '200px', lg: '300px'}">
    <div class="header-top d-flex align-items-stretch flex-grow-1">
        <div class="d-flex container-xxl align-items-stretch">
            <div class="d-flex align-items-center align-items-lg-stretch me-5 flex-row-fluid">
                <button
                    class="d-lg-none btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px ms-n2 me-2"
                    id="kt_header_navs_toggle">
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                fill="currentColor"/>
                            <path opacity="0.3"
                                  d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                  fill="currentColor"/>
                        </svg>
                    </span>
                </button>
                <a href="" class="d-flex align-items-center">
                    <img alt="Logo" src="{{ asset('vendor/bws/core/media/logos/demo20.svg') }}" class="h-25px h-lg-30px"/>
                </a>
                <div class="align-self-end overflow-auto" id="kt_brand_tabs">
                    <div class="header-tabs overflow-auto mx-4 ms-lg-10 mb-5 mb-lg-0" id="kt_header_tabs"
                         data-kt-swapper="true" data-kt-swapper-mode="prepend"
                         data-kt-swapper-parent="{default: '#kt_header_navs_wrapper', lg: '#kt_brand_tabs'}">
                        <ul class="nav flex-nowrap text-nowrap">
                            @foreach(dashboard_menu()->getMenuItems() as $dmiKey => $dashboard_menu_items)
                                <li class="nav-item">
                                    <a class="nav-link @if(isset($dashboard_menu_items['active']) && $dashboard_menu_items['active']) active @endif" data-bs-toggle="tab"
                                       href="#kt_header_navs_tab_{{ $dashboard_menu_items['id'] }}">{{ $dashboard_menu_items['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @include('bws@core::layouts.header.topbar')
        </div>
    </div>
    @include('bws@core::layouts.header.navs')
</div>
