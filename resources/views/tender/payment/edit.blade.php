@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Payment Management'), 'subtitle'=> __('Payment'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Payment Update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('payment.update')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select Tender") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="select2-basic" name="tender">
                                                        @if(isset($tenders[0]))
                                                        @foreach ($tenders as $tender )
                                                          <option value="{{ $tender->id}}" {{ $tender->id == $payment->tender_id ? 'selected' : '' }}>{{ $tender->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('tender')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="receiver">@lang('Receiver')</label>
                                                <input type="string" id="receiver" class="form-control" name="receiver" value="{{$payment->receiver}}"/>
                                                <span class="text-danger">{{$errors->first('receiver')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="bank_name">@lang('Bank Name')</label>
                                                <input type="string" id="bank_name" class="form-control" name="bank_name" value="{{$payment->bank_name}}"/>
                                                <span class="text-danger">{{$errors->first('bank_name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="check_no">@lang('Check Number')</label>
                                                <input type="string" id="check_no" class="form-control" name="check_no" value="{{$payment->check_no}}"/>
                                                <span class="text-danger">{{$errors->first('check_no')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="account">@lang('Deposit Bank Account') <span class="text-danger">*</span></label>
                                                <input type="text" id="account" class="form-control"  value="{{$payment->account->name}}" readonly/>
                                                <input type="hidden" name="account" value="{{ $payment->account_id }}">
                                                <span class="text-danger">{{$errors->first('account')}}</span>
                                            </div>
                                        </div>                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment Method") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="select2-basic" name="payment_method">
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                       <option value="Cash" {{ $payment->payment_method == 'Cash' ? 'selected' : '' }}>@lang('Cash')</option>
                                                       <option value="Mobile Banking" {{ $payment->payment_method == 'Mobile Banking' ? 'selected' : '' }}>@lang('Mobile Banking')</option>
                                                       <option value="Bank" {{ $payment->payment_method == 'Bank' ? 'selected' : '' }}>@lang('Bank')</option>
                                                    </select>
                                                <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="total_amount">@lang('Total Amount') <span class="text-danger">*</span></label>
                                                <input type="number" id="total_amount" class="form-control" name="total_amount" value="{{$payment->total_amount}}"/>
                                                <span class="text-danger">{{$errors->first('total_amount')}}</span>
                                            </div>
                                        </div>
                                        {{--  <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="addjustment">@lang('Discount/Adjustment') <span class="text-danger">*</span></label>
                                                <input type="text" id="addjustment" class="form-control" name="addjustment" value="{{old('addjustment')}}"/>
                                                <span class="text-danger">{{$errors->first('addjustment')}}</span>
                                            </div>
                                        </div>  --}}
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="date">@lang('Date') <span class="text-danger">*</span></label>
                                                <input type="date" id="date" class="form-control" name="date" value="{{$payment->date}}"/>
                                                <span class="text-danger">{{$errors->first('date')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="description">@lang('Description')</label>
                                                <textarea type="text" id="description" class="form-control" name="description">{{$payment->description}} </textarea>
                                                <span class="text-danger">{{$errors->first('description')}}</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="edit_id" value="{{ $payment->id }}">
                                       
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-1">@lang('Submit')</button>
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
    </div>

@endsection

