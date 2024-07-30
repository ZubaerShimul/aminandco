@extends('layouts.master')

@push('style')
    <link href="{{asset('assets/vendors/datatables.net/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .card-datatable.table-responsive{
            padding: 20px;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        @include('widgets.breadcrumb', ['title' => __('Salary Management'), 'subtitle'=> __('Salary'), 'button' => '<a type="button" class="btn btn-primary" href="'.route('salary.create').'">'. __('Add New') .'</a>'])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body">

                    </div>
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-9">
                                <h4 class="card-title">@lang('salary List')</h4>
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
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label" for="date">@lang('From Date') <span class="text-danger">*</span> </label>
                                    <input type="date" id="from_date" class="form-control" name="from_date"  required/>
                                    <span class="text-danger">{{$errors->first('date')}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label" for="date">@lang('To Date') <span class="text-danger">*</span> </label>
                                    <input type="date" id="to_date" class="form-control" name="to_date"  required/>
                                    <span class="text-danger">{{$errors->first('date')}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div>
                                <button type="submit" id="filter" class="btn btn-lg btn-primary" style="float: right">@lang('Filter')</button>
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
                                <th>@lang('Designation')</th>
                                <th>@lang('Gross Salary')</th>
                                <th>@lang('TA/DA')</th>
                                <th>@lang('Mobile Bill')</th>
                                <th>@lang('Total')</th>
                                {{--  <th width="30px">@lang('Actions')</th>  --}}
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
        order: [1, 'desc'],
        autoWidth: false,
        columnDefs: [
            {"targets": 0, "className": "text-center"},
            {"targets": 1, "className": "text-center"},
            {"targets": 2, "className": "text-center"},
            {"targets": 3, "className": "text-center"},
            {"targets": 4, "className": "text-center"},
            {"targets": 5, "className": "text-center"},
            {"targets": 6, "className": "text-center"},
            {"targets": 7, "className": "text-left"},
        ],
        columns: [
                {"data": "checkin", orderable: false, searchable: false},
                {"data": "date"}, 
                {"data": "name"}, 
                {"data": "designation"},
                {"data": "salary"},
                {"data": "ta_da"},
                {"data": "mobile_bill"},
                {"data": "total"},
                {{--  {"data": "actions", orderable: false, searchable: false}  --}}
            ],
        ajax: {
            url: '{{ route('salary.list') }}',
            type: 'GET',
            data: function (d) {
                d.tender_id = $('#tender').val(); 
                d.from_date = $('#from_date').val(); 
                d.to_date = $('#to_date').val(); 
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
                editButton.attr('href', this.checked ? "/salary-edit/" + itemId : "#");
                deleteButton.attr('href', this.checked ? "/salary-delete/" + itemId : "#");

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

    $('#filter').on('click', function() {
        // Reload DataTable with the updated AJAX URL

        if($('#from_date').val()=="") {
            alert("From Date is required");
        }else if($('#to_date').val()=="") {
            alert("To Date is required");
        }else{
            dataTable.ajax.reload();
        }
    });

    $(document).on('click', '.action-btn', function() {
        // Fetch details using AJAX or any other method here
        var details = {
            date: this.dataset.date,
            name: this.dataset.name,
            designation: this.dataset.designation,
            bank_name: this.dataset.bank_name,
            payment_method: this.dataset.payment_method,
            salary: this.dataset.salary,
            ta_da: this.dataset.ta_da,
            mobile_bill: this.dataset.mobile_bill,
            total: this.dataset.total,
        };
        $('#detailsPlaceholder').html(
            '<p>Date: ' + details.date + '</p><p>Name: ' + details.name + '</p><p>Designation: ' + details.designation + '</p><p>Bank Name: ' + details.bank_name + '</p><p>Payment Method: ' + details.payment_method + '</p><p>Gross Salary: ' + details.salary + '</p><p>TA/DA: ' + details.ta_da + '</p><p>Total Salary: ' + details.total + '</p>');
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
