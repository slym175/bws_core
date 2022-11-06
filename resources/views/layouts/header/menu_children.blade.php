@if(isset($tabMenus) && $tabMenus)
    <div
        class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
        @foreach($tabMenus as $tmKey => $tabMenu)
            <div @if(isset($tabMenu['children']) && count($tabMenu['children']))
                 data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                 data-kt-menu-placement="right-start"
                 @endif class="menu-item menu-lg-down-accordion">
                <a href="{{ $tabMenu['url'] }}"
                   class="menu-link @if(isset($tabMenu['active']) && $tabMenu['active']) active @endif py-3">
                    @if(isset($tabMenu['icon']) && $tabMenu['icon'])
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-3">
                                <i class="{{ $tabMenu['icon'] }}"></i>
                            </span>
                        </span>
                    @else
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                    @endif
                    <span class="menu-title">{{ $tabMenu['name'] }}</span>
                    @if(isset($tabMenu['children']) && count($tabMenu['children']))
                        <span class="menu-arrow"></span>
                    @endif
                </a>
                @if(isset($tabMenu['children']) && count($tabMenu['children']))
                    @include('bws@core::layouts.header.menu_children', ['tabMenus' => $tabMenu['children']])
                @endif
            </div>
        @endforeach
    </div>
@endif
