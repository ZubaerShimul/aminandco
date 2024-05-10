@extends('layouts.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/invoice/css/style-rtl.css') }}">
    @endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Tender Management'), 'subtitle'=> __('Tender'), 'button' => __('')])
      
        <div class="content-body">
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <!-- Invoice -->
                    <div class="col-xl-12 col-md-8 col-12">
                        <div class="card invoice-preview-card">
                            <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div>
                                        <div class="logo-wrapper">
                                           
                                            <h3 class="text-primary invoice-logo">{{ $tender->name }}</h3>
                                        </div>
                                        <p class="card-text mb-25">Tender No : {{ $tender->tender_no }}</p>
                                        <p class="card-text mb-25">District : {{ $tender->district_name }}</p>
                                        <p class="card-text mb-25">Working Time : {{ $tender->working_time }}</p>
                                        <p class="card-text mb-25">Start Date : {{ $tender->start_date }}</p>
                                        <p class="card-text mb-25">End Date : {{ $tender->end_date }}</p>
                                        <p class="card-text mb-25 ">Due Days : {{Carbon\Carbon::parse($tender->end_date)->diffInDays($tender->start_date) }}</p>
                                        <p class="card-text mb-25 ">Budget : {{$tender->budget }}</p>
                                        <p class="card-text mb-25 ">Total Paid : {{ $data['payment'] }}</p>
                                        <p class="card-text mb-25 ">Total Due : {{$data['expense'] }}</p>
                                    </div>
                                    <div class="mt-md-0 mt-2">
                                        <h4 class="invoice-title">
                                            Bank Information
                                        </h4>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title">Bank Name: {{ $tender->account  ? $tender->account->name : ''  }}</p>
                                            <p class="invoice-date-title">Account No : {{ $tender->account  ? $tender->account->account_number : ''  }}</p>
                                            <p class="invoice-date-title">Bank Branch: {{ $tender->account  ? $tender->account->branch : ''  }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>

                            <hr class="invoice-spacing" />
                            <!-- payments received -->
                            <div class="table-responsive mt-2">
                                <div class="row" id="basic-table">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">@lang('Payments Received')</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="py-1">@lang("Received By")</th>
                                                            <th class="py-1">@lang("Bank Account ")</th>
                                                            <th class="py-1">@lang("Total")</th>
                                                        </tr>
                                                    </thead>
                                                    @if(isset($data['payments'][0]))
                                                    @foreach ($data['payments'] as $payment )
                                                    <tbody>                                      
                                                        <tr>
                                                            <td>
                                                                
                                                                <p class="card-text fw-bold mb-25"> {{ $payment->receiver }}</p>
                                                                <p class="card-text text-nowrap"> Date : {{ $payment->date }}</p>
                                                          
                                                            </td>
                                                            <td class="py-1">
                                                                <p class="card-text fw-bold mb-25"> Bank : {{ $payment->bank_name }}</p>
                                                                <p class="card-text text-nowrap"> Check No : {{ $payment->check_no }}</p>
                                                            </td>
                                                          
                                                            <td class="py-1">
                                                                <span class="fw-bold">{{ $payment->grand_total }} Tk</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    @endforeach
                                                    @else
                                                    <tbody>                                      
                                                        <tr>
                                                            <td>@lang("No payments Received")</td>
                                                        </tr>
                                                    </tbody>
                                                    @endif                                     
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Expenses start -->                            
                            <div class="table-responsive mt-2">
                                <div class="row" id="basic-table">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Expenses</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">                                            
                                                    <thead>
                                                        <tr>
                                                            <th class="py-1">@lang("Expense Description")</th>
                                                            <th class="py-1">@lang("Date")</th>
                                                            <th class="py-1">@lang("Total")</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($data['tender_expenses'][0]))
                                                            @foreach ($data['tender_expenses'] as $ex )
                                                            <tr>
                                                                <td class="py-1">
                                                                    <p class="card-text fw-bold mb-25">{{ $ex->category ? $ex->category->name :""  }}</p>
                                                                    <p class="card-text text-nowrap"> </p>
                                                                </td>
                                                                <td>
                                                                    {{ $ex->date }}
                                                                </td>
                                                                <td class="py-1">
                                                                    <span class="fw-bold">{{ $ex->grand_total }} Tk</span>
                                                                </td>
                                                            </tr>
                                                            @endforeach                                        
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Labour Salary -->
                            
                            <div class="table-responsive mt-2">
                                <div class="row" id="basic-table">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">@lang('Labour Salary Payments')</h4>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="py-1">@lang("Labour")</th>
                                                            <th class="py-1">@lang("Date")</th>
                                                            <th class="py-1">@lang("Total")</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       @if(isset($data['labour_expenses'][0]))
                                                            @foreach ($data['labour_expenses'] as $salary )
                                                            <tr>
                                                                <td class="py-1">
                                                                    <p class="card-text fw-bold mb-25">{{ $salary->labour ? $salary->labour->name :""  }}</p>
                                                                    <p class="card-text text-nowrap"> </p>
                                                                </td>
                                                                <td>
                                                                    {{ $salary->date }}
                                                                </td>
                                                                <td class="py-1">
                                                                    <span class="fw-bold">{{ $salary->grand_total }} Tk</span>
                                                                </td>
                                                            </tr>
                                                            @endforeach                                        
                                                       @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                            <br>

                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">Total Budget: {{ $tender->budget }}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">Total Payment: {{ $data['payment'] }}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">Total Expense : {{ $data['expense'] }}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Payment Due : {{ $tender->budget - $data['payment'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->

                            <hr class="invoice-spacing" />

                            <!-- Invoice Note starts -->
                            {{--  <div class="card-body invoice-padding pt-0">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="fw-bold">Note:</span>
                                        <span>It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance
                                            projects. Thank You!</span>
                                    </div>
                                </div>
                            </div>  --}}
                            <!-- Invoice Note ends -->
                        </div>
                    </div>
                    <!-- /Invoice -->

                    <!-- Invoice Actions -->
                    {{--  <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-primary w-100 mb-75" data-bs-toggle="modal" data-bs-target="#send-invoice-sidebar">
                                    Send Invoice
                                </button>
                                <button class="btn btn-outline-secondary w-100 btn-download-invoice mb-75">Download</button>
                                <a class="btn btn-outline-secondary w-100 mb-75" href="./app-invoice-print.html" target="_blank"> Print </a>
                                <a class="btn btn-outline-secondary w-100 mb-75" href="./app-invoice-edit.html"> Edit </a>
                                <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#add-payment-sidebar">
                                    Add Payment
                                </button>
                            </div>
                        </div>
                    </div>  --}}
                    <!-- /Invoice Actions -->
                </div>
            </section>

            <!-- Send Invoice Sidebar -->
            <div class="modal modal-slide-in fade" id="send-invoice-sidebar" aria-hidden="true">
                <div class="modal-dialog sidebar-lg">
                    <div class="modal-content p-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title">
                                <span class="align-middle">Send Invoice</span>
                            </h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <form>
                                <div class="mb-1">
                                    <label for="invoice-from" class="form-label">From</label>
                                    <input type="text" class="form-control" id="invoice-from" value="shelbyComapny@email.com" placeholder="company@email.com" />
                                </div>
                                <div class="mb-1">
                                    <label for="invoice-to" class="form-label">To</label>
                                    <input type="text" class="form-control" id="invoice-to" value="qConsolidated@email.com" placeholder="company@email.com" />
                                </div>
                                <div class="mb-1">
                                    <label for="invoice-subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="invoice-subject" value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
                                </div>
                                <div class="mb-1">
                                    <label for="invoice-message" class="form-label">Message</label>
                                    <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="11" placeholder="Message...">
Dear Queen Consolidated,

Thank you for your business, always a pleasure to work with you!

We have generated a new invoice in the amount of $95.59

We would appreciate payment of this invoice by 05/11/2019</textarea>
                                </div>
                                <div class="mb-1">
                                    <span class="badge badge-light-primary">
                                        <i data-feather="link" class="me-25"></i>
                                        <span class="align-middle">Invoice Attached</span>
                                    </span>
                                </div>
                                <div class="mb-1 d-flex flex-wrap mt-2">
                                    <button type="button" class="btn btn-primary me-1" data-bs-dismiss="modal">Send</button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Send Invoice Sidebar -->

            <!-- Add Payment Sidebar -->
            <div class="modal modal-slide-in fade" id="add-payment-sidebar" aria-hidden="true">
                <div class="modal-dialog sidebar-lg">
                    <div class="modal-content p-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title">
                                <span class="align-middle">Add Payment</span>
                            </h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <form>
                                <div class="mb-1">
                                    <input id="balance" class="form-control" type="text" value="Invoice Balance: 5000.00" disabled />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="amount">Payment Amount</label>
                                    <input id="amount" class="form-control" type="number" placeholder="$1000" />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="payment-date">Payment Date</label>
                                    <input id="payment-date" class="form-control date-picker" type="text" />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="payment-method">Payment Method</label>
                                    <select class="form-select" id="payment-method">
                                        <option value="" selected disabled>Select payment method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Debit">Debit</option>
                                        <option value="Credit">Credit</option>
                                        <option value="Paypal">Paypal</option>
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="payment-note">Internal Payment Note</label>
                                    <textarea class="form-control" id="payment-note" rows="5" placeholder="Internal Payment Note"></textarea>
                                </div>
                                <div class="d-flex flex-wrap mb-0">
                                    <button type="button" class="btn btn-primary me-1" data-bs-dismiss="modal">Send</button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add Payment Sidebar -->

        </div>
    </div>

@endsection
