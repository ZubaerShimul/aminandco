@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Password Management'), 'subtitle'=> __('Password'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Password update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('password.update')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="current_password">@lang('Current Password') <span class="text-danger">*</span></label>
                                                <input type="password" id="current_password" class="form-control" name="current_password"/>
                                                <span class="text-danger">{{$errors->first('current_password')}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="password">@lang('New Password') <span class="text-danger">*</span></label>
                                                <input type="password" id="password" class="form-control" name="password"/>
                                                <span class="text-danger">{{$errors->first('password')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="password_confirmation">@lang('Password Confirmation') <span class="text-danger">*</span></label>
                                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"/>
                                                <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                                            </div>
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
