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
        @include('widgets.breadcrumb', ['title' => __('Payment To Management'), 'subtitle'=> __('Payment To'), 'button' => ''])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('payment.to.store')}}" method="post" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-2">
                                        <label class="form-label" for="name">@lang('Name') <span class="text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" value="{{ isset($data) ? $data->name :  old('name')}}" required/>
                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-2">
                                        <label class="form-label" for="type">@lang('Type') <span class="text-danger">*</span></label>
                                        <input type="text" id="type" class="form-control" name="type" value="{{ isset($data) ? $data->type : old('type')}}" required/>
                                        <span class="text-danger">{{$errors->first('type')}}</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-2">
                                        <label class="form-label" for="name">@lang('Mob No') <span class="text-danger">*</span></label>
                                        <input type="text" id="mobile_number" class="form-control" name="mobile_number" value="{{isset($data) ? $data->mobile_number : old('mobile_number')}}" required/>
                                        <span class="text-danger">{{$errors->first('mobile_number')}}</span>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : null }}">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1">{{ isset($data) ? __("Update") : __("Add") }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-list-table table report_cases">
                            <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>@lang('Name')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Mob No')</th>
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
            {"targets": 2, "className": "text-left"},
        ],
        columns: [
                {"data": "checkin", orderable: false, searchable: false},
                {"data": "name"},
                {"data": "type"},
                {"data": "mobile_number"},
                {"data": "actions", orderable: false, searchable: false}
            ],
        ajax: {
            url: '{{ route('payment.to.list') }}',
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
                    editButton.href = this.checked ? "/payment-to-edit/" + itemId : "#";
                    deleteButton.href = this.checked ? "/payment-to-delete/" + itemId : "#";

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
            name: this.dataset.name,
            type: this.dataset.type,
            mobile_number: this.dataset.mobile_number,
        };
        $('#detailsPlaceholder').html('<p>Name: ' + details.name + '</p><p>Type: ' + details.type + '</p><p>Mobile No: ' + details.mobile_number + '</p>');
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
