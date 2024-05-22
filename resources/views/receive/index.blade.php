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
        @include('widgets.breadcrumb', ['title' => __('Receive Management'), 'subtitle'=> __('Receive'), 'button' => '<a type="button" class="btn btn-primary" href="'.route('receive.create').'">'. __('Add New') .'</a>'])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body">

                    </div>
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-9">
                                <h4 class="card-title">@lang('Receive List')</h4>
                            </div>
                            <div class="col-md-3 ">
                            <div class="d-flex justify-content-end">
                                <a type="button" class="btn btn-info" id="btn-edit" style="display: none;" href="#">Edit</a>
                                <a type="button" class="btn btn-danger mx-1" id="btn-delete" style="display: none;" href="#">Delete</a>
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
                                <th>@lang('Division/District')</th>
                                <th>@lang('Area')</th>
                                <th>@lang('Bank Name')</th>
                                <th>@lang('Acc Number')</th>
                                <th>@lang('Pay Method')</th>
                                <th>@lang('Net R/P Amount')</th>
                                <th>@lang('Others Amount')</th>
                                <th>@lang('Grand Total')</th>
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
                {"data": "district"},
                {"data": "area"},
                {"data": "bank_name"},
                {"data": "account_no"},
                {"data": "payment_method"},
                {"data": "net_payment_amount"},
                {"data": "others_amount"},
                {"data": "total"},
                {"data": "actions", orderable: false, searchable: false}
            ],
        ajax: {
            url: '{{ route('receive.list') }}',
            type: 'GET',
            data: function (d) {
                d.tender_id = $('#tender').val(); // Pass the selected tender ID as parameter
            }
        },
        initComplete: function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const editButton = document.getElementById('btn-edit');
            const deleteButton = document.getElementById('btn-delete');
            let lastCheckedCheckbox = null;

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (lastCheckedCheckbox && lastCheckedCheckbox !== this) {
                        lastCheckedCheckbox.checked = false;
                    }
                    lastCheckedCheckbox = this;

                    const itemId = this.dataset.id;

                    // Update the route parameter with the checked item ID
                    editButton.href = this.checked ? "/receive-edit/" + itemId : "#";
                    deleteButton.href = this.checked ? "/receive-delete/" + itemId : "#";

                    // Show/hide edit and delete buttons based on checkbox state
                    editButton.style.display = this.checked ? 'inline-block' : 'none';
                    deleteButton.style.display = this.checked ? 'inline-block' : 'none';
                });
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
        $(document).on('click', '.delete', function () {
            return confirm("Are You Sure To Delete This!");
        });


    </script>
@endpush
