<div class="leftside-menu">

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets') }}/images/logo.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets') }}/images/logo_sm.png" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets') }}/images/logo-dark.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets') }}/images/logo_sm_dark.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">


            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="side-nav-item  {{ request()->routeIs(['dashboard.index']) ? 'menuitem-active' : '' }}">
                <a href="{{ route('dashboard.index') }}"
                    class="side-nav-link {{ request()->routeIs(['dashboard.index']) ? 'active' : '' }}">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item {{ request()->routeIs(['category.index']) ? 'menuitem-active' : '' }}">
                <a href="{{ route('category.index') }}"
                    class="side-nav-link {{ request()->routeIs(['category.index']) ? 'active' : '' }}">
                    <i class="uil-box"></i>
                    <span> Category </span>
                </a>
            </li>

            <li class="side-nav-item {{ request()->routeIs(['income.index']) ? 'menuitem-active' : '' }}">
                <a href="{{ route('income.index') }}"
                    class="side-nav-link  {{ request()->routeIs(['category.index']) ? 'active' : '' }}">
                    <i class="uil-arrow-to-bottom"></i>
                    <span> Income </span>
                </a>
            </li>

            <li class="side-nav-item {{ request()->routeIs(['spending.index']) ? 'menuitem-active' : '' }}">
                <a href="{{ route('spending.index') }}"
                    class="side-nav-link {{ request()->routeIs(['spending.index']) ? 'active' : '' }}">
                    <i class="uil-top-arrow-to-top"></i>
                    <span> Spending </span>
                </a>
            </li>



            <li class="side-nav-title side-nav-item">Settings</li>

            <li class="side-nav-item">
                <a href="apps-chat.html" class="side-nav-link">
                    <i class="uil-user"></i>
                    <span> My Account </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="apps-chat.html" class="side-nav-link">
                    <i class="uil-sign-out-alt"></i>
                    <span> Logout </span>
                </a>
            </li>
            <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
