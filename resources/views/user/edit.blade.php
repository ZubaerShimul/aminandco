@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('User Management'), 'subtitle'=> __('User'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('User Update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('user.update')}}" method="post" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        {{--  Name  --}}
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{$data->name}}" required/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>
                                        {{--  Email  --}}
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="email">@lang('Email') <span class="text-danger">*</span></label>
                                                <input type="text" id="email" class="form-control" name="email" value="{{$data->email}}" required/>
                                                <span class="text-danger">{{$errors->first('email')}}</span>
                                            </div>
                                        </div>
                                        
                                        {{--  Mobile Number   --}}
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="mobile_number">@lang('Mobile Number')</label>
                                                <input type="text" id="mobile_number" class="form-control" name="mobile_number" value="{{$data->phone}}"/>
                                                <span class="text-danger">{{$errors->first('mobile_number')}}</span>
                                            </div>
                                        </div>                                       
                                        
                                        {{--  designation  --}}
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="designation">@lang('Designation')</label>
                                                <input type="text" id="designation" class="form-control" name="designation" value="{{$data->designation}}" required/>
                                                <span class="text-danger">{{$errors->first('designation')}}</span>
                                            </div>    
                                        </div>  
                                        {{--  Address  --}}
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="address">@lang('Address')</label>
                                                <input type="text" id="address" class="form-control" name="address" value="{{$data->address}}"/>
                                                <span class="text-danger">{{$errors->first('address')}}</span>
                                            </div>
                                        </div>       
                                        {{--  Password  --}}
                                        <div class="col-6">
                                            <label class="form-label" for="password">@lang('Password') <span class="text-danger">{{ " (If you don't change password, please leave it empty)" }}</span></label>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" aria-describedby="login-password" min="6" />
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="image">@lang('Permission')</label>
                                                <div class="demo-inline-spacing">
                                                    <div class="form-check form-check-primary">
                                                        <input type="checkbox" class="form-check-input" id="colorCheck1" name="edit"  {{ $data->enable_edit ? "checked" : '' }} />
                                                        <label class="form-check-label" for="colorCheck1">@lang("Edit")</label>
                                                    </div>
                                                    <div class="form-check form-check-warning">
                                                        <input type="checkbox" class="form-check-input" id="colorCheck4" name="delete" {{ $data->enable_delete ? "checked" : '' }} />
                                                        <label class="form-check-label" for="colorCheck4">@lang("Delete")</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="image">@lang('File')</label>
                                                <input type="file" id="image" class="form-control" name="image" value="{{$data->image}}"/>
                                                <span class="text-danger">{{$errors->first('image')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <img src="{{ $data->image }}" height="90" width="90" alt="">
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $data->id }}">
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

