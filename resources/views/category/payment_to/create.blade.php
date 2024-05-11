@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Payment To Management'), 'subtitle'=> __('Payment To'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Payment To create')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('payment.to.store')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}" required/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="type">@lang('Type') <span class="text-danger">*</span></label>
                                                <input type="text" id="type" class="form-control" name="type" value="{{old('type')}}" required/>
                                                <span class="text-danger">{{$errors->first('type')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Mob No') <span class="text-danger">*</span></label>
                                                <input type="text" id="mobile_number" class="form-control" name="mobile_number" value="{{old('mobile_number')}}" required/>
                                                <span class="text-danger">{{$errors->first('mobile_number')}}</span>
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
