@extends('layouts.master')

@push('style')
    <link href="{{asset('assets/vendors/datatables.net/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .card-datatable.table-responsive{
            padding: 20px;
        }
        .user-list-table td {
            font-size: 10px;
          }
        .report_cases th {
        font-size: 10px !important;
        }
      .info-container {
            display: flex;
            flex-direction: column;
        }
        .info-item {
            display: flex;
        }
        .info-label {
            width: 120px; /* Adjust the width as needed */
            font-weight: bold;
        }
        .info-value {
            flex: 1;
        }
        .nowrap {
        white-space: nowrap;
    }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Payment Management'), 'subtitle'=> __('Payment'), 'button' => '<a type="button" class="btn btn-primary" href="'.route('payment.create').'">'. __('Add New') .'</a>'])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body">

                    </div>
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">@lang('Payment List')</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end">
                                    @if(Auth::user()!=null && Auth::user()->is_admin)
                                    <a type="button" class="btn btn-success" id="btn-approve" style="display: none;" href="#">Approve</a>
                                    @endif
                                    @if(Auth::user()!=null && Auth::user()->enable_edit == 1 )
                                    <a type="button" class="btn btn-info  mx-1" id="btn-edit" style="display: none;" href="#">Edit</a>
                                    @endif
                                    @if(Auth::user()!=null && Auth::user()->enable_delete == 1 )
                                    <a type="button" onclick="deleteConfirmation(event, this)"  class="btn btn-danger" id="btn-delete" style="display: none;" href="#">Delete</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-list-table table report_cases">
                            <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>@lang('Date')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Site Name')</th>
                                <th>@lang('District')</th>
                                <th>@lang('Area')</th>
                                <th>@lang('Bank Name')</th>
                                <th>@lang('Acc Number')</th>
                                <th>@lang('Pay Method')</th>
                                <th>@lang('Net R/P Amount')</th>
                                <th>@lang('Others Amount')</th>
                                <th>@lang('Grand Total')</th>
                                <th>@lang('Approved')</th>
                                <th width="30px">@lang('Actions')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- list and filter end -->
            </section>
            <!-- Modal -->
                <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsModalLabel">Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Placeholder for details -->
                                <div id="detailsPlaceholder"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('assets/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>

    <script>
        $(document).ready(function() {
        var dataTable = $('.table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        order: [0, 'desc'],
        autoWidth: false,
        columnDefs: [
            {"targets": 0, "className": "text-center"},
            {"targets": 1, "className": "text-center nowrap"},
            {"targets": 2, "className": "text-center"},
            {"targets": 3, "className": "text-center"},
            {"targets": 4, "className": "text-center"},
            {"targets": 5, "className": "text-center"},
            {"targets": 6, "className": "text-center"},
            {"targets": 7, "className": "text-center"},
            {"targets": 8, "className": "text-center"},
            {"targets": 9, "className": "text-center"},
            {"targets": 10, "className": "text-center"},
            {"targets": 11, "className": "text-center"},
            {"targets": 12, "className": "text-center"},
            {"targets": 13, "className": "text-center"},
        ],
        columns: [
                {"data": "checkin", orderable: false, searchable: false},
                {"data": "date"}, 
                {"data": "name"}, 
                {"data": "site_name"},
                {"data": "district"},
                {"data": "area"},
                {"data": "site_bank_name"},
                {"data": "site_account_no"},
                {"data": "payment_method"},
                {"data": "net_payment_amount"},
                {"data": "others_amount"},
                {"data": "total"},
                {"data": "is_draft"},
                {"data": "actions", orderable: false, searchable: false}
            ],
        ajax: {
            url: '{{ route('payment.list') }}',
            type: 'GET',
            data: function (d) {
                d.tender_id = $('#tender').val(); // Pass the selected tender ID as parameter
            }
        },
        initComplete: function() {
            const editButton = $('#btn-edit');
            const deleteButton = $('#btn-delete');
            const approveButton = $('#btn-approve');
            let lastCheckedCheckbox = null;

            $('.table tbody').on('change', '.item-checkbox', function() {
                if (lastCheckedCheckbox && lastCheckedCheckbox !== this) {
                    lastCheckedCheckbox.checked = false;
                }
                lastCheckedCheckbox = this;

                const itemId = $(this).data('id');
                const isDraft = $(this).data('isdraft');
                editButton.attr('href', this.checked ? "/payment-edit/" + itemId : "#");
                deleteButton.attr('href', this.checked ? "/payment-delete/" + itemId : "#");
                approveButton.attr('href', this.checked ? "/payment-approved/" + itemId : "#");

                editButton.css('display', this.checked ? 'inline-block' : 'none');
                deleteButton.css('display', this.checked ? 'inline-block' : 'none');
                approveButton.css('display', (this.checked && isDraft==1) ? 'inline-block' : 'none');
                
            });
        }
    });

    // Handle change event of the select element
    $('#tender').on('change', function() {
        // Reload DataTable with the updated AJAX URL
        dataTable.ajax.reload();
    });

    $(document).on('click', '.action-btn', function() {
        // Fetch details using AJAX or any other method here
        var details = {
            date: this.dataset.date,
            name: this.dataset.name,
            site_name: this.dataset.site_name,
            district: this.dataset.district,
            area: this.dataset.area,
            bank_name: this.dataset.bank_name,
            account_no: this.dataset.account_no,
            payment_method: this.dataset.payment_method,
            net_payment_amount: this.dataset.net_payment_amount,
            others_amount: this.dataset.others_amount,
            total: this.dataset.total,
            short_note: this.dataset.short_note
        };
        $('#detailsPlaceholder').html(

        `<div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-title">
                                <div class="mb-4">
                                    <h2 class="mb-1">{{allSetting('company_title') ? allSetting('company_title') : 'M/S Amin & CO'}}</h2>
                                    <p class="mb-1">1st Class Government contractor & Suppliers</p>
                                </div>
                            </div>

                            <hr class="mt-2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-4 text-center mx-auto">
                                        <h4 class="font-size-16 border px-1 py-1">Payment Report</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="info-container">
                                        <div class="info-item">
                                            <span class="info-label">Pay To:</span>
                                            <span class="info-value">`+ details.name +`</span>
                                        </div>
                                         <div class="info-item">
                                            <span class="info-label">Site/Partner:</span>
                                            <span class="info-value">`+ details.site_name +`</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Division:</span>
                                            <span class="info-value">`+ details.district +`</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Area:</span>
                                            <span class="info-value">`+ details.area +`</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Bank Name:</span>
                                            <span class="info-value">`+ details.bank_name +`</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Acc. Number:</span>
                                            <span class="info-value">`+ details.account_no +`</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Print Date:</span>
                                            <span class="info-value">`+ details.date +`</span>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th>SN.</th>
                                                <th>P/R Date</th>
                                                <th>Payment Method</th>
                                                <th>Net P/R</th>
                                                <th>Others P/R</th>
                                                <th class="text-end" style="width: 120px;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">01</th>
                                                <td>
                                                    `+ details.date +`
                                                </td>
                                                <td>
                                                        `+ details.payment_method +`
                                                </td>
                                                <td>
                                                        `+ details.net_payment_amount +`
                                                </td>
                                                <td>
                                                        `+ details.others_amount +`
                                                </td>
                                                <td class="text-end">
                                                        `+ details.total +`
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="5" class="text-end">Grand Total= </th>
                                                <td class="text-end">
                                                    `+ details.total +`
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="py-4">
                                                    <h5 class="font-size-15 mb-1">Note: `+ details.short_note +`</h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-print-none">
                                    <div class="text-center">
                                            <h5 class="font-size-16">18, Gogan Babu Road (2nd Lane), Khulna</h5>
                                            <p class="">Call: 01711-331360 & 01971-331360 E-mail:mdruhulamin1968@gmail.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`);
            // '<p>Date: ' + details.date + '</p><p>Name: ' + details.name + '</p><p>Designation: ' + details.designation + '</p><p>Bank Name: ' + details.bank_name + '</p><p>Payment Method: ' + details.payment_method + '</p><p>Gross Salary: ' + details.salary + '</p><p>TA/DA: ' + details.ta_da + '</p><p>Total Salary: ' + details.total + '</p>');
        $('#detailsModal').modal('show');
    });
});

    </script>
    <script>

        $('input[type="search"]').on('input', function(){
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
        $(document).on('click', '#btn-delete', function () {
            return confirm("Are You Sure To Delete This!");
        });


    </script>
@endpush
