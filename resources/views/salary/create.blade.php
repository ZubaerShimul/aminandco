@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Salary Management'), 'subtitle'=> __('Salary'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Salary create')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('salary.store')}}" method="post" class="form">
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
                                                <label class="form-label" for="select2-basic">{{ __("Select Employee") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="employee" name="employee" required>
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        @if(isset($data['employees'][0]))
                                                        @foreach ($data['employees'] as $employee )
                                                            <option value="{{ $employee->id.'-'.$employee->name.'-'.$employee->designation}}" >{{ $employee->name }} </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('employee')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="form-label" for="designation">@lang('Designation') <span class="text-danger">*</span> </label>
                                                <input type="text" id="designation" class="form-control" name="designation" value="{{ old('designation') }}" readonly/>
                                                <span class="text-danger">{{$errors->first('designation')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
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
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment Method") }} </label>   
                                                    <select class="select2 form-select" id="select2-basic" name="payment_method">
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
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="salary">@lang('Salary') <span class="text-danger">*</span></label>
                                                <input type="number" id="salary" class="form-control" name="salary" value="{{old('salary')}}" required/>
                                                <span class="text-danger">{{$errors->first('salary')}}</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="ta_da">@lang('Ta/Da') <span class="text-danger">*</span></label>
                                                <input type="number" id="ta_da" class="form-control" name="ta_da" value="{{old('ta_da')}}" required/>
                                                <span class="text-danger">{{$errors->first('ta_da')}}</span>
                                            </div>
                                        </div>                                       
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="mobile_bill">@lang('Mobile Bill') <span class="text-danger">*</span></label>
                                                <input type="number" id="mobile_bill" class="form-control" name="mobile_bill" value="{{old('mobile_bill')}}" required/>
                                                <span class="text-danger">{{$errors->first('mobile_bill')}}</span>
                                            </div>
                                        </div>

                                                                              
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="total_salary">@lang('Total Salary')</label>
                                                <input type="number" id="total_salary" class="form-control" name="total_salary" value="{{old('total_salary')}}" readonly/>
                                                <span class="text-danger">{{$errors->first('total_salary')}}</span>
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
            $('#employee').on('change', function() {
                var employeeId = $(this).val();

                if (employeeId) {
                    $.ajax({
                        url: '/employee/' + employeeId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.error) {
                                $('#designation').val('');
                                $('#salary').val('');
                                console.log(data.error);
                            } else {
                                $('#designation').val(data.designation);
                                $('#salary').val(data.salary);
                            }
                        }
                    });
                } else {
                    $('#designation').val('');
                    $('#salary').val('');
                }
            });
        });
        
        $('#salary, #mobile_bill, #ta_da').on('input', function() {
                calculateTotalSalary();
        });

        function calculateTotalSalary() {
            var salary = parseFloat($('#salary').val()) || 0;
            var mobileBill = parseFloat($('#mobile_bill').val()) || 0;
            var taDa = parseFloat($('#ta_da').val()) || 0;
            var totalSalary = salary + mobileBill + taDa;
            $('#total_salary').val(totalSalary.toFixed(2));
        }
     
    });
</script>
@endpush