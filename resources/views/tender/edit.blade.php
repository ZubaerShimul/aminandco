@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Tender Management'), 'subtitle'=> __('Tender'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Tender Update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('tender.update')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Tender No.') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="tender_no" value="{{$tender->tender_no}}"/>
                                                <span class="text-danger">{{$errors->first('tender_no')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{$tender->name}}"/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>  
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select Bank Account") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="select2-basic" name="account" >
                                                        @if(isset($accounts[0]))
                                                        @foreach ($accounts as $account )
                                                            <option value = {{ $account->id }} {{ $tender->account_id == $account->id ?'selected' : '' }} >{{ $account->name }}</option>                                                        
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('account')}}</span>

                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select district") }} </label>
                                                    <select class="select2 form-select" id="select2-basic" name="district" >
                                                        <option value="{{ null }}">{{ __("Select") }}</option>
                                                        @if(isset($districts[0]))
                                                        @foreach ($districts as $district )
                                                            <option value = {{ $district->id.'-'.$district->name }} {{ $tender->district_id == $district->id ? 'selected' : '' }} >{{ $district->name }}</option>                                                        
                                                        @endforeach
                                                        @endif
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="working_time">@lang('Working Time') </label>
                                                <input type="text" id="working_time" class="form-control" name="working_time" value="{{$tender->working_time}}" placeholder="@lang("How many days")"/>
                                                <span class="text-danger">{{$errors->first('working_time')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="budget">@lang('Budget') </label>
                                                <input type="number" id="budget" class="form-control" name="budget" value="{{$tender->budget}}" placeholder="@lang("Enter only number")"/>
                                                <span class="text-danger">{{$errors->first('budget')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="start_date">@lang('Start Date') </label>
                                                <input type="date" id="start_date" class="form-control" name="start_date" value="{{$tender->start_date}}"/>
                                                <span class="text-danger">{{$errors->first('start_date')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="end_date">@lang('End Date') </label>
                                                <input type="date" id="end_date" class="form-control" name="end_date" value="{{$tender->end_date}}"/>
                                                <span class="text-danger">{{$errors->first('end_date')}}</span>
                                            </div>
                                        </div>                                        
                                        
                                        {{--  <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="opening_amount">@lang('Opening Amount') </label>
                                                <input type="number" id="opening_amount" class="form-control" name="opening_amount" value="{{$tender->opening_amount}}" placeholder="@lang("Enter only number")"/>
                                                <span class="text-danger">{{$errors->first('opening_amount')}}</span>
                                            </div>  --}}
                                        {{--  </div>                                                                             --}}
                                        
                                        {{--  <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select Status") }} </label>
                                                    <select class="select2 form-select" id="select2-basic" name="status">
                                                        <option value="{{ null }}">{{ __("Select") }}</option>
                                                        <option  value = {{ TENDER_STATUS_PENDING }} >@lang("Pending")</option>                                                        
                                                        <option  value = {{ TENDER_STATUS_ONGOING }} >@lang("Ongoing")</option>                                                        
                                                    </select>
                                            </div>
                                        </div>  --}}
                                        
                                        <input type="hidden" name="edit_id" value="{{ $tender->id }}">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-1">@lang('Update')</button>
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
