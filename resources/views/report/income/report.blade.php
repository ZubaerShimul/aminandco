<?php
    $receive = 0;
    $payment = 0;
    $expense = 0;
?>
@extends('layouts.master',['title' => __('Income Expenditure Report')])
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
        .table td {
            font-size: 10px;
          }
        .table th {
        font-size: 10px !important;
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
        @include('widgets.breadcrumb', ['title' => __('Income Expenditure Report'), 'subtitle'=> __('Income Expenditure'), 'button' => __('')])
        <!-- Basic Tables start -->
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Income Expenditure Report')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('report.income')}}" method="get" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="mb-2">
                                                <label class="form-label" for="from_date">@lang('From Date')</label>
                                                <input type="date" id="from_date" class="form-control" name="from_date" value="{{ isset($data['from_date']) ? $data['from_date'] :  old('from_date')}}"/>
                                                <span class="text-danger">{{$errors->first('from_date')}}</span>
                                            </div>
                                        </div>                                        
                                        <div class="col-2">
                                            <div class="mb-2">
                                                <label class="form-label" for="to_date">@lang('To Date')</label>
                                                <input type="date" id="to_date" class="form-control" name="to_date" value="{{$data['to_date'] ? $data['to_date']:  Carbon\Carbon::now()->toDateString()}}"/>
                                                <span class="text-danger">{{$errors->first('to_date')}}</span>
                                            </div>
                                        </div>                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Site/Partner")</label>
                                                <select class="select2 form-select" id="select2-basic" name="site_id">
                                                    <option value="{{ null }}">All</option>
                                                @if(isset($data['sites'][0]))
                                                    @foreach ($data['sites'] as $site )
                                                        <option value="{{ $site->id }}" {{ $data['site_id'] == $site->id ? "selected" : "" }}>{{ $site->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                             </div>
                                        </div>
                                                                                
                                        <div class="col-2">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Division")</label>
                                                <select class="select2 form-select" id="select2-basic" name="division">
                                                    <option value="{{ null }}">All</option>
                                                @if(isset($data['divisions'][0]))
                                                    @foreach ($data['divisions'] as $division )
                                                        <option value="{{ $division->division }}" {{ $data['division'] == $division->division ? "selected" : "" }}>{{ $division->division }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                             </div>
                                        </div>                                        
                                        <div class="col-2">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Area")</label>
                                                <select class="select2 form-select" id="select2-basic" name="area">
                                                    <option value="{{ null }}">All</option>
                                                @if(isset($data['areas'][0]))
                                                    @foreach ($data['areas'] as $area )
                                                        <option value="{{ $area->area }}" {{ $data['area'] == $area->area ? "selected" : "" }}>{{ $area->area }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                             </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-1 mx-auto">
                                            <button type="submit" class="btn btn-lg btn-primary me-1" style="float: right">@lang('Search')</button>
                                        </div>
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
                            <p class="card-text" style="padding: 20px;">Date: {{ !empty($data['from_date']) ? Carbon\Carbon::parse( $data['from_date'])->format('d/m/Y')  .' To '. Carbon\Carbon::parse( $data['to_date'])->format('d/m/Y') : "Until - ".Carbon\Carbon::parse( $data['to_date'])->format('d/m/Y')}}  </p>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Date</th>
                                        <th>Site Name</th>
                                        <th>Division</th>
                                        <th>Area</th>
                                        <th>Receive</th>
                                        <th>Payment</th>
                                        <th>Expense</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($transactions[0]))
                                    @foreach ($transactions as $transaction )
                                       <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <td class="nowrap">{{ Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }} </td>
                                            <td>{{ $transaction->site ? $transaction->site->name : null }} </td>
                                            <td>{{ $transaction->site ? $transaction->site->division : null }} </td>
                                            <td>{{ $transaction->site ? $transaction->site->area : null }} </td>
                                            <td>{{ $transaction->description =='Receive' ? $transaction->cash_in : '-' }} </td>
                                            <td>{{ $transaction->description =='Payment' ? $transaction->cash_out : '-' }} </td>
                                            <td>{{ $transaction->trnxable_type =='App\Models\Expense' ? $transaction->cash_out : '-' }} </td>
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
                                    <td class="nowrap" style="font-weight:bold; background-color: #fff2cd">Total</td>
                                    <td class="nowrap" style="font-weight:bold; background-color: #6c9473 !important">Tk. {{ $receive }}{{ number_format($receive,2) }}</td>
                                    <td class="nowrap" style="font-weight:bold; background-color: #9c716d !important">Tk. {{ number_format($payment,2) }}</td>
                                    <td class="nowrap" style="font-weight:bold; background-color: #93a8b5 !important">Tk. {{ number_format($expense,2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Basic Tables end -->
            <div class="col-12">
                <a type="button" class="btn btn-primary me-1" href="{{ url('report/income-print?to_date='.$data['to_date'].'&from_date='.$data['from_date'].'&site_id='.$data['site_id'].'&division='.$data['division'].'&area='.$data['area']) }}" style="float: right">@lang('Print')</a>
            </div>
    </div>

@endsection

@push('script')
<script src="{{ asset('asset/app-assets/js/scripts/forms/form-select2.js') }}"></script>
    
@endpush
