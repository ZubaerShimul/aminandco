<?php
    $amount = 0;
?>
@extends('layouts.master',['title' => __('Expense Report')])
@push('style')
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
<!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Expense Report'), 'subtitle'=> __('Expense'), 'button' => __('')])
        <!-- Basic Tables start -->
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Expense Report')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('report.expense')}}" method="get" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Expense Type")</label>
                                                <select class="select2 form-select" id="select2-basic" name="type">
                                                    <option value="{{ null }}">@lang("Select Expense Type")</option>
                                                    <option value="{{ EXPENSE_TYPE_OFFICIAL }}" {{   $data['type'] == EXPENSE_TYPE_OFFICIAL ? "selected" : ""  }}>{{ EXPENSE_TYPE_OFFICIAL }}</option>
                                                    <option value="{{ EXPENSE_TYPE_OTHERS }}" {{   $data['type'] == EXPENSE_TYPE_OTHERS ? "selected" : ""  }}>{{ EXPENSE_TYPE_OTHERS }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Site/Partner")</label>
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
                                        
                                        {{--  <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">@lang("Select Bank Account")</label>
                                                <select class="select2 form-select" id="select2-basic" name="account_id">
                                                    <option value="{{ null }}">@lang("Select Bank Account")</option>
                                                    @if(isset($data['accounts'][0]))
                                                    @foreach ($data['accounts'] as $account )
                                                        <option value="{{ $account->id }}" {{   $data['account_id'] == $account->id ? "selected" : ""  }}>{{ $account->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>  --}}
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="from_date">@lang('From Date')</label>
                                                <input type="date" id="from_date" class="form-control" name="from_date" value="{{ isset($data['from_date']) ? $data['from_date'] :  old('from_date')}}"/>
                                                <span class="text-danger">{{$errors->first('from_date')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="to_date">@lang('To Date')</label>
                                                <input type="date" id="to_date" class="form-control" name="to_date" value="{{$data['to_date'] ? $data['to_date']:  Carbon\Carbon::now()->toDateString()}}"/>
                                                <span class="text-danger">{{$errors->first('to_date')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-1" style="float: right">@lang('Search')</button>
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
                            <div class="card-header">
                                <h4 class="card-title">Report Expense</h4>
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
                                            <th>Ex. Type</th>
                                            @if($data['type'] != EXPENSE_TYPE_OFFICIAL)
                                            <th>Site Name</th>
                                            <th>Dicvision</th>
                                            <th>Area</th>
                                            @endif
                                            <th>Note</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @if(isset($expenses[0]))
                                       @foreach ($expenses as $expense )
                                       <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <td>{{ Carbon\Carbon::parse($expense->date)->format('d M, Y') }} </td>
                                            <td>{{ $expense->name }} </td>
                                            <td>{{ $expense->type }} </td>
                                            @if($data['type'] != EXPENSE_TYPE_OFFICIAL)
                                                <td>{{ $expense->site_name }} </td>
                                                <td>{{ $expense->division }} </td>
                                                <td>{{ $expense->area }} </td>
                                            @endif
                                            <td>{{ $expense->note }} </td>
                                            <td>{{ $expense->amount }} </td>
                                        </tr>
                                        @php
                                            $amount     += $expense->amount;
                                        @endphp
                                       @endforeach
                                       @endif
                                       <tr>
                                        <td </td>
                                        @if($data['type'] != EXPENSE_TYPE_OFFICIAL)
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        @endif
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold">Total</td>
                                        <td </td>
                                        <td style="font-weight:bold">Tk. {{ $amount }}</td>
                                       </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basic Tables end -->
                <div class="col-12">
                    <a type="button" class="btn btn-primary me-1" href="{{ url('report/expense-print?to_date='.$data['to_date'].'&from_date='.$data['from_date'].'&site_id='.$data['site_id'].'&type='.$data['type']) }}" style="float: right">@lang('Print')</a>
                </div>
    </div>

@endsection

@push('script')
<script src="{{ asset('asset/app-assets/js/scripts/forms/form-select2.js') }}"></script>
    
@endpush
