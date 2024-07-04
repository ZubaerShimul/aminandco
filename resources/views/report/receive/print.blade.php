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
    <title>Amin & CO | Official Expense Report</title>
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

    <style>
        .nowrap {
        white-space: nowrap;
    }
        table {
            font-size: 10px;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #fff2cd;
        }
        tr:nth-child(odd) {
            background-color: #ebd1dc;
        }

    </style>
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
                    <div class="invoice-header d-flex justify-content-between flex-md-row flex-column">
                        <div class="mx-auto">
                            <div class="mb-1 text-center">
                                <h3 class="text-primary fw-bold">Amin & CO</h3>
                                <h4 class="fw-bold text-end">@lang("Receive Report")</h4>
                            </div>
                        </div>
                    </div>
                    {{--  <hr class="invoice-spacing" />  --}}
                    <p>Date: {{ !empty($from_date) ? $from_date .' To '.$to_date : 'Unitil- '.$to_date }}</p>
                    <!-- expenses received -->
                                            
                    <div class="table-responsive mt-2">
                        <div class="row" id="basic-table">
                            <div class="col-12">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Date</th>
                                                    <th>Name</th>
                                                    <th>District/ <br>Dicvision</th>
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
                                                    <td class="nowrap">{{ Carbon\Carbon::parse($receive->date)->format('d/y/Y') }} </td>
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
                                               <tr class="bg-light">
                                                <td colspan="7"></td>
                                                <td class="nowrap" style="font-weight:bold; background-color: #fff2cd">Total</td>
                                                <td class="nowrap" style="font-weight:bold; background-color: #6c9473 !important">Tk. {{ $net_amount }}</td>
                                                <td class="nowrap" style="font-weight:bold; background-color: #9c716d !important">Tk. {{ $other_amount }}</td>
                                                <td class="nowrap" style="font-weight:bold; background-color: #93a8b5 !important">Tk. {{ $total_amount }}</td>
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