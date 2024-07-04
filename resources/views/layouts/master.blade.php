<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="author" content="Rabiul Islam">
    <meta name="keywords" content="SDR, Data Recovery, Smart Data Recovery">
    <meta name="description" content="Register and create case to recover you data">
    <link rel="icon" type="image/x-icon" href="{{asset('/assets/favicon_io/favicon.ico')}}">

    <title>@lang('Amin & CO') @if(isset($title)) | {{  $title }}
        
    @endif</title>

    <link rel="apple-touch-icon" href="{{asset('assets/admin/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/vendors/css/extensions/toastr.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/components.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/plugins/extensions/ext-component-toastr.css')}}">
    <!-- END: Page CSS-->

    @stack('style')
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/style.css')}}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

@include('layouts.header')

@include('layouts.left-sidebar')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    @yield('content')
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

{{--  @include('layouts.footer')  --}}

<!-- BEGIN: Vendor JS-->
<script src="{{asset('assets/admin/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('assets/admin/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/admin/js/core/app.js')}}"></script>
<script src="{{asset('assets/admin/vendors/js/extensions/toastr.min.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- END: Page JS-->
@stack('script')
<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
<script type="text/javascript">
    $('#logout_button').hide();
    $('#logout_link').click(function() {
        document.logout_form.submit(); return false; }).show();
</script>

<script>
    @if(!empty(Session::get('success')))
        toastr["success"]('{{Session::get('success')}}','Success!')
    @elseif(!empty(Session::get('dismiss')))
        toastr["error"]('{{Session::get('dismiss')}}','Error')
    @elseif(!empty(Session::get('error')))
        toastr["error"]('{{Session::get('error')}}','Error')
    @elseif(!empty(Session::get('warning')))
        toastr["warning"]('{{Session::get('warning')}}','Warning')
    @elseif(!empty(Session::get('info')))
        toastr["info"]('{{Session::get('info')}}','Info')
    @endif
</script>
</body>
<!-- END: Body-->

</html>
