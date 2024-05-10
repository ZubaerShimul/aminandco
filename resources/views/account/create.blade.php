@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Bank Account Management'), 'subtitle'=> __('Bank Account'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Bank Account create')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('account.store')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Bank Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}"/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="account_number">@lang('Account number') </label>
                                                <input type="text" id="account_number" class="form-control" name="account_number" value="{{old('account_number')}}"/>
                                                <span class="text-danger">{{$errors->first('account_number')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="branch">@lang('Branch')</label>
                                                <input type="text" id="branch" class="form-control" name="branch" value="{{old('branch')}}"/>
                                                <span class="text-danger">{{$errors->first('branch')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="opening_balance">@lang('Opening Balance')</label>
                                                <input type="number" id="opening_balance" class="form-control" name="opening_balance" value="{{old('opening_balance')}}"/>
                                                <span class="text-danger">{{$errors->first('opening_balance')}}</span>
                                            </div>
                                        </div>
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
