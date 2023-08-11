<?php $__env->startSection('landlord-content'); ?>
<?php echo $__env->make('landlord.super-admin.pages.testimonials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="container">
    <div class="table-responsive">
        <table id="dataListTable" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(__('file.Image')); ?></th>
                    <th><?php echo e(__('file.Name')); ?></th>
                    <th class="not-exported"><?php echo e(__('Action')); ?></th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>

<?php echo $__env->make('landlord.super-admin.pages.testimonials.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        let dataTableURL = "<?php echo e(route('testimonial.datatable')); ?>";
        let storeURL = "<?php echo e(route('testimonial.store')); ?>";
        let editURL = "/super-admin/testimonials/edit/";
        let updateURL = '/super-admin/testimonials/update/';
        let destroyURL = '/super-admin/testimonials/destroy/';
        let sortURL = "<?php echo e(route('testimonial.sort')); ?>";

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
                        data: 'image',
                        name: 'image',
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
                    'lengthMenu': '_MENU_ <?php echo e(__('records per page')); ?>',
                    "info": '<?php echo e(trans('file.Showing')); ?> _START_ - _END_ (_TOTAL_)',
                    "search": '<?php echo e(trans('file.Search')); ?>',
                    'paginate': {
                        'previous': '<?php echo e(trans('file.Previous')); ?>',
                        'next': '<?php echo e(trans('file.Next')); ?>'
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
                    $("#editModal input[name='testimonial_id']").val(response.id);
                    $("#editModal input[name='name']").val(response.name);
                    $("#editModal input[name='business_name']").val(response.business_name);
                    $("#editModal input[name='description']").val(response.description);
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
    </script>

    <script type="text/javascript" src="<?php echo e(asset('js/landlord/common-js/iconTemplate.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/landlord/common-js/store.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/landlord/common-js/update.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/landlord/common-js/delete.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/landlord/common-js/alertMessages.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('landlord.super-admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/peopleprosaas/resources/views/landlord/super-admin/pages/testimonials/index.blade.php ENDPATH**/ ?>