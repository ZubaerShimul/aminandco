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
                                <h4 class="card-title">{{__('Salary Update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('salary.update')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="date">@lang('Date') <span class="text-danger">*</span> </label>
                                            <input type="date" id="date" class="form-control" name="date" value="{{$salary->date}}" required/>
                                                <span class="text-danger">{{$errors->first('date')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select Employee") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="employee" name="employee" required>
                                                        <option value="{{ $salary->employee_id.'-'.$salary->name.'-'.$salary->designation}}">{{ $salary->name.' ('.$salary->designation.')' }}</option>
                                                        @if(isset($data['employees'][0]))
                                                        @foreach ($data['employees'] as $employee )
                                                            @if($employee->id != $salary->employee_id)
                                                                <option value="{{ $employee->id.'-'.$employee->name.'-'.$employee->designation}}" {{ $salary->employee_id == $employee->id ? 'selected' : '' }} >{{ $employee->name.' ('.$employee->designation.')' }} </option>
                                                            @endif
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('employee')}}</span>
                                            </div>
                                        </div>
                                        {{--  <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select account") }} </label>
                                                    <select class="select2 form-select" id="select2-basic" name="account">
                                                        <option value="{{ $salary->account_id.'-'.$salary->bank_name}}">{{ $salary->bank_name }}</option>

                                                        @if(isset($data['accounts'][0]))
                                                        @foreach ($data['accounts'] as $account )
                                                            @if($account->id != $salary->account_id)
                                                                <option value="{{ $account->id.'-'.$account->name}}">{{ $account->name }}</option>
                                                            @endif
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('account')}}</span>
                                            </div>
                                        </div>  --}}
                                        
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="ta_da">@lang('Account') <span class="text-danger">*</span></label>
                                                <input type="text" id="account" class="form-control" name="account" value="{{$salary->bank_name}}" readonly/>
                                                <span class="text-danger">{{$errors->first('account')}}</span>
                                            </div>
                                        </div>      
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment Method") }} </label>   
                                                    <select class="select2 form-select" id="select2-basic" name="payment_method">
                                                        <option value="{{ $salary->payment_method}}">{{ $salary->payment_method }}</option>

                                                        @if(isset($data['payment_methods'][0]))
                                                        @foreach ($data['payment_methods'] as $payment_method )
                                                            @if($salary->payment_method != $payment_method->name )
                                                                <option value="{{ $payment_method->name}}">{{ $payment_method->name }}</option>
                                                            @endif
                                                         @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="salary">@lang('Salary') <span class="text-danger">*</span></label>
                                                <input type="number" id="salary" class="form-control" name="salary" value="{{$salary->salary}}" onkeyup="totalSalary()" required/>
                                                <span class="text-danger">{{$errors->first('salary')}}</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="ta_da">@lang('Ta/Da') <span class="text-danger">*</span></label>
                                                <input type="number" id="ta_da" class="form-control" name="ta_da" value="{{$salary->ta_da}}" required/>
                                                <span class="text-danger">{{$errors->first('ta_da')}}</span>
                                            </div>
                                        </div>                                       
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="mobile_bill">@lang('Mobile Bill') <span class="text-danger">*</span></label>
                                                <input type="number" id="mobile_bill" class="form-control" name="mobile_bill" value="{{$salary->mobile_bill}}" required/>
                                                <span class="text-danger">{{$errors->first('mobile_bill')}}</span>
                                            </div>
                                        </div>

                                                                              
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="total_salary">@lang('Total Salary')</label>
                                                <input type="number" id="total_salary" class="form-control" name="total_salary" value="{{$salary->total}}"/>
                                                <span class="text-danger">{{$errors->first('total_salary')}}</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $salary->id }}">*
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

        function totalSalary()
        {
            var salary = $('#salary').val;
            alert(salary);

        }
     
      })
</script>
@endpush