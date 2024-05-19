@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Labour Salary Management'), 'subtitle'=> __('Labour Salary'), 'button' => __('')])
        <div class="content-body">
            <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('Labour Salary update')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('salary.update')}}" method="post" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select Tender") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="tender" name="tender">
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                        @if(isset($tenders[0]))
                                                        @foreach ($tenders as $tender )
                                                            <option value="{{ $tender->id}}"  {{ $tender->id == $salary->tender_id ? 'selected' :  ''}}>{{ $tender->name }} </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                <span class="text-danger">{{$errors->first('tender')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6 labour-list">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Select Labour Salary labour") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="labour" name="labour">
                                                        <option value="{{ $salary->labour_id }}">{{ $salary->labour ? $salary->labour->name : '' }}</option>
                                                    </select>
                                                <span class="text-danger">{{$errors->first('labour')}}</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="paid_by">@lang('Paid By')</label>
                                                <input type="string" id="paid_by" class="form-control" name="paid_by" value="{{$salary->paid_by_name}}"/>
                                                <span class="text-danger">{{$errors->first('paid_by')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="account">@lang('Account') <span class="text-danger">*</span></label>
                                                <input type="text" id="account" class="form-control"  value="{{$salary->account->name}}" readonly/>
                                                <input type="hidden" name="account" value="{{ $salary->account_id }}">
                                                <span class="text-danger">{{$errors->first('account')}}</span>
                                            </div>
                                        </div>                                       
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="select2-basic">{{ __("Payment Method") }} <span class="text-danger">*</span></label>
                                                    <select class="select2 form-select" id="select2-basic" name="payment_method">
                                                        <option value="{{ null }}">@lang('Select')</option>
                                                       <option value="Cash" {{ $salary->payment_method == 'Cash' ? 'selected' : '' }}>@lang('Cash')</option>
                                                       <option value="Mobile Banking" {{ $salary->payment_method == 'Mobile Banking' ? 'selected' : '' }}>@lang('Mobile Banking')</option>
                                                       <option value="Bank" {{ $salary->payment_method == 'Bank' ? 'selected' : '' }}>@lang('Bank')</option>
                                                    </select>
                                                <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="total_amount">@lang('Total Amount') <span class="text-danger">*</span></label>
                                                <input type="number" id="total_amount" class="form-control" name="total_amount" value="{{$salary->total_amount}}"/>
                                                <span class="text-danger">{{$errors->first('total_amount')}}</span>
                                            </div>
                                        </div>
                                        {{--  <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="addjustment">@lang('Discount/Adjustment') <span class="text-danger">*</span></label>
                                                <input type="text" id="addjustment" class="form-control" name="addjustment" value="{{$salary->addjustment}}"/>
                                                <span class="text-danger">{{$errors->first('addjustment')}}</span>
                                            </div>
                                        </div>  --}}
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="form-label" for="date">@lang('Date')</label>
                                                <input type="date" id="date" class="form-control" name="date" value="{{$salary->date}}"/>
                                                <span class="text-danger">{{$errors->first('date')}}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="description">@lang('Description') </label>
                                                <textarea type="text" id="description" class="form-control" name="description">{{$salary->description}}</textarea>
                                                <span class="text-danger">{{$errors->first('description')}}</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="edit_id" value="{{ $salary->id }}">
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
    document.addEventListener('DOMContentLoaded', function(){
        const tenderSelect=$('#tender')
        const labourSelect= $('#labour');
        
        tenderSelect.change( function(){
            
            const tenderId=$(this).val();
            $.ajax({
                url: `/labour/${tenderId}`,
                method: 'GET',
                success: function (response) {
                     labourSelect.empty();
                     labourSelect.append($('<option>', {
                            value: '',
                            text: 'Select'
                        }));
                     $.each(response, function (index, labor) {
                        const option = $('<option>', {
                            value: labor.id,
                            text: labor.name 
                        });
                        //console.log(labor.id,labor.name);
                        labourSelect.append(option);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('AJAX request failed:', error);
                }
            });

        });
    });
</script>
@endpush