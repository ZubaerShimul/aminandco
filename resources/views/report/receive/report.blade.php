<?php
    $net_amount = 0;
    $other_amount = 0;
    $total_amount = 0;
?>
@extends('layouts.master',['title' => __('Receive Report')])
@push('style')
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
<!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Receive Report'), 'subtitle'=> __('Receive'), 'button' => __('')])
        <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Report Receive</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text"></p>
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
                <!-- Basic Tables end -->
                <div class="col-12">
                    <a type="button" class="btn btn-primary me-1" href="{{ url('report/receive-print?to_date='.$to_date.'&from_date='.$from_date) }}" style="float: right">@lang('Print')</a>
                </div>
    </div>

@endsection

@push('script')
<script src="{{ asset('asset/app-assets/js/scripts/forms/form-select2.js') }}"></script>
    
@endpush
