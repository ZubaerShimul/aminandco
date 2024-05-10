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
        @include('widgets.breadcrumb', ['title' => __('Labour Management'), 'subtitle'=> __('Labour'), 'button' => '<a type="button" class="btn btn-primary" href="'.route('labour.create').'">'. __('Add New') .'</a>'])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-9">
                                <h4 class="card-title">@lang('Labour')</h4>
                            </div>
                            <div class="col-md-3 pull-right">
                                <div class="form-group text-right">
                                    <select name="tender" id="tender" class="form-control">
                                        <option value="">@lang('Select Tender')</option>
                                        @foreach ($tenders as $tender)
                                        <option value="{{ $tender->id }}">{{ $tender->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-list-table table report_cases">
                            <thead class="table-light">
                            <tr>
                                <th>@lang('Tender No.')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Phone')</th>
                                <th>@lang('Address')</th>
                                <th>@lang('Joining Date')</th>
                                <th width="30px">@lang('Actions')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- list and filter end -->
            </section>
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
                {"data": "tender_id"},
                {"data": "name"},
                {"data": "phone"},
                {"data": "address"},
                {"data": "joining_date"},
                {"data": "actions", orderable: false, searchable: false}
            ],
        ajax: {
            url: '{{ route('labour.list') }}',
            type: 'GET',
            data: function (d) {
                d.tender_id = $('#tender').val(); // Pass the selected tender ID as parameter
            }
        }
    });

    // Handle change event of the select element
    $('#tender').on('change', function() {
        // Reload DataTable with the updated AJAX URL
        dataTable.ajax.reload();
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
