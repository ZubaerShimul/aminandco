@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Profile Management'), 'subtitle'=> __('Profile'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Profile update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('profile.update')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}"/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="email">@lang('Email') <span class="text-danger">*</span></label>
                                                <input type="text" id="email" class="form-control" name="email" value="{{$user->email}}"/>
                                                <span class="text-danger">{{$errors->first('email')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="phone">@lang('Phone') <span class="text-danger">*</span></label>
                                                <input type="text" id="phone" class="form-control" name="phone" value="{{$user->phone}}"/>
                                                <span class="text-danger">{{$errors->first('phone')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="address">@lang('Address') <span class="text-danger">*</span></label>
                                                <input type="text" id="address" class="form-control" name="address" value="{{$user->address}}"/>
                                                <span class="text-danger">{{$errors->first('address')}}</span>
                                            </div>
                                        </div>
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
