@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb',['title' => __('Dashboard'), 'subtitle'=> __(''), 'button' => ''])
        <div class="content-body">
            <section id="dashboard-ecommerce">
                {{--  <div class="row match-height">
                    <!-- Medal Card -->
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="card card-congratulation-medal">
                            <div class="card-body">
                                <h5>@lang('Congratulations') 🎉 {{$user->name}}</h5>
                                <p class="card-text font-small-3">@lang('Tender reports are increasing day by day')</p>
                                <h3 class="mb-75 mt-2 pt-50">
                                    <a href="#">{{$total_tender}}</a>
                                </h3>
                                <a href="{{ route('tender.list') }}" class="btn btn-primary">@lang('View Tender')</a>
                                <img src="{{asset('assets/admin/images/illustration/badge.svg')}}" class="congratulation-medal" alt="Medal Pic"/>
                            </div>
                        </div>
                    </div>
                    <!--/ Medal Card -->

                    <!-- Statistics Card -->
                    <!--/ Statistics Card -->
                </div>  --}}

                <div class="row match-height">
                    {{--  <div class="col-lg-4 col-12">
                        <div class="row match-height">
                            <!-- Bar Chart - Orders -->
                            <div class="col-lg-6 col-md-3 col-6">
                                <div class="card">
                                    <div class="card-body pb-50">
                                        <h6>@lang('Total Received Amount')</h6>
                                        <h3 class="mb-75 mt-2 pt-50">
                                            <a href="#">{{$total_received}}</a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <!--/ Bar Chart - Orders -->

                            <!-- Line Chart - Profit -->
                            <div class="col-lg-6 col-md-3 col-6">
                                <div class="card card-tiny-line-stats">
                                    <div class="card-body pb-50">
                                        <h6>@lang('Total Due Amount')</h6>
                                        <h3 class="mb-75 mt-2 pt-50">
                                            <a href="#">{{$toal_due_amount}}</a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <!--/ Line Chart - Profit -->

                            <!-- Earnings Card -->
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="card earnings-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <h4 class="card-title mb-1">@lang('Total Tender Amount')</h4>
                                                <div class="font-small-2">@lang('This Month')</div>
                                                <h3 class="mb-75 mt-1 pt-50">
                                                    <a href="#">{{$total_budget}}</a>
                                                </h3>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Earnings Card -->
                        </div>
                    </div>  --}}

                    <!-- Todays official Expense Report Card -->
                    <div class="col-lg-12 col-12">
                        <div class="card card-revenue-budget">
                            <div class="row mx-0">
                                <div class="col-12 mt-2">
                                    <h4 class="card-title">@lang("Today's official Expense")</h4>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>@lang('Bank Account')</th>
                                            <th>@lang('Description')</th>
                                            <th>@lang('Total')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($official_expenses[0]))
                                        @foreach ($official_expenses as $expense )
                                            <tr>
                                                <td>{{  $loop->iteration }}</td>
                                                <td>{{ $expense->account ? $expense->account->name : '' }}</td>
                                                <td>{{ $expense->description }}</td>
                                                <td>{{ $expense->grand_total }}</td> 
                                            </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Expenses Report Card -->
                    <!-- Recent Tenders Report Card -->
                    <div class="col-lg-12 col-12">
                        <div class="card card-revenue-budget">
                            <div class="row mx-0">
                                <div class="col-12 mt-2">
                                    <h4 class="card-title">@lang('Recent Tenders')</h4>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>@lang('Tender No')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Bank Account')</th>
                                            <th>@lang('Working Time')</th>
                                            <th>@lang('Budget')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($recent_tenders[0]))
                                        @foreach ($recent_tenders as $tender )
                                            <tr>
                                                <td>{{ $tender->tender_no }}</td>
                                                <td>{{ $tender->name }}</td>
                                                <td>{{ $tender->account ? $tender->account->name : '' }}</td>
                                                <td>{{ $tender->working_time }}</td>
                                                <td>{{ $tender->budget }}</td> 
                                            </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Recent Tenders Report Card -->

                   
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')
{{--    <script src="{{asset('assets/admin/vendors/js/charts/apexcharts.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/admin/js/scripts/pages/dashboard-ecommerce.js')}}"></script>--}}
@endpush
