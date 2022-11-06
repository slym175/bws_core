@if(isset($tabMenu) && $tabMenu)
    <div
        class="tab-pane fade @if(isset($tabMenu['active']) && $tabMenu['active']) active show @endif"
        id="kt_header_navs_tab_{{ $tabMenu['id'] }}">
        <div class="header-menu flex-column align-items-stretch flex-lg-row">
            <div
                class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-400 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0"
                id="#kt_header_{{ $tabMenu['id'] }}" data-kt-menu="true">
                @php $tabMenuChildren = $tabMenu['children']; @endphp
                @foreach($tabMenuChildren as $tmcKey => $tabMenuChild)
                    <div @if(isset($tabMenuChild['children']) && count($tabMenuChild['children']))
                         data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
                         @endif
                         class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                        <a href="{{ isset($tabMenuChild['url']) && $tabMenuChild['url'] ? $tabMenuChild['url'] : 'javascript:;' }}"
                           class="menu-link @if(isset($tabMenuChild['active']) && $tabMenuChild['active']) active @endif py-3">
                            <span class="menu-title">{{ $tabMenuChild['name'] }}</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </a>
                        @if(isset($tabMenuChild['children']) && count($tabMenuChild['children']))
                            @include('bws@core::layouts.header.menu_children', ['tabMenus' => $tabMenuChild['children']])
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
