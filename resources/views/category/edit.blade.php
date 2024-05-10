@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Category Management'), 'subtitle'=> __('Category'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Category update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('category.update')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Category Type") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="select2-basic" name="category_type">
                                                        <option  value = {{ CATEGORY_TYPE_EXPENSE }} {{ $category->type == CATEGORY_TYPE_EXPENSE ? 'selected' : '' }}>@lang(CATEGORY_TYPE_EXPENSE)</option>                                                        
                                                        <option  value = {{ CATEGORY_TYPE_INCOME }} {{ $category->type == CATEGORY_TYPE_INCOME ? 'selected' : '' }}>@lang(CATEGORY_TYPE_INCOME)</option>                                                        
                                                    </select>
                                                <span class="text-danger">{{$errors->first('category_type')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="first_name">@lang('Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="first_name" class="form-control" name="name" value="{{$category->name}}"/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="edit_id" value="{{$category->id}}">
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
