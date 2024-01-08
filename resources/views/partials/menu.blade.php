<div class="sidebar">
    <nav class="sidebar-nav ps ps--active-y">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fas fa-users nav-icon">

                    </i>
                    {{ trans('global.userManagement.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('global.permission.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fas fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.role.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fas fa-user nav-icon">

                            </i>
                            {{ trans('global.user.title') }}
                        </a>
                    </li>
                </ul>
            </li>
            <!-- <li class="nav-item">
                <a href="" class="nav-link {{ request()->is('admin/adresses') || request()->is('admin/adresses/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    Addresses
                </a>
            </li> -->
            <li class="nav-item">
                <a href="{{ route('admin.shops.index') }}" class="nav-link {{ request()->is('admin/shops') || request()->is('admin/shops/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    Shops
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="" class="nav-link {{ request()->is('admin/orders') || request()->is('admin/orders/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    Orders
                </a>
            </li> -->
            <li class="nav-item">
                <a href="{{ route('admin.dresses.index') }}" class="nav-link {{ request()->is('admin/dresses') || request()->is('admin/dresses/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    Dresses
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->is('admin/services') || request()->is('admin/services/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">
                    </i>
                    Services
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->is('admin/coupons') || request()->is('admin/coupons/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">
                    </i>
                    Coupons
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">
                    </i>
                    Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 869px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 415px;"></div>
        </div>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

