<?php
    $net_amount = 0;
    $other_amount = 0;
    $total_amount = 0;
?>
@extends('layouts.master',['title' => __('Payment Report')])
@push('style')
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
<!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Payment Report'), 'subtitle'=> __('Payment'), 'button' => __('')])
        <!-- Basic Tables start -->
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Payment Report')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('report.payment')}}" method="get" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Select Payment To")</label>
                                                <select class="select2 form-select" id="select2-basic" name="payment_to_id">
                                                    <option value="{{ null }}">@lang("Select Payment To")</option>
                                                    @if(isset($data['payment_tos'][0]))
                                                    @foreach ($data['payment_tos'] as $payment_to )
                                                        <option value="{{ $payment_to->id }}" {{   $data['payment_to_id'] == $payment_to->id ? "selected" : ""  }}>{{ $payment_to->name }}</option>
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
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Select Site/Partner")</label>
                                                <select class="select2 form-select" id="select2-basic" name="site_id">
                                                    <option value="{{ null }}">@lang("Select Site/Partner")</option>
                                                @if(isset($data['sites'][0]))
                                                    @foreach ($data['sites'] as $site )
                                                        <option value="{{ $site->id }}" {{ $data['site_id'] == $site->id ? "selected" : "" }}>{{ $site->name.' - ('.$site->type.')' }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("District")</label>
                                                <select class="select2 form-select" id="select2-basic" name="district">
                                                    <option value="{{ null }}">@lang("Select District")</option>
                                                    @if(isset($data['districts'][0]))
                                                    @foreach ($data['districts'] as $district )
                                                        <option value="{{ $district->district }}" {{ $data['district'] == $district->district ? "selected" : "" }}>{{ $district->district }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Area")</label>
                                                <select class="select2 form-select" id="select2-basic" name="area">
                                                    <option value="{{ null }}">@lang("Select Area")</option>
                                                @if(isset($data['areas'][0]))
                                                    @foreach ($data['areas'] as $area )
                                                        <option value="{{ $area->area }}" {{ $data['area'] == $area->area ? "selected" : "" }}>{{ $area->area }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Bank Account")</label>
                                                <select class="select2 form-select" id="select2-basic" name="site_bank_name">
                                                    <option value="{{ null }}">@lang("Select Bank Account")</option>
                                                    @if(isset($data['accounts'][0]))
                                                    @foreach ($data['accounts'] as $account )
                                                        <option value="{{ $account->site_bank_name }}" {{   $data['site_bank_name'] == $account->site_bank_name ? "selected" : ""  }}>{{ $account->site_bank_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment Method") }}  </label>   
                                                    <select class="select2 form-select" id="select2-basic" name="payment_method">
                                                        <option value="{{ null }}">@lang('Select')</option>
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
                            <div class="row pt-1">
                                <div class="col-12 text-center">
                                        <h2 class="brand-text">{{allSetting('company_title') ? allSetting('company_title') : 'M/S Amin & CO'}}</h2>
                                        <h4>Payment Report</h4>
                                </div>
                            </div>
                            <div class="card-header text-center">
                                <h4 class="card-title">Date: {{ !empty($data['from_date']) ? Carbon\Carbon::parse($data['from_date'])->format('d/m/Y').' To '.Carbon\Carbon::parse($data['to_date'])->format('d/m/Y') : Carbon\Carbon::parse($data['to_date'])->format('d/m/Y')  }}</h4>
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
                                            <th>Name (Pay TO)</th>
                                            <th>Site/Partner</th>
                                            <th>District/Dicvision</th>
                                            <th>Area</th>
                                            <th>Bank Name</th>
                                            <th>Acc Number</th>
                                            <th>Pay. Method</th>
                                            <th>Net P Amount</th>
                                            <th>Others Amount</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @if(isset($payments[0]))
                                       @foreach ($payments as $payment )
                                       <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <td>{{ Carbon\Carbon::parse($payment->date)->format('d M, Y') }} </td>
                                            <td>{{ $payment->name }} </td>
                                            <td>{{ $payment->site_name }} </td>
                                            <td>{{ $payment->district }} </td>
                                            <td>{{ $payment->area }} </td>
                                            <td>{{ $payment->site_bank_name }} </td>
                                            <td>{{ $payment->site_account_no }} </td>
                                            <td>{{ $payment->payment_method }} </td>
                                            <td>{{ $payment->net_payment_amount }} </td>
                                            <td>{{ $payment->others_amount }} </td>
                                            <td>{{ $payment->total }} </td>
                                        </tr>
                                       @endforeach
                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold">Total</td>
                                        <td style="font-weight:bold">Tk. {{ $payments->sum('net_payment_amount') }}</td>
                                        <td style="font-weight:bold">Tk. {{ $payments->sum('others_amount') }}</td>
                                        <td style="font-weight:bold">Tk. {{ $payments->sum('total') }}</td>
                                       </tr>
                                       @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basic Tables end -->
                <div class="col-12">
                    <a type="button" class="btn btn-primary me-1" href="{{ url('report/payment-print?to_date='.$data['to_date'].'&from_date='.$data['from_date'].'&site_id='.$data['site_id'].'&site_bank_name='.$data['site_bank_name'].'&payment_to_id='.$data['payment_to_id']) }}" style="float: right">@lang('Print')</a>
                </div>
    </div>

@endsection

@push('script')
<script src="{{ asset('asset/app-assets/js/scripts/forms/form-select2.js') }}"></script>
    
@endpush
