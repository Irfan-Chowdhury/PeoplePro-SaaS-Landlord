@extends('layout.main')
@section('content')


    <link rel="stylesheet" href="<?php echo asset('../../css/kendo.default.v2.min.css') ?>" type="text/css">

    <script type="text/javascript" src="<?php echo asset('../../js/kendo.all.min.js') ?>"></script>

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <span id="form_result_permission"></span>

                    <h1 class="text-center mt-2">{{$role->name}}</h1>
                    <p>{{__('You can assign permission for this role')}}</p>

                    <div id="all_resources">
                        <div class="demo-section k-content">

                            <h4>{{__('Select modules')}}</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="treeview1"></div>
                                </div>
                                <div class="col-md-4">
                                    <div  id="treeview2"></div>
                                </div>
                                <div class="col-md-4">
                                    <div id="treeview3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-4">
                        <div class="col-md-6 offset-md-3">
                            <input id="role_id" type="hidden" name="role_id" value={{$role->id}}>
                            <button class="btn btn-primary btn-block" id="set_permission_btn" type="submit" class="roles-btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        var checkedNodes;

        let permissionsData = <?php echo json_encode($permissionsData); ?>;


        $(document).ready(function () {

            console.log(permissionsData); // Check the output in the browser's console

            $("ul#setting").siblings('a').attr('aria-expanded', 'true');
            $("ul#setting").addClass("show");
            $("ul#setting #role-menu").addClass("active");

            var target = '{{route('permissionDetails',$role->id)}}';
            $.ajax({
                type: "GET",
                url: target,
                dataType: 'json',
                success: function (result) {

                    // ======  Testing Start ======

                    // *********** Options - 4 **********.

                    var parentMap = {};

                    $("#treeview1").empty();
                    var dataSource = [];

                    $("#treeview2").empty();
                    var dataSource2 = [];

                    $("#treeview3").empty();
                    var dataSource3 = [];


                    // Construct parent-child relationship map
                    permissionsData.forEach(function (permission) {
                        if (!parentMap[permission.parent]) {
                            parentMap[permission.parent] = [];
                        }
                        parentMap[permission.parent].push(permission);
                    });

                    // Populate root items of dataSource
                    permissionsData.forEach(function (permission) {
                        if (permission.parent === null) {
                            var items = generateItems(permission.id);

                            if (permission.treeview === 1) {
                                dataSource.push({
                                    id: permission.id,
                                    text: permission.name,
                                    expanded: items.length > 0,
                                    checked: ($.inArray(permission.id, result) >= 0) ? true : false,
                                    items: items
                                });
                            }
                            else if (permission.treeview === 2) {
                                dataSource2.push({
                                    id: permission.id,
                                    text: permission.name,
                                    expanded: items.length > 0,
                                    checked: ($.inArray(permission.id, result) >= 0) ? true : false,
                                    items: items
                                });
                            }
                            else if (permission.treeview === 3) {
                                dataSource3.push({
                                    id: permission.id,
                                    text: permission.name,
                                    expanded: items.length > 0,
                                    checked: ($.inArray(permission.id, result) >= 0) ? true : false,
                                    items: items
                                });
                            }
                        }
                    });

                    function generateItems(parentId) {
                        var items = [];
                        var childPermissions = parentMap[parentId];
                        if (childPermissions) {
                            childPermissions.forEach(function (childPermission) {
                                var childItems = generateItems(childPermission.id);
                                var checked = ($.inArray(childPermission.id, result) >= 0) ? true : false;
                                items.push({
                                    id: childPermission.id,
                                    text: childPermission.name,
                                    expanded: true,
                                    checked: checked,
                                    items: childItems
                                });
                            });
                        }
                        return items;
                    }


                    $("#treeview1").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: dataSource
                    });

                    $("#treeview2").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: dataSource2
                    });

                    $("#treeview3").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: dataSource3
                    });


                    // *********** Options - 3 **********

                    // $("#treeview1").empty();
                    // var dataSource = [];

                    // // Group permissionsData by treeview value
                    // var groupedData = permissionsData.reduce(function (acc, permission) {
                    //     if (!acc[permission.treeview]) {
                    //         acc[permission.treeview] = [];
                    //     }
                    //     acc[permission.treeview].push(permission);
                    //     return acc;
                    // }, {});

                    // // return console.log(groupedData);

                    // // Build dataSource for KendoTreeView
                    // for (var treeview in groupedData) {
                    //     // return console.log(groupedData);
                    //     var items = [];
                    //     groupedData[treeview].forEach(function (permission) {
                    //         var checked = ($.inArray(permission.id, result) >= 0) ? true : false;
                    //         items.push({
                    //             id: permission.id,
                    //             text: permission.name,
                    //             checked: checked
                    //         });
                    //     });

                    //     dataSource.push({
                    //         id: 'treeview-' + treeview,
                    //         text: 'TreeView ' + treeview,
                    //         expanded: groupedData[treeview][0].is_expand,
                    //         items: items
                    //     });
                    // }

                    // $("#treeview1").kendoTreeView({
                    //     checkboxes: {
                    //         checkChildren: true
                    //     },
                    //     check: onCheck,
                    //     dataSource: dataSource
                    // });

                    // *********** Options - 2 **********


                    // $("#treeview1").empty();
                    // var dataSourceConfig = {
                    //     checkboxes: {
                    //         checkChildren: true
                    //     },
                    //     check: onCheck,
                    //     dataSource: []
                    // };

                    // Dynamically populate the dataSource based on permissionsData
                    // for (var i = 0; i < permissionsData.length; i++) {
                    //     var permission = permissionsData[i];
                    //     var checked = ($.inArray(permission.id, result) >= 0) ? true : false;

                    //     dataSourceConfig.dataSource.push({
                    //         id: permission.id,
                    //         text: permission.name,
                    //         checked: checked
                    //     });
                    // }
                    // $("#treeview1").kendoTreeView(dataSourceConfig);

                    // ======  Testing End ======



                    // function that gathers IDs of checked nodes
                    function checkedNodeIds(nodes, checkedNodes) {

                        for (var i = 0; i < nodes.length; i++) {
                            if (nodes[i].checked) {
                                getParentIds(nodes[i], checkedNodes);
                                checkedNodes.push(nodes[i].id);
                            }

                            if (nodes[i].hasChildren) {
                                checkedNodeIds(nodes[i].children.view(), checkedNodes);
                            }
                        }
                    }

                    function getParentIds(node, checkedNodes) {
                        if (node.parent() && node.parent().parent() && checkedNodes.indexOf(node.parent().parent().id) == -1) {
                            getParentIds(node.parent().parent(), checkedNodes);
                            checkedNodes.push(node.parent().parent().id);
                        }
                    }

                    // show checked node IDs on datasource change
                    function onCheck() {
                        checkedNodes = [];
                        var treeView1 = $('#treeview1').data("kendoTreeView"),
                            message;
                        var treeView2 = $('#treeview2').data("kendoTreeView"),
                            message;
                        var treeView3 = $('#treeview3').data("kendoTreeView"),
                            message;


                        checkedNodeIds(treeView1.dataSource.view(), checkedNodes);
                        checkedNodeIds(treeView2.dataSource.view(), checkedNodes);
                        checkedNodeIds(treeView3.dataSource.view(), checkedNodes);

                        // if (checkedNodes.length > 0) {
                        //     message = "IDs of checked nodes: " + checkedNodes.join();
                        // } else {
                        //     message = "No nodes checked.";
                        // }
                        // $("#result").html(message);
                    }

                }
            });


            $('#set_permission_btn').on('click', function () {

                if (checkedNodes) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-T{{trans('file.OK')}}EN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var target = '{{route('set_permission')}}';

                    $.ajax({
                        type: 'POST',
                        url: target,
                        data: {
                            checkedId: checkedNodes,
                            roleId: "{{ $role->id}}",
                        },
                        success: function (data) {
                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                            }
                            if (data.error) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            $('#form_result_permission').html(html).slideDown(100).delay(3000).slideUp(100);
                        }
                    });
                } else {
                    alert('{{__('Please select atleast one checkbox')}}');
                }


            });

        });
    })(jQuery);
</script>
@endpush
