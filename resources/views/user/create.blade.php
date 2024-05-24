@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Employee Management'), 'subtitle'=> __('Employee'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Employee create')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('employee.store')}}" method="post" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}"/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="designation">@lang('Designation') <span class="text-danger">*</span></label>
                                                <input type="text" id="designation" class="form-control" name="designation" value="{{old('designation')}}"/>
                                                <span class="text-danger">{{$errors->first('designation')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="address">@lang('Address')</label>
                                                <input type="text" id="address" class="form-control" name="address" value="{{old('address')}}"/>
                                                <span class="text-danger">{{$errors->first('address')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="NID">@lang('NID') <span class="text-danger">*</span></label>
                                                <input type="text" id="NID" class="form-control" name="NID" value="{{old('NID')}}"/>
                                                <span class="text-danger">{{$errors->first('NID')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="blood_group">@lang('Blood Group')</label>
                                                <input type="text" id="blood_group" class="form-control" name="blood_group" value="{{old('blood_group')}}"/>
                                                <span class="text-danger">{{$errors->first('blood_group')}}</span>
                                            </div>
                                        </div>
{{--
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Blood Group") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="select2-basic" name="category_type">
                                                        <option value="{{ null }}">{{ __("Select") }}</option>
                                                        <option  value = "" >@lang(CATEGORY_TYPE_EXPENSE)</option>
                                                        <option  value = {{ CATEGORY_TYPE_INCOME }} >@lang(CATEGORY_TYPE_INCOME)</option>
                                                    </select>
                                                <span class="text-danger">{{$errors->first('category_type')}}</span>
                                            </div>
                                        </div> --}}

                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="contact_no">@lang('Contact No') <span class="text-danger">*</span></label>
                                                <input type="text" id="contact_no" class="form-control" name="contact_no" value="{{old('contact_no')}}"/>
                                                <span class="text-danger">{{$errors->first('contact_no')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="joining_date">@lang('Joining Date') <span class="text-danger">*</span></label>
                                                <input type="date" id="joining_date" class="form-control" name="joining_date" value="{{old('joining_date')}}"/>
                                                <span class="text-danger">{{$errors->first('joining_date')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="resigning_date">@lang('Resign Date') </label>
                                                <input type="date" id="resigning_date" class="form-control" name="resigning_date" value="{{old('resigning_date')}}"/>
                                                <span class="text-danger">{{$errors->first('resigning_date')}}</span>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="basic_salary">@lang('Basic Salary') <span class="text-danger">*</span></label>
                                                <input type="number" id="basic_salary" class="form-control" name="basic_salary" value="{{old('basic_salary')}}"/>
                                                <span class="text-danger">{{$errors->first('basic_salary')}}</span>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="image">@lang('File')</label>
                                                <input type="file" id="image" class="form-control" name="image" value="{{old('image')}}"/>
                                                <span class="text-danger">{{$errors->first('image')}}</span>
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

