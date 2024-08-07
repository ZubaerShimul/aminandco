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
    <style>
        .table-responsive{
            padding: 20px;
        }
        .table > :not(caption) > * > * {
  padding: 0.72rem .5rem;
  background-color: var(--bs-table-bg);
  border-bottom-width: 1px;
  box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg); }
        .table td {
            font-size: 10px;
          }
        .table th {
        font-size: 8px !important;
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
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Receive Report'), 'subtitle'=> __('Receive'), 'button' => __('')])
        <!-- Basic Tables start -->
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Receive Report')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('report.receive')}}" method="get" class="form">
                                    @csrf
                                  
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-2">
                                            <label class="form-label" for="select2-basic">@lang("Select Receive From")</label>
                                            <select class="select2 form-select" id="select2-basic" name="site_id">
                                                <option value="{{ null }}">All</option>
                                            @if(isset($data['sites'][0]))
                                                @foreach ($data['sites'] as $site )
                                                    <option value="{{ $site->id }}" {{ $data['site_id'] == $site->id ? "selected" : "" }}>{{ $site->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                         </div>
                                    </div>
                                    
                                    <div class="col-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="from_date">@lang('From Date')</label>
                                            <input type="date" id="from_date" class="form-control" name="from_date" value="{{ isset($data['from_date']) ? $data['from_date'] :  old('from_date')}}"/>
                                            <span class="text-danger">{{$errors->first('from_date')}}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="to_date">@lang('To Date')</label>
                                            <input type="date" id="to_date" class="form-control" name="to_date" value="{{$data['to_date'] ? $data['to_date']:  Carbon\Carbon::now()->toDateString()}}"/>
                                            <span class="text-danger">{{$errors->first('to_date')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="select2-basic">@lang("District")</label>
                                            <select class="select2 form-select" id="select2-basic" name="district">
                                                <option value="{{ null }}">@lang("All")</option>
                                                @if(isset($data['districts'][0]))
                                                @foreach ($data['districts'] as $district )
                                                    <option value="{{ $district->division }}" {{ $data['district'] == $district->division ? "selected" : "" }}>{{ $district->division }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                         </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="select2-basic">@lang("Area")</label>
                                            <select class="select2 form-select" id="select2-basic" name="area">
                                                <option value="{{ null }}">@lang("All")</option>
                                            @if(isset($data['areas'][0]))
                                                @foreach ($data['areas'] as $area )
                                                    <option value="{{ $area->area }}" {{ $data['area'] == $area->area ? "selected" : "" }}>{{ $area->area }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                         </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="select2-basic">@lang("Select Bank Account")</label>
                                            <select class="select2 form-select" id="select2-basic" name="account_id">
                                                <option value="{{ null }}">@lang("All")</option>
                                                @if(isset($data['accounts'][0]))
                                                @foreach ($data['accounts'] as $account )
                                                    <option value="{{ $account->id }}" {{   $data['account_id'] == $account->id ? "selected" : ""  }}>{{ $account->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="select2-basic">{{ __("Payment Method") }}  </label>   
                                                <select class="select2 form-select" id="select2-basic" name="payment_method">
                                                    <option value="{{ null }}">@lang('All')</option>
                                                    @if(isset($data['payment_methods'][0]))
                                                    @foreach ($data['payment_methods'] as $payment_method )
                                                        <option value="{{ $payment_method->name}}" {{   $data['payment_method'] == $payment_method->name ? "selected" : ""  }}>{{ $payment_method->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-1 mx-auto">
                                        <button type="submit" class="btn btn-lg btn-primary me-1" style="float: right">@lang('Search')</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Basic Horizontal form layout section end -->
            </div>
            <div class="row" id="basic-table">
                <div class="col-12">
                    <div class="card">
                        {{--  <div class="card-header">
                            <h4 class="card-title">Report Receive</h4>
                        </div>  --}}
                        <div class="card-body">
                            <p class="card-text" style="padding: 20px;">Date: {{ !empty($data['from_date']) ? Carbon\Carbon::parse( $data['from_date'])->format('d/m/Y')  .' To '. Carbon\Carbon::parse( $data['to_date'])->format('d/m/Y') : "- ".Carbon\Carbon::parse( $data['to_date'])->format('d/m/Y')}}  </p>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th class="nowrap">Date</th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">District/ <br>Dicvision</th>
                                        <th class="text-nowrap">Area</th>
                                        <th class="text-nowrap">Bank Name</th>
                                        <th class="text-nowrap">Acc Number</th>
                                        <th class="text-nowrap">Pay. Method</th>
                                        <th class="text-nowrap">Net R Amount</th>
                                        <th class="text-nowrap">Others Amount</th>
                                        <th class="text-nowrap">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($receives[0]))
                                    @foreach ($receives as $receive )
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td class="nowrap">{{ Carbon\Carbon::parse($receive->date)->format('d/m/Y') }} </td>
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
                                    <td class="text-nowrap" style="font-weight:bold; background-color: #fff2cd">Total</td>
                                    <td class="text-nowrap" style="font-weight:bold; background-color: #B9D8AF !important">Tk. {{ $net_amount }}</td>
                                    <td class="text-nowrap" style="font-weight:bold; background-color: #EDD3DE !important">Tk. {{ $other_amount }}</td>
                                    <td class="text-nowrap" style="font-weight:bold; background-color: #CDE2F5 !important">Tk. {{ $total_amount }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Basic Tables end -->
            <div class="col-12">
                <a type="button" class="btn btn-primary me-1" href="{{ url('report/receive-print?to_date='.$data['to_date'].'&from_date='.$data['from_date'].'&site_id='.$data['site_id'].'&account_id='.$data['account_id']) }}" style="float: right">@lang('Print')</a>
            </div>
    </div>

@endsection

@push('script')
<script src="{{ asset('asset/app-assets/js/scripts/forms/form-select2.js') }}"></script>
    
@endpush
