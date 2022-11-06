@if(count(dashboard_menu()->getMenuItems()))
    <div class="header-navs d-flex align-items-stretch flex-stack h-lg-70px w-100 py-5 py-lg-0"
         id="kt_header_navs" data-kt-drawer="true" data-kt-drawer-name="header-menu"
         data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
         data-kt-drawer-toggle="#kt_header_navs_toggle" data-kt-swapper="true" data-kt-swapper-mode="append"
         data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header'}">
        <div class="d-lg-flex container-xxl w-100">
            <div class="d-lg-flex flex-column justify-content-lg-center w-100" id="kt_header_navs_wrapper">
                <div class="tab-content" data-kt-scroll="true"
                     data-kt-scroll-activate="{default: true, lg: false}" data-kt-scroll-height="auto"
                     data-kt-scroll-offset="70px">
                    @foreach(dashboard_menu()->getMenuItems() as $dmiKey => $dashboard_menu_items)
                        @include('bws@core::layouts.header.menu', ['tabMenu' => $dashboard_menu_items])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
