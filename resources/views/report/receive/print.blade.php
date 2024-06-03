<?php
    $net_amount = 0;
    $other_amount = 0;
    $total_amount = 0;
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  \  <title>Amin & CO | Official Expense Report</title>
    {{--  <link rel="apple-touch-icon" href="{{asset('app-assets/images/ico/apple-icon-120.png')}}">  --}}
    {{--  <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets/images/ico/favicon.ico')}}">  --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-invoice-print.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/invoice/css/style-rtl.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="invoice-print p-3">
                    <div class="invoice-header d-flex justify-content-between flex-md-row flex-column pb-2">
                        <div>
                            <div class="d-flex mb-1">
                                {{--  <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                                    <defs>
                                        <linearGradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                            <stop stop-color="#000000" offset="0%"></stop>
                                            <stop stop-color="#FFFFFF" offset="100%"></stop>
                                        </linearGradient>
                                        <linearGradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                            <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                            <stop stop-color="#FFFFFF" offset="100%"></stop>
                                        </linearGradient>
                                    </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                            <g id="Group" transform="translate(400.000000, 178.000000)">
                                                <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor"></path>
                                                <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                                <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                                <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                                <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                            </g>
                                        </g>
                                    </g>
                                </svg>  --}}
                                <h3 class="text-primary fw-bold ms-1">Amin & CO</h3>
                            </div>
                            <p class="mb-25">1 No. Custom Ghat Road, Punak market, Khulna</p>
                        </div>
                        <div class="mt-md-0 mt-2">
                            <h4 class="fw-bold text-end mb-1">@if(!empty($tender)) {{ $tender->name.' Expense Report' }} @else @lang("Tender Expense Report")@endif</h4>
                            @if(!empty($from_date))
                            <div class="invoice-date-wrapper mb-50">
                                <span class="invoice-date-title">From:</span>
                                <span class="fw-bold"> {{ $from_date }}</span>
                            </div>
                            <div class="invoice-date-wrapper">
                                <span class="invoice-date-title">To:</span>
                                <span class="fw-bold">{{ $to_date }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <hr class="invoice-spacing" />
                    <!-- expenses received -->
                                            
                    <div class="table-responsive mt-2">
                        <div class="row" id="basic-table">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">@lang("Official Expenses")</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Date</th>
                                                    <th>Name</th>
                                                    <th>District/Dicvision</th>
                                                    <th>Area</th>
                                                    <th>Bank Name</th>
                                                    <th>Acc Number</th>
                                                    <th>Pay. Method</th>
                                                    <th>Net R Amount</th>
                                                    <th>Others Amount</th>
                                                    <th>Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @if(isset($receives[0]))
                                               @foreach ($receives as $receive )
                                               <tr>
                                                    <td>{{ $loop->iteration }} </td>
                                                    <td>{{ $receive->date }} </td>
                                                    <td>{{ $receive->name }} </td>
                                                    <td>{{ $receive->district }} </td>
                                                    <td>{{ $receive->area }} </td>
                                                    <td>{{ $receive->bank_name }} </td>
                                                    <td>{{ $receive->account_no }} </td>
                                                    <td>{{ $receive->payment_method }} </td>
                                                    <td>{{ $receive->net_payment_amount }} </td>
                                                    <td>{{ $receive->others_amount }} </td>
                                                    <td>{{ $receive->total }} </td>
                                                </tr>
                                                @php
                                                    $net_amount     += $receive->net_payment_amount;
                                                    $other_amount   += $receive->others_amount;
                                                    $total_amount   += $receive->total;
                                                @endphp
                                               @endforeach
                                               @endif
                                               <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="font-weight:bold">Total</td>
                                                <td style="font-weight:bold">Tk. {{ $net_amount }}</td>
                                                <td style="font-weight:bold">Tk. {{ $other_amount }}</td>
                                                <td style="font-weight:bold">Tk. {{ $total_amount }}</td>
                                               </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/js/core/app-menu.')}}"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('app-assets/js/scripts/pages/app-invoice-print.js')}}"></script>
    <!-- END: Page JS-->

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
</body>
<!-- END: Body-->

</html>