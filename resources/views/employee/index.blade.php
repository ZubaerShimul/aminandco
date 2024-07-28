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
            /* Flexbox for vertical alignment */
        .d-flex {
            display: flex;
            align-items: center; /* Vertically center the items */
        }

        .me-3 {
            margin-right: 1rem; /* Add margin to the right of the logo */
        }
        .receive-table  thead th, .table tfoot th{
            font-size: 0.7rem !important;
        }
        .table > :not(caption) > * > *{
            padding: .72rem .5rem !important;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Employee Management'), 'subtitle'=> __('Employee'), 'button' => '<a type="button" class="btn btn-primary" href="'.route('employee.create').'">'. __('Add New') .'</a>'])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body">

                    </div>
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-9">
                                <h4 class="card-title">@lang('Employee List')</h4>
                            </div>
                            <div class="col-md-3 ">
                                <div class="d-flex justify-content-end">
                                    @if(Auth::user()!=null && Auth::user()->enable_edit == 1 )
                                    <a type="button" class="btn btn-info" id="btn-edit" style="display: none;" href="#">Edit</a>
                                    @endif
                                    @if(Auth::user()!=null && Auth::user()->enable_delete == 1 )
                                    <a type="button" onclick="deleteConfirmation(event, this)"  class="btn btn-danger mx-1" id="btn-delete" style="display: none;" href="#">Delete</a>
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
                                <th>@lang('Name')</th>
                                <th>@lang('Designation')</th>
                                <th>@lang('Address')</th>
                                <th>@lang('NID No')</th>
                                <th>@lang('Contact No')</th>
                                <th>@lang('Blood Group')</th>
                                <th>@lang('Joining Date')</th>
                                <th>@lang('Resign Date')</th>
                                <th>@lang('Basic Salary')</th>
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
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="print-element">
                                <!-- Placeholder for details -->
                                <div id="detailsPlaceholder"></div>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-primary me-1" href="" id="printButton" style="float: right">@lang('Print')</a>
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
            {"targets": 1, "className": "text-center"},
            {"targets": 2, "className": "text-left"},
        ],
        columns: [
                {"data": "checkin", orderable: false, searchable: false},
                {"data": "name"},
                {"data": "designation"},
                {"data": "address"},
                {"data": "NID"},
                {"data": "contact_no"},
                {"data": "blood_group"},
                {"data": "joining_date"},
                {"data": "resigning_date"},
                {"data": "basic_salary"},
                {"data": "actions", orderable: false, searchable: false}
            ],
        ajax: {
            url: '{{ route('employee.list') }}',
            type: 'GET',
            data: function (d) {
                d.tender_id = $('#tender').val(); // Pass the selected tender ID as parameter
            }
        },
        initComplete: function() {
            const editButton = $('#btn-edit');
            const deleteButton = $('#btn-delete');
            let lastCheckedCheckbox = null;

            $('.table tbody').on('change', '.item-checkbox', function() {
                if (lastCheckedCheckbox && lastCheckedCheckbox !== this) {
                    lastCheckedCheckbox.checked = false;
                }
                lastCheckedCheckbox = this;

                const itemId = $(this).data('id');
                editButton.attr('href', this.checked ? "/employee-edit/" + itemId : "#");
                deleteButton.attr('href', this.checked ? "/employee-delete/" + itemId : "#");

                editButton.css('display', this.checked ? 'inline-block' : 'none');
                deleteButton.css('display', this.checked ? 'inline-block' : 'none');
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
            id: this.dataset.id,
            name: this.dataset.name,
            image: this.dataset.image,
            designation: this.dataset.designation,
            address: this.dataset.address,
            nid: this.dataset.nid,
            contact_no: this.dataset.contact_no,
            blood_group: this.dataset.blood_group,
            joining_date: this.dataset.joining_date,
            resigning_date: this.dataset.resigning_date,
            basic_salary: this.dataset.basic_salary,
        };
        $('#detailsPlaceholder').html(`
            <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-title">
                                <div class="mb-1 d-flex align-items-center">
                                    <img src="{{ asset('/assets/admin/images/admin-co.jpeg') }}" height="120" class="me-3">
                                    <div>
                                        <h2 class="mb-1">{{ allSetting('company_title') ? allSetting('company_title') : 'M/S Amin & CO' }}</h2>
                                        <p class="mb-1">1st Class Government contractor & Suppliers</p>
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-4 text-center mx-auto">
                                        <h4 class="font-size-16 border px-1 py-1">Employee Details</h4>
                                        <div class="info-item ">
                                            <img class="mx-auto" src=`+details.image+` style="width: 150px; height:150px;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="info-container">
                                        
                                        <div class="info-item">
                                            <span class="info-label">Name:</span>
                                            <span class="info-value">`+ details.name +`</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Designation:</span>
                                            <span class="info-value">`+ details.designation +`</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Address:</span>
                                            <span class="info-value">`+ details.address +`</span>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table receive-table align-middle table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th>NID No</th>
                                                <th>Contact No</th>
                                                <th>Blood Group</th>
                                                <th>Joining Date</th>
                                                <th>Resign Date</th>
                                                <th class="text-end" style="width: 120px;">Basic Salary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row">`+ details.nid +`</td>
                                                <td>
                                                    `+ details.contact_no +`
                                                </td>
                                                <td>
                                                        `+ details.blood_group +`
                                                </td>
                                                <td>
                                                        `+ details.joining_date +`
                                                </td>
                                                <td>
                                                        `+ details.resigning_date +`
                                                </td>
                                                <td class="text-end">
                                                        `+ details.basic_salary +`
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
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
        </div>
        `);
        document.getElementById("printButton").href='/employee-details-print/'+details.id+'';
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
