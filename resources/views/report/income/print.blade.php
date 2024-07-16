<?php
    $receive = 0;
    $payment = 0;
    $expense = 0;
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
          .table-responsive{
            padding: 0px 20px 0px 20px;
        }
        .table > :not(caption) > * > * {
        padding: 0.2rem .2rem;
        background-color: var(--bs-table-bg);
        border-bottom-width: 1px;
        box-shadow: inset 0 0 0 99910px var(--bs-table-accent-bg); 
    }
        .table td {
            font-size: 10px;
            color:#000000 ;
            text-align: left
          }
        .table th {
        font-size: 10px !important;
        text-align: center
        }
        .table tr:nth-child(even) {
            background-color: #fff2cd;
        }
        .table tr:nth-child(odd) {
            background-color: #ebd1dc;
        }
        .nowrap {
        white-space: nowrap;
    }
    p{
        font-size: 10px;
        margin-bottom:0px !important;
        {{--  line-height:.5rem;  --}}
    }
    h5{
        margin-bottom:0px !important;
        line-height:1rem;
    }
    h6{
        margin-bottom:0px !important;
        line-height:1rem;
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
                <div class="invoice-print px-3 pt-3">
                    <div class="invoice-header d-flex justify-content-between flex-md-row flex-column">
                        <div class="mx-auto">
                            <div class="text-center">
                                <h5 class="text-primary fw-bold">Amin & CO</h5>
                                <h6 class="fw-bold text-end">@lang("Income Expenditure Report")</h6>
                            </div>
                        </div>
                    </div>
                    <!-- expenses Income Expenditured -->
                                            
                    <div class="table-responsive">
                        <div class="row" id="basic-table">
                            <div class="col-12">
                                <div class="mx-2">
                                    <p > <strong> Date: {{ !empty($from_date) ? $from_date .' To '.$to_date : '- '.$to_date }}</strong></p>
                                </div>
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th class="nowrap">Date</th>
                                                    <th class="text-nowrap">Site Name</th>
                                                    <th class="text-nowrap">Division</th>
                                                    <th class="text-nowrap">Area</th>
                                                    <th class="text-nowrap">Receive</th>
                                                    <th class="text-nowrap">Payment</th>
                                                    <th class="text-nowrap">Expense</th>
                                                </tr>
                                            </thead>
                                            <tbody>@if(isset($transactions[0]))
                                                @foreach ($transactions as $transaction )
                                                   <tr>
                                                        <td><strong>{{ $loop->iteration }} </strong></td>
                                                        <td class="nowrap"><strong>{{ Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }} </strong></td>
                                                        <td><strong>{{ $transaction->site ? $transaction->site->name : null }} </strong></td>
                                                        <td><strong>{{ $transaction->site ? $transaction->site->division : null }} </strong></td>
                                                        <td><strong>{{ $transaction->site ? $transaction->site->area : null }} </strong></td>
                                                        <td style="text-align:right"><strong>{{ $transaction->description =='Receive' ? money_format($transaction->cash_in): '-' }} </strong></td>
                                                        <td style="text-align:right"><strong>{{ $transaction->description =='Payment' ? money_format($transaction->cash_out) : '-' }} </strong></td>
                                                        <td style="text-align:right"><strong>{{ $transaction->trnxable_type =='App\Models\Expense' ? money_format($transaction->cash_out) : '-' }} </strong></td>
                                                    </tr>
                                                    @php
                                                       $receive += $transaction->description =='Receive' ? $transaction->cash_in : 0;
                                                       $payment += $transaction->description =='Payment' ? $transaction->cash_out : 0;
                                                       $expense += $transaction->trnxable_type =='App\Models\Expense' ? $transaction->cash_out : 0;
                                                    @endphp
                                                   @endforeach
                                                @endif
                                                <tr class="bg-light">
                                                <td colspan="4"></td>
                                                <td class="nowrap" style="text-align:right;font-weight:bold; background-color: #fff2cd"><strong> Total</strong></td>
                                                <td class="nowrap" style="text-align:right;font-weight:bold; background-color: #B9D8AF !important"><strong> Tk. {{ money_format($receive) }}</strong></td>
                                                <td class="nowrap" style="text-align:right;font-weight:bold; background-color: #EDD3DE !important"><strong> Tk. {{ money_format($payment) }}</strong></td>
                                                <td class="nowrap" style="text-align:right;font-weight:bold; background-color: #CDE2F5 !important"><strong> Tk. {{ money_format($expense) }}</strong></td>
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