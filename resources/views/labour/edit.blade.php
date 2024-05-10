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
                                <form action="{{route('labour.update')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select Tender") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="select2-basic" name="tender">
                                                        {{--  <option value="{{ null }}">@lang('Select')</option>  --}}
                                                        @if(isset($tenders[0]))
                                                        @foreach ($tenders as $tender )
                                                            <option value="{{ $tender->id.'-'.$tender->tender_no }}" {{ $tender->id == $labour->tender_id ? 'selected' : '' }}>{{ $tender->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('tender')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{$labour->name}}"/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Phone') <span class="text-danger">*</span></label>
                                                <input type="text" id="phone" class="form-control" name="phone" value="{{$labour->phone}}"/>
                                                <span class="text-danger">{{$errors->first('phone')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="address">@lang('Address') <span class="text-danger">*</span></label>
                                                <input type="text" id="address" class="form-control" name="address" value="{{$labour->address}}"/>
                                                <span class="text-danger">{{$errors->first('address')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="joining_date">@lang('Joining Date') <span class="text-danger">*</span></label>
                                                <input type="date" id="joining_date" class="form-control" name="joining_date" value="{{$labour->joining_date}}"/>
                                                <span class="text-danger">{{$errors->first('joining_date')}}</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="edit_id" value="{{ $labour->id }}">
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
