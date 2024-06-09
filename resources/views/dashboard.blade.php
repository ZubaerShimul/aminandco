@extends('layouts.master')
@push('style')
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/apexcharts.css') }}">
<!-- END: Vendor CSS-->
    
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb',['title' => __('Dashboard'), 'subtitle'=> __(''), 'button' => ''])
        <div class="content-body">
            <!-- Card Advance -->


            <div class="row match-height">
                <!-- Employee Task Card -->



                <!-- Profile Card -->
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="card card-profile">
                        <img src="{{asset('app-assets/images/banner/1.jpg')}}" class="img-fluid card-img-top"
                            alt="Profile Cover Photo" />
                        <div class="card-body">
                            <div class="profile-image-wrapper">
                                <div class="profile-image">
                                    <div class="avatar">
                                        <img src="{{asset('app-assets/images/portrait/small/1.jpg')}}"
                                            alt="Profile Picture" />
                                    </div>
                                </div>
                            </div>
                            <h3>Tk: <strong>{{ $opening_balance['today'] }}</strong></h3>
                           
                           
                            <hr class="mb-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted fw-bolder">Previous</h6>
                                    <h5 class="mb-0">Tk: <strong>{{ $opening_balance['previous'] }}</strong></h5>
                                </div>
                                
                                <div>
                                    <h6 class="text-muted fw-bolder">Change</h6>
                                    <h5 class="mb-0">Tk: <strong>{{ $opening_balance['change'] }}</strong></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


             
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="card card-profile">
                        <img src="{{asset('app-assets/images/banner/2.jpg')}}" class="img-fluid card-img-top"
                            alt="Profile Cover Photo" />
                        <div class="card-body">
                            <div class="profile-image-wrapper">
                                <div class="profile-image">
                                    <div class="avatar">
                                        <img src="{{asset('app-assets/images/portrait/small/2.jpg')}}"
                                            alt="Profile Picture" />
                                    </div>
                                </div>
                            </div>
                            <h3>Tk: <strong>{{ $receive['today'] }}</strong></h3>
                           
                           
                            <hr class="mb-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted fw-bolder">Previous</h6>
                                    <h5 class="mb-0">Tk: <strong>{{ $receive['previous'] }}</strong></h5>
                                </div>
                                
                                <div>
                                    <h6 class="text-muted fw-bolder">Change</h6>
                                    <h5 class="mb-0">Tk: <strong>{{ $receive['change'] }}</strong></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



      

                <div class="col-lg-3 col-md-3 col-12">
                    <div class="card card-profile">
                        <img src="{{asset('app-assets/images/banner/3.jpg')}}" class="img-fluid card-img-top"
                            alt="Profile Cover Photo" />
                        <div class="card-body">
                            <div class="profile-image-wrapper">
                                <div class="profile-image">
                                    <div class="avatar">
                                        <img src="{{asset('app-assets/images/portrait/small/3.jpg')}}"
                                            alt="Profile Picture" />
                                    </div>
                                </div>
                            </div>
                            <h3>Tk: <strong>{{ $payment['today'] }}</strong></h3>
                           
                           
                            <hr class="mb-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted fw-bolder">Previous</h6>
                                    <h5 class="mb-0">Tk: <strong>{{ $payment['previous'] }}</strong></h5>
                                </div>
                                
                                <div>
                                    <h6 class="text-muted fw-bolder">Change</h6>
                                    <h5 class="mb-0">Tk: <strong>{{ $payment['change'] }}</strong></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="card card-profile">
                        <img src="{{asset('app-assets/images/banner/4.jpg')}}" class="img-fluid card-img-top"
                            alt="Profile Cover Photo" />
                        <div class="card-body">
                            <div class="profile-image-wrapper">
                                <div class="profile-image">
                                    <div class="avatar">
                                        <img src="{{asset('app-assets/images/portrait/small/4.jpg')}}"
                                            alt="Profile Picture" />
                                    </div>
                                </div>
                            </div>
                            <h3>Tk: <strong>{{ $expense['today'] }}</strong></h3>
                           
                           
                            <hr class="mb-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted fw-bolder">Previous</h6>
                                    <h5 class="mb-0">Tk: <strong>{{ $expense['previous'] }}</strong></h5>
                                </div>
                                
                                <div>
                                    <h6 class="text-muted fw-bolder">Change</h6>
                                    <h5 class="mb-0">Tk: <strong>{{ $expense['change'] }}</strong></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>








         
            </div>
        </div>
        <!-- END: Content-->
        <div class="content-body">
            <!-- Column Chart Starts -->

            <div class="card">
                <div class="
            card-header
            d-flex
            flex-md-row flex-column
            justify-content-md-between justify-content-start
            align-items-md-center align-items-start
          ">
                    {{--  <h4 class="card-title">Data Science</h4>
                    <div class="d-flex align-items-center mt-md-0 mt-1">
                        <i class="font-medium-2" data-feather="calendar"></i>
                        <input type="text" class="form-control flat-picker bg-transparent border-0 shadow-none"
                            placeholder="YYYY-MM-DD" />
                    </div>  --}}
                </div>
                <div class="card-body">
                    <div id="column-chart"></div>
                </div>
            </div>
            <!-- Column Chart Ends -->
        </div>
    </div>
@endsection

@push('script')

        <!-- BEGIN: Page Vendor JS-->
        <script src="{{asset('app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Page JS-->
        <script src="{{asset('app-assets/js/scripts/cards/card-advance.js')}}"></script>

        <!-- BEGIN: Page Vendor JS-->

        <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
        <!-- END: Page Vendor JS-->


        <!-- BEGIN: Page JS-->
        <script src="{{asset('app-assets/js/scripts/charts/chart-apex.js')}}"></script>
        <!-- END: Page JS-->

@endpush
