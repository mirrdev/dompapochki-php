
  <div class="side-content-wrap">
            <div class="sidebar-left open" data-perfect-scrollbar data-suppress-scroll-x="true">
                <ul class="navigation-left">
                <li class="nav-item {{ request()->is('dashboard/*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{route('dashboard')}}">
                            <i class="nav-icon i-Bar-Chart"></i>
                            <span class="nav-text">@lang('panel.dashboard')</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('pages/*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{route('pages')}}">
                            <i class="nav-icon i-Library"></i>
                            <span class="nav-text">@lang('panel.pages.header')</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('store/*') ? 'active' : '' }}" data-item="store">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon i-Shop"></i>
                            <span class="nav-text">@lang('panel.store')</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('orders/*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{route('orders')}}">
                            <i class="nav-icon i-Checkout-Basket"></i>
                            <span class="nav-text">@lang('panel.orders')</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('slides/*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{route('slides')}}">
                            <i class="nav-icon i-Landscape"></i>
                            <span class="nav-text">@lang('panel.slides')</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('navs/*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{route('navs')}}">
                            <i class="nav-icon i-Cursor"></i>
                            <span class="nav-text">@lang('panel.navs')</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('users/*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{route('users')}}">
                            <i class="nav-icon i-MaleFemale"></i>
                            <span class="nav-text">@lang('panel.users')</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item {{ request()->is('settings/*') ? 'active' : '' }}">
                        <a class="nav-item-hold" href="{{route('settings')}}">
                            <i class="nav-icon i-Gears"></i>
                            <span class="nav-text">@lang('panel.settings.header')</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                </ul>
            </div>

            <div class="sidebar-left-secondary" data-perfect-scrollbar data-suppress-scroll-x="true">
                <!-- Submenu Dashboards -->
                <ul class="childNav" data-parent="store">
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='categories' ? 'open' : '' }}" href="{{route('categories')}}">
                            <i class="nav-icon i-MaleFemale"></i>
                            <span class="item-name">@lang('panel.categories')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='products' ? 'open' : '' }}" href="{{route('products')}}">
                            <i class="nav-icon i-MaleFemale"></i>
                            <span class="item-name">@lang('panel.products')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='export' ? 'open' : '' }}" href="{{route('export')}}">
                            <i class="nav-icon i-MaleFemale"></i>
                            <span class="item-name">@lang('panel.export')</span>
                        </a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="users">
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='users' ? 'open' : '' }}" href="{{route('users')}}">
                            <i class="nav-icon i-MaleFemale"></i>
                            <span class="item-name">@lang('panel.users')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='roles' ? 'open' : '' }}" href="{{route('roles')}}">
                            <i class="nav-icon i-Hipster-Men"></i>
                            <span class="item-name">@lang('panel.roles')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='permissions' ? 'open' : '' }}" href="{{route('permissions')}}">
                            <i class="nav-icon i-Data-Lock"></i>
                            <span class="item-name">@lang('panel.permissions')</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-overlay"></div>
        </div>
        <!--=============== Left side End ================-->
