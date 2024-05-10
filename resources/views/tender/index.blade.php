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
        @include('widgets.breadcrumb', ['title' => __('Tender Management'), 'subtitle'=> __('Tender'), 'button' => '<a type="button" class="btn btn-primary" href="'.route('tender.create').'">'. __('Add New') .'</a>'])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">@lang('Tender')</h4>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-list-table table report_cases">
                            <thead class="table-light">
                            <tr>
                                <th>@lang('Tender No')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Bank Account')</th>
                                <th>@lang('Working Time')</th>
                                <th>@lang('Start Date')</th>
                                <th>@lang('End Date')</th>
                                <th>@lang('Budget')</th>
                                {{--  <th>@lang('Paid')</th>
                                <th>@lang('Expense')</th>  --}}
                                <th>@lang('Payment Status')</th>
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

        $('input[type="search"]').on('input', function(){
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
        $('.table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            responsive: true,
            ajax: '{{route('tender.list')}}',
            order: [0, 'desc'],
            autoWidth: false,
            columnDefs: [
                {"targets": 0, "className": "text-center"},
                {"targets": 1, "className": "text-center"},
                {"targets": 2, "className": "text-left"},
                {"targets": 8, "className": "text-center"},

            ],
            columns: [
                {"data": "tender_no"},
                {"data": "name"},
                {"data": "account_id"},
                {"data": "working_time"},
                {"data": "start_date"},
                {"data": "end_date"},
                {"data": "budget"},
                {{--  {"data": "paid"},
                {"data": "expense"},  --}}
                {"data": "payment_status"},
                {"data": "actions", orderable: false, searchable: false}
            ]
        });

        $(document).on('click', '.delete', function () {
            return confirm("Are You Sure To Delete This!");
        });


    </script>
@endpush
