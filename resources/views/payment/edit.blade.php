@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Payment Management'), 'subtitle'=> __('Payment'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Payment Update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('payment.update')}}" method="post" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-8">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment To") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="payment_to" name="payment_to" required>
                                                        <option value="{{ $payment->payment_to_id.'-'.$payment->name}}" >{{ $payment->name}} </option>
                                                        @if(isset($data['payment_tos'][0]))
                                                        @foreach ($data['payment_tos'] as $payment_to )
                                                            <option value="{{ $payment_to->id.'-'.$payment_to->name}}" >{{ $payment_to->name}} </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('payment_to')}}</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="date">@lang('Payment Date') <span class="text-danger">*</span> </label>
                                                <input type="date" id="date" class="form-control" name="date" value="{{$payment->date}}" required/>
                                                <span class="text-danger">{{$errors->first('date')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Site/Partner Name") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="site" name="site" required>
                                                        <option value="{{ $payment->site_id.'-'.$payment->site_name.'-'.$payment->division.'-'.$payment->area}}" >{{ $payment->site_name}} </option>
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
                                                <label class="form-label" for="select2-basic">{{ __("Division/ District") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="district" name="district" required>
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        @if(isset($data['districts'][0]))
                                                        @foreach ($data['districts'] as $district )
                                                            <option value="{{ $district->division}}" {{ $district->division == $payment->district ? "selected" : ""}}  >{{$district->division}} </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('district')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Area") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="area" name="area" required>
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        @if(isset($data['areas'][0]))
                                                        @foreach ($data['areas'] as $area )
                                                            <option value="{{ $area->area}}" {{ $area->area == $payment->area ? "selected" : ""}} >{{$area->area}} </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('area')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="site_bank_name">@lang('Bank Name')</label>
                                                <input type="text" id="site_bank_name" class="form-control" name="site_bank_name" value="{{$payment->site_bank_name}}"/>
                                                <span class="text-danger">{{$errors->first('site_bank_name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="account_no">@lang('Ac Number')</label>
                                                <input type="text" id="account_no" class="form-control" name="account_no" value="{{$payment->site_account_no}}"/>
                                                <span class="text-danger">{{$errors->first('account_no')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment Method") }}  <span class="text-danger">*</span></label>   
                                                    <select class="select2 form-select" id="select2-basic" name="payment_method" required>
                                                        <option value="{{ $payment->payment_method}}">{{ $payment->payment_method }}</option>
                                                        @if(isset($data['payment_methods'][0]))
                                                        @foreach ($data['payment_methods'] as $payment_method )
                                                            <option value="{{ $payment_method->name}}">{{ $payment_method->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                            </div>
                                        </div>
                                        {{--  <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select account") }} </label>
                                                    <select class="select2 form-select" id="select2-basic" name="account">
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        @if(isset($data['accounts'][0]))
                                                        @foreach ($data['accounts'] as $account )
                                                            <option value="{{ $account->id.'-'.$account->name}}">{{ $account->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('account')}}</span>
                                            </div>
                                        </div>  --}}

                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="net_payment_amount">@lang('Net Payment Amount') <span class="text-danger">*</span></label>
                                                <input type="number" id="net_payment_amount" class="form-control" name="net_payment_amount" value="{{$payment->net_payment_amount}}" required/>
                                                <span class="text-danger">{{$errors->first('net_payment_amount')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="others_amount">@lang('Others Amount') </label>
                                                <input type="number" id="others_amount" class="form-control" name="others_amount" value="{{$payment->others_amount }}"/>
                                                <span class="text-danger">{{$errors->first('others_amount')}}</span>
                                            </div>
                                        </div>                                                                            
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="total">@lang('Total Amount')</label>
                                                <input type="number" id="total" class="form-control" name="total" value="{{$payment->total}}" readonly/>
                                                <span class="text-danger">{{$errors->first('total')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="short_note">@lang('Short Note') </label>
                                                <input type="text" id="short_note" class="form-control" name="short_note" value="{{$payment->short_note}}"/>
                                                <span class="text-danger">{{$errors->first('short_note')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-3">
                                            <div class="mb-2">
                                                <label class="form-label" for="document">@lang('Upload File')</label>
                                                <input type="file" id="document" class="form-control" name="document" value="{{$payment->document}}"/>
                                                <span class="text-danger">{{$errors->first('document')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-2">
                                                <img src="{{ $payment->document }}" height="90" width="90" alt="">
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $payment->id }}">

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