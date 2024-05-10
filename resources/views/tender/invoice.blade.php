<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <style>
        body{
            font-family: Helvetica, serif;
        }
        @page {
            size: a4 portrait;
            margin: 100px 25px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
   
        <div class="content-wrapper">
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
                                            <p class="card-text mb-25 ">Total Paid : {{ $payment }}</p>
                                            <p class="card-text mb-25 ">Total Due : {{$expense }}</p>
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
    
                                <hr class="invoice-spacing" />
                                <!-- Invoice Description starts -->
                                @if(isset($payments[0]))
                                <h4>Payment Received</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="py-1">@lang("Received By")</th>
                                                <th class="py-1">@lang("Bank Account ")</th>
                                                <th class="py-1">@lang("Total")</th>
                                            </tr>
                                        </thead>
                                        @foreach ($payments as $pay )
                                        <tbody>                                      
                                            <tr>
                                                <td>
                                                    
                                                    <p class="card-text fw-bold mb-25"> {{ $pay->receiver }}</p>
                                                    <p class="card-text text-nowrap"> Date : {{ $pay->date }}</p>
                                              
                                                </td>
                                                <td class="py-1">
                                                    <p class="card-text fw-bold mb-25"> Bank : {{ $pay->bank_name }}</p>
                                                    <p class="card-text text-nowrap"> Check No : {{ $pay->check_no }}</p>
                                                </td>
                                              
                                                <td class="py-1">
                                                    <span class="fw-bold">{{ $pay->grand_total }} Tk</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach                                        
                                    </table>
                                </div>
                                @endif
    
                                <br>
                                <h4>Expenses</h4>
                                
    
                                <!-- Invoice Description starts -->
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
                                           @if(isset($tender_expenses[0]))
                                                @foreach ($tender_expenses as $ex )
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
    
                                <br>
                                <h4>Labou Salary</h4>
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
                                           @if(isset($labour_expenses[0]))
                                                @foreach ($labour_expenses as $salary )
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
    
                                <div class="card-body invoice-padding pb-0">
                                    <div class="row invoice-sales-total-wrapper">
                                        <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                            <div class="invoice-total-wrapper">
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Total Budget: {{ $tender->budget }}</p>
                                                </div>
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Total Payment: {{ $payment }}</p>
                                                </div>
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Total Expense : {{ $expense }}</p>
                                                </div>
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title"> Payment Due : {{ $tender->budget - $payment }}</p>
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
    
            </div>
        </div>
    </div>
</body>
</html>