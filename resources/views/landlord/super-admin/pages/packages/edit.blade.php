@extends('landlord.super-admin.layouts.master')
@section('landlord-content')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/kendo.default.v2.min.css') }}" type="text/css">
@endpush


    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Edit Package') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            <form id="updateForm" action="{{ route('package.update', $package->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="package_id" id="modelId" value="{{ $package->id }}">

                                <div class="row">
                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Name',
                                        'fieldType' => 'text',
                                        'nameData' => 'name',
                                        'placeholderData' => 'Basic',
                                        'isRequired' => true,
                                        'valueData' => $package->name
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Free Trial',
                                        'fieldType' => 'checkbox',
                                        'nameData' => 'is_free_trial',
                                        'placeholderData' => null,
                                        'isRequired' => false,
                                        'isChecked' => $package->is_free_trial ? true : false
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Monthly Fee',
                                        'fieldType' => 'number',
                                        'nameData' => 'monthly_fee',
                                        'placeholderData' => '19',
                                        'isRequired' => true,
                                        'valueData' => $package->monthly_fee ?? null
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Yearly Fee',
                                        'fieldType' => 'number',
                                        'nameData' => 'yearly_fee',
                                        'placeholderData' => '200',
                                        'isRequired' => true,
                                        'valueData' => $package->yearly_fee ?? null
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Number of User Account (0 = Infinity)',
                                        'fieldType' => 'number',
                                        'nameData' => 'number_of_user_account',
                                        'placeholderData' => '5',
                                        'isRequired' => true,
                                        'valueData' => $package->number_of_user_account ?? 0
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Number of Employees (0 = Infinity)',
                                        'fieldType' => 'number',
                                        'nameData' => 'number_of_employee',
                                        'placeholderData' => '10',
                                        'isRequired' => true,
                                        'valueData' => $package->number_of_employee ?? 0
                                    ])

                                    <div class="col-md-12 mt-3">
                                        <h4>{{__('Select Features')}}</h4>
                                    </div>

                                    <div class="col-md-4">
                                        <div id="treeview1"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div  id="treeview2"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="treeview3"></div>
                                    </div>

                                    <input type="hidden" name="features[]" id="features">


                                    <div class="col-md-12 form-group mt-5">
                                        <input type="checkbox" name="is_update_existing" value="1">&nbsp; <strong>{{trans('file.Update existing customers who are using this package')}}</strong>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <button type="submit" id="updateButton" class="btn btn-primary">{{ trans('file.Update') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
<script type="text/javascript" src="{{ asset('js/kendo.all.min.js') }}"></script>
<script type="text/javascript">
    let updateURL = '/super-admin/packages/update/';

    (function($) {
        "use strict";

        var checkedNodes;

        let permissionNames = <?php echo json_encode($permissionNames); ?>;
        console.log(permissionNames);

        $(document).ready(function () {
            $("ul#setting").siblings('a').attr('aria-expanded', 'true');
            $("ul#setting").addClass("show");
            $("ul#setting #role-menu").addClass("active");

            $("#treeview1").empty();
            $("#treeview1").kendoTreeView({
                checkboxes: {
                    checkChildren: true
                },
                check: onCheck,
                dataSource: [
                    {
                        id: 'user',
                        text: "{{trans('User')}}",
                        checked: true,
                    },
                    {
                        id: 'details-employee',
                        text: "{{trans('Employee Details')}}",
                        checked: true,
                    },

                    {
                        id: 'customize-setting',
                        text: "{{__('Customize Setting')}}",
                        expanded: true,
                        checked: true,
                        items: [
                            {
                                id: 'role',
                                text: "{{trans('Role')}}",
                                checked: true,
                            },
                            {
                                id: 'general-setting',
                                text: "{{__('General Setting')}}",
                                checked: true,
                            },
                            {
                                id: 'mail-setting',
                                text: "{{__('Mail Setting')}}",
                                checked: true,
                            },
                            {
                                id: 'access-variable_type',
                                text: '{{__('Access Variable Type')}}',
                                checked: true,
                            },
                            {
                                id: 'access-variable_method',
                                text: '{{__('Access Variable Method')}}',
                                checked: true,
                            },
                            {
                                id: 'access-language',
                                text: '{{__('Access Language')}}',
                                checked: true,
                            },
                        ]
                    },
                    {
                        id: 'company',
                        text: "{{trans('Company')}}",
                        checked: true,
                    },
                    {
                        id: 'department',
                        text: "{{trans('Department')}}",
                        checked: true,
                    },
                    {
                        id: 'designation',
                        text: "{{trans('Designation')}}",
                        checked: true,
                    },
                    {
                        id: 'location',
                        text: "{{trans('Location')}}",
                        checked: true,
                    },

                    {
                        id: 'core_hr',
                        text: "{{trans('Core HR')}}",
                        expanded: true,
                        checked: ($.inArray('core_hr', permissionNames) >= 0) ? true : false,
                        items: [
                            {
                                id: 'view-calendar',
                                text: '{{__('View Calendar')}}',
                                checked: ($.inArray('view-calendar', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'promotion',
                                text: "{{trans('Promotion')}}",
                                checked: ($.inArray('promotion', permissionNames) >= 0) ? true : false,
                            },

                            {
                                id: 'award',
                                text: "{{trans('Award')}}",
                                checked: ($.inArray('award', permissionNames) >= 0) ? true : false,
                            },

                            {
                                id: 'transfer',
                                text: "{{trans('Transfer')}}",
                                checked: ($.inArray('transfer', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'travel',
                                text: "{{trans('Travel')}}",
                                checked: ($.inArray('travel', permissionNames) >= 0) ? true : false,
                            },

                            {
                                id: 'resignation',
                                text: "{{trans('Resignation')}}",
                                checked: ($.inArray('resignation', permissionNames) >= 0) ? true : false,
                            },

                            {
                                id: 'complaint',
                                text: "{{trans('Complaint')}}",
                                checked: ($.inArray('complaint', permissionNames) >= 0) ? true : false,
                            },

                            {
                                id: 'warning',
                                text: "{{trans('Warning')}}",
                                checked: ($.inArray('warning', permissionNames) >= 0) ? true : false,
                            },

                            {
                                id: 'termination',
                                text: "{{trans('Termination')}}",
                                checked: ($.inArray('termination', permissionNames) >= 0) ? true : false,
                            },
                        ]
                    },
                ]
            });


            $("#treeview2").empty();
            $("#treeview2").kendoTreeView({
                checkboxes: {
                    checkChildren: true
                },
                check: onCheck,
                dataSource: [
                    {
                        id: 'timesheet',
                        text: "{{trans('Timesheet')}}",
                        expanded: true,
                        items: [
                            {
                                id: 'attendance',
                                text: "{{trans('Attendance')}}",
                                checked: ($.inArray('attendance', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'office_shift',
                                text: "{{trans('Office Shift')}}",
                                checked: true,
                            },

                            {
                                id: 'holiday',
                                text: "{{trans('Holiday')}}",
                                checked: ($.inArray('holiday', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'leave',
                                text: "{{trans('Leave')}}",
                                checked: ($.inArray('leave', permissionNames) >= 0) ? true : false,
                            },
                        ]
                    },
                    {
                        id: 'payment-module',
                        text: "{{trans('Payment Module')}}",
                        checked: ($.inArray('payment-module', permissionNames) >= 0) ? true : false,
                    },
                    {
                        id: 'hr_report',
                        text: "{{trans('HR Reports')}}",
                        checked: ($.inArray('hr_report', permissionNames) >= 0) ? true : false,
                    },

                    {
                        id: 'recruitment',
                        text: "{{__('Recruitment')}}",
                        expanded: true,
                        checked: ($.inArray('recruitment', permissionNames) >= 0) ? true : false,
                        items: [
                            {
                                id: 'job_post',
                                text: "{{trans('Job Post')}}",
                                checked: ($.inArray('job_post', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'job_candidate',
                                text: "{{trans('Job Candidate')}}",
                                checked: ($.inArray('job_candidate', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'job_interview',
                                text: "{{trans('Job Interview')}}",
                                checked: ($.inArray('job_interview', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'cms',
                                text: "{{__('CMS')}}",
                                checked: ($.inArray('cms', permissionNames) >= 0) ? true : false,
                            }
                        ]
                    },
                    {
                        id: 'project-management',
                        text: "{{trans('Project Management')}}",
                        checked: ($.inArray('project-management', permissionNames) >= 0) ? true : false,
                        expanded: true,
                        items: [
                            {
                                id: 'project',
                                text: "{{trans('Project')}}",
                                checked: ($.inArray('project', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'task',
                                text: "{{trans('Task')}}",
                                checked: ($.inArray('task', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'client',
                                text: "{{trans('Client')}}",
                                checked: ($.inArray('client', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'invoice',
                                text: "{{trans('Invoice')}}",
                                checked: ($.inArray('invoice', permissionNames) >= 0) ? true : false,
                            },
                        ]
                    },
                    {
                        id: 'ticket',
                        text: "{{trans('Ticket')}}",
                        checked: ($.inArray('ticket', permissionNames) >= 0) ? true : false,
                    },
                    {
                        id: 'file_module',
                        text: "{{trans('File Module')}}",
                        checked: ($.inArray('file_module', permissionNames) >= 0) ? true : false,
                        expanded: true,
                        items: [
                            {
                                id: 'file_manager',
                                text: "{{trans('File Manager')}}",
                                checked: ($.inArray('file_manager', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'official_document',
                                text: "{{trans('Official Document')}}",
                                checked: ($.inArray('official_document', permissionNames) >= 0) ? true : false,
                            },
                        ]
                    },
                ]
            });


            $("#treeview3").empty();
            $("#treeview3").kendoTreeView({
                checkboxes: {
                    checkChildren: true
                },
                check: onCheck,
                dataSource: [
                    {
                        id: 'event-meeting',
                        text: "{{trans('Event and Meeting')}}",
                        checked: ($.inArray('event-meeting', permissionNames) >= 0) ? true : false,
                        expanded: true,
                        items: [
                            {
                                id: 'meeting',
                                text: "{{trans('Meeting')}}",
                                checked: ($.inArray('meeting', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'event',
                                text: "{{trans('Event')}}",
                                checked: ($.inArray('event', permissionNames) >= 0) ? true : false,
                            },
                        ]
                    },
                    {
                        id: 'assets-and-category',
                        text: "{{trans('Assets And Category')}}",
                        checked: ($.inArray('assets-and-category', permissionNames) >= 0) ? true : false,
                    },
                    {
                        id: 'finance',
                        text: "{{trans('Finance')}}",
                        checked: ($.inArray('finance', permissionNames) >= 0) ? true : false,
                        expanded: true,
                        items: [
                            {
                                id: 'account',
                                text: "{{trans('Account')}}",
                                checked: ($.inArray('account', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'expense',
                                text: "{{trans('Expense')}}",
                                checked: ($.inArray('expense', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'deposit',
                                text: "{{trans('Deposit')}}",
                                checked: ($.inArray('deposit', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'payer',
                                text: "{{trans('Payer')}}",
                                checked: ($.inArray('payer', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'payee',
                                text: "{{trans('payee')}}",
                                checked: ($.inArray('payee', permissionNames) >= 0) ? true : false,
                            },
                        ]
                    },
                    {
                        id: 'training_module',
                        text: "{{trans('Training Module')}}",
                        checked: ($.inArray('training_module', permissionNames) >= 0) ? true : false,
                        expanded: true,
                        items: [
                            {
                                id: 'trainer',
                                text: "{{trans('Trainer')}}",
                                checked: ($.inArray('trainer', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'training',
                                text: "{{trans('Training')}}",
                                checked: ($.inArray('training', permissionNames) >= 0) ? true : false,
                            },
                        ]
                    },
                    {
                        id: 'announcement',
                        text: "{{trans('Announcement')}}",
                        checked: ($.inArray('announcement', permissionNames) >= 0) ? true : false,
                    },
                    {
                        id: 'policy',
                        text: "{{trans('Policy')}}",
                        checked: ($.inArray('policy', permissionNames) >= 0) ? true : false,
                    },
                    {
                        id: 'performance',
                        text: "{{trans('Performance')}}",
                        checked: ($.inArray('performance', permissionNames) >= 0) ? true : false,
                        expanded: true,
                        items: [
                            {
                                id: 'goal-type',
                                text: "{{trans('Goal Type')}}",
                                checked: ($.inArray('goal-type', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'goal-tracking',
                                text: "{{trans('Goal Tracking')}}",
                                checked: ($.inArray('goal-tracking', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'indicator',
                                text: "{{trans('Indicator')}}",
                                checked: ($.inArray('indicator', permissionNames) >= 0) ? true : false,
                            },
                            {
                                id: 'appraisal',
                                text: "{{trans('Appraisal')}}",
                                checked: ($.inArray('appraisal', permissionNames) >= 0) ? true : false,
                            },
                        ]
                    },
                ]
            });
            onCheck();
        });

        let onCheck = () => {
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

            console.log(checkedNodes);
            $('#features').val(checkedNodes);
        }

        let checkedNodeIds = (nodes, checkedNodes) => {
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

        let getParentIds = (node, checkedNodes) => {
            if (node.parent() && node.parent().parent() && checkedNodes.indexOf(node.parent().parent().id) == -1) {
                getParentIds(node.parent().parent(), checkedNodes);
                checkedNodes.push(node.parent().parent().id);
            }
        }

    })(jQuery);
</script>

<script type="text/javascript" src="{{ asset('js/landlord/common-js/update.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>
@endpush
