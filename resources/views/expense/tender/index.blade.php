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
        @include('widgets.breadcrumb', ['title' => __('Expense Management'), 'subtitle'=> __('Expense'), 'button' => '<a type="button" class="btn btn-primary" href="'.route('expense.tender.create').'">'. __('Add New') .'</a>'])
        <div class="content-body">
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">@lang('Expense')</h4>
                         {{--  <select name="type" id="">Select Expense</select>  --}}
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-list-table table report_cases">
                            <thead class="table-light">
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('Bank Account')</th>
                                <th>@lang('Payment Method')</th>
                                <th>@lang('Description')</th>
                                <th>@lang('Amount')</th>
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
            ajax: '{{route('expense.tender.list')}}',
            order: [0, 'desc'],
            autoWidth: false,
            columnDefs: [
                {"targets": 0, "className": "text-center"},
                {"targets": 1, "className": "text-center"},
                {"targets": 2, "className": "text-left"},
            ],
            columns: [
                {"data": "date"},
                {"data": "account_id"},
                {"data": "payment_method"},
                {"data": "description"},
                {"data": "grand_total"},
                {"data": "actions", orderable: false, searchable: false}
            ]
        });

        $(document).on('click', '.delete', function () {
            return confirm("Are You Sure To Delete This!");
        });


    </script>
@endpush
