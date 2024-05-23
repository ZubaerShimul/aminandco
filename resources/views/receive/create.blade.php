@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Receive Management'), 'subtitle'=> __('Receive'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Receive create')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('receive.store')}}" method="post" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Site/Partner Name") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="site" name="site" required>
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        @if(isset($data['sites'][0]))
                                                        @foreach ($data['sites'] as $site )
                                                            <option value="{{ $site->id.'-'.$site->name.'-'.$site->division.'-'.$site->area}}" >{{ $site->name}} </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('site')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="district">@lang('Division/District') <span class="text-danger">*</span></label>
                                                <input type="text" id="district" class="form-control" name="district" value="{{old('district')}}" required/>
                                                <span class="text-danger">{{$errors->first('district')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="area">@lang('Area') <span class="text-danger">*</span></label>
                                                <input type="text" id="area" class="form-control" name="area" value="{{old('area')}}" required/>
                                                <span class="text-danger">{{$errors->first('area')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Bank Name") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="account" name="account" required>
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        @if(isset($data['accounts'][0]))
                                                        @foreach ($data['accounts'] as $account )
                                                            <option value="{{ $account->id.'-'.$account->name.'-'.$account->account_number}}" >{{ $account->name}} </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('account')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="account_no">@lang('Ac Number')</label>
                                                <input type="text" id="account_no" class="form-control" name="account_no" value="{{old('account_no')}}"/>
                                                <span class="text-danger">{{$errors->first('account_no')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment Method") }}  <span class="text-danger">*</span></label>   
                                                    <select class="select2 form-select" id="select2-basic" name="payment_method" required>
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        @if(isset($data['payment_methods'][0]))
                                                        @foreach ($data['payment_methods'] as $payment_method )
                                                            <option value="{{ $payment_method->name}}">{{ $payment_method->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="net_payment_amount">@lang('Net Payment Amount') <span class="text-danger">*</span></label>
                                                <input type="number" id="net_payment_amount" class="form-control" name="net_payment_amount" value="{{old('net_payment_amount')}}" required/>
                                                <span class="text-danger">{{$errors->first('net_payment_amount')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="others_amount">@lang('Others Amount') </label>
                                                <input type="number" id="others_amount" class="form-control" name="others_amount" value="{{old('others_amount') }}"/>
                                                <span class="text-danger">{{$errors->first('others_amount')}}</span>
                                            </div>
                                        </div>                                                                            
{{--                                          
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="total">@lang('Total Amount')</label>
                                                <input type="number" id="total" class="form-control" name="total" value="{{old('total')}}"/>
                                                <span class="text-danger">{{$errors->first('total')}}</span>
                                            </div>
                                        </div>  --}}

                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="date">@lang('Receive Date')</label>
                                                <input type="date" id="date" class="form-control" name="date" value="{{old('date')}}"/>
                                                <span class="text-danger">{{$errors->first('date')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-8">
                                            <div class="mb-2">
                                                <label class="form-label" for="short_note">@lang('Short Note') </label>
                                                <input type="text" id="short_note" class="form-control" name="short_note" value="{{old('short_note')}}"/>
                                                <span class="text-danger">{{$errors->first('short_note')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="document">@lang('Upload File')</label>
                                                <input type="file" id="document" class="form-control" name="document" value="{{old('document')}}"/>
                                                <span class="text-danger">{{$errors->first('document')}}</span>
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


@push('script')



<script type="text/javascript">

    $(document).ready(function() {

        function totalPayment()
        {
            var Payment = $('#Payment').val;
            alert(Payment);

        }
     
      })
</script>
@endpush