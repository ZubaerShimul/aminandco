<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown dropdown-language">
                @if(app()->getLocale() == 'en')
                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">@lang("English")</span></a>
                @else
                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-bd"></i><span class="selected-language">@lang("Bangla")</span></a>
                @endif
                
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                    <a class="dropdown-item" href="{{ route('lang.change', ['lang' => 'en']) }}" data-language="en"><i class="flag-icon flag-icon-us"></i> @lang("English")</a>
                    <a class="dropdown-item" href="{{ route('lang.change', ['lang' => 'bn']) }}" data-language="bn"><i class="flag-icon flag-icon-bd"></i> @lang("Bangla")</a>
                </div>
            </li>
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">{{ Auth::user()->name }}</span><span class="user-status">{{ Auth::user()->designation }}</span></div><span class="avatar">@if(!empty(Auth::user()->image)) <img class="round" src="{{ Auth::user()->image }}"  @else <img class="round" src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" @endif alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="me-50" data-feather="user"></i> @lang('Profile')</a>
                    <a class="dropdown-item" href="{{ route('password') }}"><i class="me-50" data-feather="lock"></i> @lang("Password Update")</a>
                    <a class="dropdown-item" href="{{ route('home') }}"><i class="me-50" data-feather="home"></i> @lang("Home")</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"><i class="me-50" data-feather="home"></i> @lang("Logout")</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- END: Header-->
