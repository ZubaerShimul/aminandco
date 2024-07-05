<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mx-auto">
                <img src="{{asset('/assets/admin/images/admin-co.jpeg')}}" height="120">
            </li>
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{route('admin.dashboard')}}">
                    <h2 class="brand-text">{{allSetting('company_title') ? allSetting('company_title') : 'M/S Amin & CO'}}</h2>
                </a>
            </li>
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
            @if(Auth::id() && Auth::user()->is_admin)
           {{--   user  --}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("User")</span></a>
            <ul class="menu-content">
                <li class="@if(request()->routeIs('user.create') || request()->routeIs('user.edit')) active @endif"><a class="d-flex align-items-center" href="{{ route('user.create') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang( request()->routeIs('user.edit') ? "Update User" : "Create User")</span></a>
                </li>
                <li class="@if(request()->routeIs('user.list')) active @endif"><a class="d-flex align-items-center" href="{{ route('user.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("User List")</span></a>
                </li>
            </ul>
            </li>
            @endif

            {{--   Receive  --}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Receive")</span></a>
                <ul class="menu-content">
                    <li class="@if(request()->routeIs('receive.create') || request()->routeIs('receive.edit')) active @endif"><a class="d-flex align-items-center" href="{{ route('receive.create') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang( request()->routeIs('receive.edit') ? "Update Receive" : "Create Receive")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('receive.list')) active @endif"><a class="d-flex align-items-center" href="{{ route('receive.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Receive List")</span></a>
                    </li>
                </ul>
            </li>

            {{--   Payment  --}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Payment")</span></a>
            <ul class="menu-content">
                <li class="@if(request()->routeIs('payment.create') || request()->routeIs('payment.edit')) active @endif"><a class="d-flex align-items-center" href="{{ route('payment.create') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang( request()->routeIs('payment.edit') ? "Update Payment" : "Create Payment")</span></a>
                </li>
                <li class="@if(request()->routeIs('payment.list')) active @endif"><a class="d-flex align-items-center" href="{{ route('payment.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Payment List")</span></a>
                </li>
            </ul>
            </li>
            {{--   expense  --}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Expense")</span></a>
            <ul class="menu-content">
                <li class="@if(request()->routeIs('expense.create') || request()->routeIs('expense.edit')) active @endif"><a class="d-flex align-items-center" href="{{ route('expense.create') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang( request()->routeIs('expense.edit') ? "Update Expense" : "Create Expense")</span></a>
                </li>
                <li class="@if(request()->routeIs('expense.list')) active @endif"><a class="d-flex align-items-center" href="{{ route('expense.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Expense List")</span></a>
                </li>
            </ul>
        </li>

            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Category")</span></a>
                <ul class="menu-content">
                    <li class="@if(request()->routeIs('payment_to.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('payment_to.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Payment To")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('site.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('site.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Site/Partner Name")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('bank_account.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('bank_account.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Bank Name")</span></a>
                    </li>
                    <li class="@if(request()->routeIs('payment_method.*')) active @endif"><a class="d-flex align-items-center" href="{{ route('payment_method.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Payment Method")</span></a>
                    </li>
                </ul>
            </li>
            
            {{--   Employee  --}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Employee")</span></a>
              <ul class="menu-content">
                  <li class="@if(request()->routeIs('employee.create') || request()->routeIs('employee.edit')) active @endif"><a class="d-flex align-items-center" href="{{ route('employee.create') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang( request()->routeIs('employee.edit') ? "Update Employee" : "Create Employee")</span></a>
                  </li>
                  <li class="@if(request()->routeIs('employee.list')) active @endif"><a class="d-flex align-items-center" href="{{ route('employee.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Employee List")</span></a>
                  </li>
              </ul>
          </li>

          {{--   Salary  --}}
          <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Salary")</span></a>
            <ul class="menu-content">
                <li class="@if(request()->routeIs('salary.create') || request()->routeIs('salary.edit')) active @endif"><a class="d-flex align-items-center" href="{{ route('salary.create') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang( request()->routeIs('salary.edit') ? "Update Salary" : "Create Salary")</span></a>
                </li>
                <li class="@if(request()->routeIs('salary.list')) active @endif"><a class="d-flex align-items-center" href="{{ route('salary.list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Salary List")</span></a>
                </li>
            </ul>
        </li>

            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="eCommerce">@lang("Report")</span></a>
                <ul class="menu-content">
                    <li class="@if(request()->routeIs('report.receive')) active @endif"><a class="d-flex align-items-center" href="{{ route('report.receive') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Receive Report")</span></a> </li>
                    <li class="@if(request()->routeIs('report.payment')) active @endif"><a class="d-flex align-items-center" href="{{ route('report.payment') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Payment Report")</span></a> </li>
                    <li class="@if(request()->routeIs('report.expense')) active @endif"><a class="d-flex align-items-center" href="{{ route('report.expense') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Expense Report")</span></a> </li>
                    <li class="@if(request()->routeIs('report.income')) active @endif"><a class="d-flex align-items-center" href="{{ route('report.income') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">@lang("Income Expenditure")</span></a> </li>
                </ul>
            </li>

            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href=""></a></li>
        </ul>
    </div>
</div>