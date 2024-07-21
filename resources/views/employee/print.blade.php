
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Amin & CO | Employee Details Report</title>
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

@media print {
   
        .invoice-print{
            max-width:5.5in!important;
            max-height:8in !important;
        margin-left: 0 !important;
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

    .table thead th, .table tfoot th {
  vertical-align: top;
  text-transform: uppercase;
  font-size: 0.7rem;
  letter-spacing: 0.5px;
}
.table > :not(caption) > * > *{
            padding: .72rem .5rem !important;
        }

      .info-container {
            display: flex;
            flex-direction: column;
        }
        .info-item {
            display: flex;
        }
        .info-label {
            width: 120px; /* Adjust the width as needed */
            font-weight: bold;
        }
        .info-value {
            flex: 1;
        }
        .nowrap {
        white-space: nowrap;
        }
            /* Flexbox for vertical alignment */
        .d-flex {
            display: flex;
            align-items: center; /* Vertically center the items */
        }

        .me-3 {
            margin-right: 1rem; /* Add margin to the right of the logo */
        }
    }
</style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class=" " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
 
                <div class="invoice-print px-1 pt-1">
                    <!-- expenses received -->
                                            
                    <div class="table-responsive">
                        <div class="row" id="basic-table">
                        <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="invoice-title">
                                                <div class="mb-1 d-flex align-items-center">
                                                    <img src="{{ asset('/assets/admin/images/admin-co.jpeg') }}" height="120" class="me-3">
                                                    <div>
                                                        <h2 class="mb-1">{{ allSetting('company_title') ? allSetting('company_title') : 'M/S Amin & CO' }}</h2>
                                                        <p class="mb-1">1st Class Government contractor & Suppliers</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="mt-2">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-4 text-center mx-auto">
                                                        <h4 class="font-size-16 border px-1 py-1">Employee Details</h4>
                                                        <div class="info-item ">
                                                            <img class="mx-auto" src="{{$details->image}}" style="width: 150px; height:150px;"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                        <div class="info-container">
                                                        <div class="info-item">
                                                            <span class="info-label">Name:</span>
                                                            <span class="info-value">{{$details->name}}</span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span class="info-label">Designation:</span>
                                                            <span class="info-value">{{$details->designation}}</span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span class="info-label">Address:</span>
                                                            <span class="info-value">{{$details->address}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                    
                                            <div class="">
                                                <div class="table-responsive">
                                                    <table class="table receive-table align-middle table-nowrap table-centered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>NID No</th>
                                                                <th>Contact No</th>
                                                                <th>Blood Group</th>
                                                                <th>Joining Date</th>
                                                                <th>Resign Date</th>
                                                                <th class="text-end" style="width: 120px;">Basic Salary</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">{{$details->NID}}</td>
                                                                <td>
                                                                    {{$details->contact_no}}
                                                                </td>
                                                                <td>
                                                                        {{$details->blood_group}}
                                                                </td>
                                                                <td>
                                                                        {{$details->joining_date}}
                                                                </td>
                                                                <td>
                                                                        {{$details->resigning_date}}
                                                                </td>
                                                                <td class="text-end">
                                                                        {{$details->basic_salary}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="text-center">
                                                            <h5 class="font-size-16">18, Gogan Babu Road (2nd Lane), Khulna</h5>
                                                            <p class="">Call: 01711-331360 & 01971-331360 E-mail:mdruhulamin1968@gmail.com</p>
                                                    </div>
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