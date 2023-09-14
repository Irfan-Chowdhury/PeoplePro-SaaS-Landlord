@extends('landlord.super-admin.layouts.master')
@section('landlord-content')


<div class="container-fluid mb-3">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Packages')}}</h3></div>
        <div class="card-body">
            <a href="{{route('package.create')}}" class="btn btn-info"><i class="dripicons-plus"></i> {{trans('file.Add Package')}}</a>&nbsp;
        </div>
    </div>
</div>



<div class="table-responsive">
    <table id="dataListTable" class="table">
        <thead>
            <tr>
                <th class="not-exported"></th>
                <th>{{trans('file.Name')}}</th>
                <th>{{trans('file.Free Trial')}}</th>
                <th>{{trans('file.Monthly Fee')}}</th>
                <th>{{trans('file.Yearly Fee')}}</th>
                <th>{{trans('file.Total User Account')}}</th>
                <th>{{trans('file.Total Employee')}}</th>
                <th class="not-exported">{{trans('file.Action')}}</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    let dataTableURL = "{{ route('package.datatable') }}";
    let destroyURL = '/super-admin/packages/destroy/';
</script>

<script type="text/javascript">
        (function ($) {
            "use strict";
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let table = $('#dataListTable').DataTable({
                    initComplete: function() {
                        this.api().columns([1]).every(function() {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>');
                                $('select').selectpicker('refresh');
                            });
                        });
                    },
                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: dataTableURL,
                    },
                    columns: [{
                            data: 'id',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'is_free_trial',
                            name: 'is_free_trial',
                        },
                        {
                            data: 'monthly_fee',
                            name: 'monthly_fee',
                        },
                        {
                            data: 'yearly_fee',
                            name: 'yearly_fee',
                        },
                        {
                            data: 'number_of_user_account',
                            name: 'number_of_user_account',
                        },
                        {
                            data: 'number_of_employee',
                            name: 'number_of_employee',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                        }
                    ],

                    "order": [],
                    'language': {
                        'lengthMenu': '_MENU_ {{ __('records per page') }}',
                        "info": '{{ trans('file.Showing') }} _START_ - _END_ (_TOTAL_)',
                        "search": '{{ trans('file.Search') }}',
                        'paginate': {
                            'previous': '{{ trans('file.Previous') }}',
                            'next': '{{ trans('file.Next') }}'
                        }
                    },
                    'columnDefs': [{
                            "orderable": false,
                            'targets': [0, 3],
                        },
                        {
                            'render': function(data, type, row, meta) {
                                if (type == 'display') {
                                    data =
                                        '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                                }

                                return data;
                            },
                            'checkboxes': {
                                'selectRow': true,
                                'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                            },
                            'targets': [0]
                        }
                    ],
                    'select': {
                        style: 'multi',
                        selector: 'td:first-child'
                    },
                    'lengthMenu': [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    dom: '<"row"lfB>rtip',
                    buttons: [{
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
                new $.fn.dataTable.FixedHeader(table);
            });

        })(jQuery);
</script>

<script type="text/javascript" src="{{ asset('js/landlord/common-js/delete.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>
@endpush
