@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Expense Management'), 'subtitle'=> __('Expense'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Expense create')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('expense.store')}}" method="post" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="date">@lang('Date') <span class="text-danger">*</span> </label>
                                                <input type="date" id="date" class="form-control" name="date" value="{{Carbon\Carbon::now()->toDateString()}}" required/>
                                                <span class="text-danger">{{$errors->first('date')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">@lang('Name') <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}" required/>
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            </div>
                                        </div>
                                      
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Expense Type") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="type" name="type" required>
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        <option value="{{ EXPENSE_TYPE_OFFICIAL }}" >{{EXPENSE_TYPE_OFFICIAL}} </option>
                                                        <option value="{{ EXPENSE_TYPE_OTHERS }}" >{{EXPENSE_TYPE_OTHERS}} </option>
                                                    </select>
                                                <span class="text-danger">{{$errors->first('type')}}</span>
                                            </div>
                                        </div>
                                        
                                        
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
                                                <input type="text" id="district" class="form-control" name="district" value="{{old('district')}}" readonly/>
                                                <span class="text-danger">{{$errors->first('district')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="area">@lang('Area') <span class="text-danger">*</span></label>
                                                <input type="text" id="area" class="form-control" name="area" value="{{old('area')}}" readonly/>
                                                <span class="text-danger">{{$errors->first('area')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
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
                                        </div>

                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Expense Method") }}  <span class="text-danger">*</span></label>   
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
                                                <label class="form-label" for="amount">@lang('Amount') <span class="text-danger">*</span></label>
                                                <input type="number" id="amount" class="form-control" name="amount" value="{{old('amount')}}" required/>
                                                <span class="text-danger">{{$errors->first('amount')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-8">
                                            <div class="mb-2">
                                                <label class="form-label" for="note">@lang('Note') </label>
                                                <input type="text" id="note" class="form-control" name="note" value="{{old('note')}}"/>
                                                <span class="text-danger">{{$errors->first('note')}}</span>
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
        
        $('#amount, #others_amount').on('input', function() {
                calculateTotalSalary();
        });

        function calculateTotalSalary() {
            var amount = parseFloat($('#amount').val()) || 0;
            var others_amount = parseFloat($('#others_amount').val()) || 0;
            var total = amount + others_amount;
            $('#total').val(total.toFixed(2));
        }
     
    });
</script>
@endpush