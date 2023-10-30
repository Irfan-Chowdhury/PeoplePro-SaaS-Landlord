@extends('landlord.super-admin.layouts.master')
@section('landlord-content')
    @push('css')
        <style>
            #icons {
                opacity: 0;
                visibility: hidden;
            }

            .icon_collapse {
                height: 50vh;
                margin-top: 15px;
                overflow-y: scroll;
            }

            .icon_collapse section {
                padding: 30px 0 0;
            }

            .icon_collapse .card {
                background: #e5e6e7;
                margin: 0 15px;
            }

            .page-header {
                border-bottom: 1px solid #555;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .fa-hover {
                text-align: center;
                margin-bottom: 15px
            }

            .fa-hover a {
                cursor: pointer;
                font-size: 0px;
            }

            .fa-hover i:hover {
                opacity: 0.8;
            }

            .fa-hover i {
                color: #7c5cc4;
                display: block;
                font-size: 20px;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('feature.store') }}" id="submitForm">
                    @csrf
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Feature Section') }}</h4>
                        </div>
                        <div class="card-body collapse show" id="gs_collapse">
                            <p class="italic">
                                <small>@lang('file.The field labels marked with * are required input fields.')</small>
                            </p>
                            <div id="custom-field">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="font-weight-bold">@lang('file.Icon') <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" required name="icon" class="form-control icon"
                                            data-toggle="collapse" href="#icon_collapse" aria-expanded="false"
                                            aria-controls="icon_collapse"
                                            placeholder="{{ trans('file.Click to choose icon') }}" />
                                    </div>
                                    <div class="collapse icon_collapse" id="icon_collapse">
                                        <div class="card">
                                            <div class="card-body">
                                            </div>
                                        </div>
                                    </div>

                                    @include('landlord.super-admin.partials.input-field', [
                                        'colSize' => 4,
                                        'labelName' => 'Name',
                                        'fieldType' => 'text',
                                        'nameData' => 'name',
                                        'placeholderData' => 'Name',
                                        'isRequired' => true,
                                    ])
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mar-bot-30"
                                        id="submitButton">{{ trans('file.Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="table-responsive">
            <table id="dataListTable" class="table">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{ __('Icon') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th class="not-exported">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody id="tablecontents"></tbody>
            </table>
        </div>
    </div>

    @include('landlord.super-admin.partials.icon-template')
    @include('landlord.super-admin.pages.features.edit-modal')
@endsection


@push('scripts')
    <script type="text/javascript">
        let dataTableURL = "{{ route('feature.datatable') }}";
        let storeURL = "{{ route('feature.store') }}";
        let editURL = "/super-admin/features/edit/";
        let updateURL = '/super-admin/features/update/';
        let destroyURL = '/super-admin/features/destroy/';
        let sortURL = "{{ route('feature.sort') }}";

        (function($) {
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
                            data: 'icon',
                            name: 'icon',
                        },
                        {
                            data: 'name',
                            name: 'name',
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

            //--------- Edit -------
            $(document).on('click', '.edit', function() {
                let id = $(this).data("id");
                $.get({
                    url: editURL + id,
                    success: function(response) {
                        console.log(response);
                        $("#editModal input[name='feature_id']").val(response.id);
                        $("#editModal input[name='icon']").val(response.icon);
                        $("#editModal input[name='name']").val(response.name);
                        $('#editModal').modal('show');
                    }
                })
            });

            $("#tablecontents").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {
                var order = [];
                $('.edit').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.post({
                    url: sortURL,
                    data: {
                        order: order
                    },
                    success: function(response) {
                        console.log(response);
                        displaySuccessMessage(response.success)
                    }
                });
            }
        })(jQuery);
    </script>

    <script type="text/javascript" src="{{ asset('js/landlord/common-js/iconTemplate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/landlord/common-js/store.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/landlord/common-js/update.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/landlord/common-js/delete.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>
@endpush
