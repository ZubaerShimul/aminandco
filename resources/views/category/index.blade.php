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
        @include('widgets.breadcrumb', ['title' => __('Category Management'), 'subtitle'=> __('Category'), 'button' => '<a type="button" class="btn btn-primary" href="'.route('category.create').'">'. __('Add New') .'</a>'])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-9">
                                <h4 class="card-title">@lang('Category')</h4>
                            </div>
                            <div class="col-md-3 pull-right">
                                <div class="form-group text-right">
                                    <select name="category" id="category" class="form-control">
                                        <option value="">@lang('Select category')</option>
                                        <option value="{{ CATEGORY_TYPE_EXPENSE }}">{{ CATEGORY_TYPE_EXPENSE }}</option>
                                        <option value="{{ CATEGORY_TYPE_INCOME }}">{{ CATEGORY_TYPE_INCOME }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-list-table table report_cases">
                            <thead class="table-light">
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Created at')</th>
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
        order: [0, 'asc'],
        autoWidth: false,
        columnDefs: [
            {"targets": 0, "className": "text-center"},
            {"targets": 1, "className": "text-center"},
            {"targets": 2, "className": "text-left"},
        ],
        columns: [
            {"data": "name"},
            {"data": "type"},
            {"data": "created_at"},
            {"data": "actions", orderable: false, searchable: false}
        ],
        ajax: {
            url: '{{ route('category.list') }}',
            type: 'GET',
            data: function (d) {
                d.category_type = $('#category').val(); // Pass the selected category ID as parameter
            }
        }
    });

    // Handle change event of the select element
    $('#category').on('change', function() {
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
