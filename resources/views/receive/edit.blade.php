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
                                <h4 class="card-title">{{__('Receive Update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('receive.update')}}" method="post" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Site/Partner Name") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="site" name="site" required>
                                                        <option value="{{ $receive->site_id.'-'.$receive->site_name.'-'.$receive->division.'-'.$receive->area}}" >{{ $receive->name}} </option>
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
                                                <input type="text" id="district" class="form-control" name="district" value="{{$receive->district}}" required/>
                                                <span class="text-danger">{{$errors->first('district')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="area">@lang('Area') <span class="text-danger">*</span></label>
                                                <input type="text" id="area" class="form-control" name="area" value="{{$receive->area}}" required/>
                                                <span class="text-danger">{{$errors->first('area')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="bank_name">@lang('Bank Name')</label>
                                                <input type="text" id="bank_name" class="form-control" value="{{$receive->bank_name}}" readonly/>
                                                <span class="text-danger">{{$errors->first('bank_name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="account_no">@lang('Ac Number')</label>
                                                <input type="text" id="account_no" class="form-control" value="{{$receive->account_no}}" readonly/>
                                                <span class="text-danger">{{$errors->first('account_no')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment Method") }}  <span class="text-danger">*</span></label>   
                                                    <select class="select2 form-select" id="select2-basic" name="payment_method" required>
                                                        <option value="{{ $receive->payment_method}}">{{ $receive->payment_method }}</option>
                                                        @if(isset($data['payment_methods'][0]))
                                                        @foreach ($data['payment_methods'] as $receive_method )
                                                            <option value="{{ $receive_method->name}}">{{ $receive_method->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="net_payment_amount">@lang('Net Payment Amount') <span class="text-danger">*</span></label>
                                                <input type="number" id="net_payment_amount" class="form-control" name="net_payment_amount" value="{{$receive->net_payment_amount}}" required/>
                                                <span class="text-danger">{{$errors->first('net_payment_amount')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="others_amount">@lang('Others Amount') </label>
                                                <input type="number" id="others_amount" class="form-control" name="others_amount" value="{{$receive->others_amount }}"/>
                                                <span class="text-danger">{{$errors->first('others_amount')}}</span>
                                            </div>
                                        </div>                                                                            
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="total">@lang('Total Amount')</label>
                                                <input type="number" id="total" class="form-control" name="total" value="{{$receive->total}}"/>
                                                <span class="text-danger">{{$errors->first('total')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-8">
                                            <div class="mb-2">
                                                <label class="form-label" for="short_note">@lang('Short Note') </label>
                                                <input type="text" id="short_note" class="form-control" name="short_note" value="{{$receive->short_note}}"/>
                                                <span class="text-danger">{{$errors->first('short_note')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="date">@lang('Receive Date') <span class="text-danger">*</span> </label>
                                                <input type="date" id="date" class="form-control" name="date" value="{{$receive->date}}" required/>
                                                <span class="text-danger">{{$errors->first('date')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-8">
                                            <div class="mb-2">
                                                <label class="form-label" for="document">@lang('Upload File')</label>
                                                <input type="file" id="document" class="form-control" name="document" value="{{$receive->document}}"/>
                                                <span class="text-danger">{{$errors->first('document')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <img src="{{ $receive->document }}" height="90" width="90" alt="">
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $receive->id }}">

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


@push('script')
<script type="text/javascript">

    $(document).ready(function() {

        $(document).ready(function() {
            $('#site').on('change', function() {
                var siteID = $(this).val();

                if (siteID) {
                    $.ajax({
                        url: '/site/' + siteID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.error) {
                                $('#district').val('');
                                $('#area').val('');
                                console.log(data.error);
                            } else {
                                $('#district').val(data.district);
                                $('#area').val(data.area);
                            }
                        }
                    });
                } else {
                    $('#district').val('');
                    $('#area').val('');
                }
            });
        });

        $(document).ready(function() {
            $('#account').on('change', function() {
                var accountID = $(this).val();

                if (accountID) {
                    $.ajax({
                        url: '/bank-account/' + accountID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.error) {
                                $('#account_no').val('');
                                console.log(data.error);
                            } else {
                                $('#account_no').val(data.account_no);
                            }
                        }
                    });
                } else {
                    $('#account_no').val('');
                }
            });
        });
        
        $('#net_payment_amount, #others_amount').on('input', function() {
                calculateTotalSalary();
        });

        function calculateTotalSalary() {
            var net_payment_amount = parseFloat($('#net_payment_amount').val()) || 0;
            var others_amount = parseFloat($('#others_amount').val()) || 0;
            var total = net_payment_amount + others_amount;
            $('#total').val(total.toFixed(2));
        }
     
    });
</script>
@endpush