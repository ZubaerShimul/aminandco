<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{route('admin.dashboard')}}">
                    <h2 class="brand-text">{{allSetting('company_title') ? allSetting('company_title') : 'Amin & CO'}}</h2>
                </a></li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item @if(request()->routeIs('admin.dashboard')) active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.dashboard')}}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate">@lang('Dashboard')</span>
                </a>
            </li>
            {{-- <li class="nav-item @if(request()->routeIs('account.*')) active @endif">
                <a class="d-flex align-items-center" href="{{route('account.list')}}">
                    <i data-feather="layout"></i>
                    <span class="menu-title text-truncate">@lang('Bank Account')</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item @if(request()->routeIs('tender.*')) active @endif">
                <a class="d-flex align-items-center" href="{{route('tender.list')}}">
                    <i data-feather="layout"></i>
                    <span class="menu-title text-truncate">@lang('Tender')</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item @if(request()->routeIs('labour.*')) active @endif">
                <a class="d-flex align-items-center" href="{{route('labour.list')}}">
                    <i data-feather="layout"></i>
                    <span class="menu-title text-truncate">@lang('Labour')</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item @if(request()->routeIs('payment.*')) active @endif">
                <a class="d-flex align-items-center" href="{{route('payment.list')}}">
                    <i data-feather="layout"></i>
                    <span class="menu-title text-truncate">@lang('Payment Received')</span>
                </a>
            </li> --}}


            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Category")</span></a>
                <ul class="menu-content">
                    <li class="@if(request()->routeIs('payment.to.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('payment.to.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Payment To")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('site.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('site.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Site/Partner Name")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('bank_account.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('bank_account.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Bank Name")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('payment_method.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('payment_method.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Payment Method")</span></a>
                    </li>

                </ul>
            </li>

            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Expenses")</span></a>
                <ul class="menu-content">
                    <li class="@if(request()->routeIs('expense.official.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('expense.official.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Official Expense")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('expense.tender.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('expense.tender.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Tender Expense")</span></a>
                    </li>

                </ul>
            </li> --}}

            <li class="nav-item @if(request()->routeIs('salary.*')) active @endif">
                <a class="d-flex align-items-center" href="{{route('salary.list')}}">
                    <i data-feather="layout"></i>
                    <span class="menu-title text-truncate">@lang('Labour Salary')</span>
                </a>
            </li>

            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Report")</span></a>
                <ul class="menu-content">
                    <li class="@if(request()->routeIs('report.official.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('report.official.expense') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Official Expense")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('report.tender.expense')) active @endif"><a class="d-flex align-items-center" href="{{ route('report.tender.expense') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Tender Expense")</span></a>
                    </li>

                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
