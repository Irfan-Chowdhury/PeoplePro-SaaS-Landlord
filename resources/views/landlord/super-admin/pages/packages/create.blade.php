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
                            <h4>{{ trans('file.Add Package') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            <form id="submitForm" action="{{ route('package.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Name',
                                        'fieldType' => 'text',
                                        'nameData' => 'name',
                                        'placeholderData' => 'Basic',
                                        'isRequired' => true,
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Free Trial',
                                        'fieldType' => 'checkbox',
                                        'nameData' => 'is_free_trial',
                                        'placeholderData' => null,
                                        'isRequired' => false,
                                        'valueData' => 1,
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Monthly Fee',
                                        'fieldType' => 'number',
                                        'nameData' => 'monthly_fee',
                                        'placeholderData' => '19',
                                        'isRequired' => true,
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Yearly Fee',
                                        'fieldType' => 'number',
                                        'nameData' => 'yearly_fee',
                                        'placeholderData' => '200',
                                        'isRequired' => true,
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Number of User Account (0 = Infinity)',
                                        'fieldType' => 'number',
                                        'nameData' => 'number_of_user_account',
                                        'placeholderData' => '5',
                                        'isRequired' => true,
                                    ])

                                    @include('landlord.super-admin.partials.input-field',[
                                        'colSize' => 6,
                                        'labelName' => 'Number of Employees (0 = Infinity)',
                                        'fieldType' => 'number',
                                        'nameData' => 'number_of_employee',
                                        'placeholderData' => '10',
                                        'isRequired' => true,
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

                                    <div class="col-md-12 mt-2">
                                        <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
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
    let storeURL = "{{ route('package.store') }}";

    (function($) {
        "use strict";

        var checkedNodes;

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
                        items: [
                            {
                                id: 'view-calendar',
                                text: '{{__('View Calendar')}}',
                            },
                            {
                                id: 'promotion',
                                text: "{{trans('Promotion')}}",
                            },

                            {
                                id: 'award',
                                text: "{{trans('Award')}}",
                            },

                            {
                                id: 'transfer',
                                text: "{{trans('Transfer')}}",
                            },

                            {
                                id: 'travel',
                                text: "{{trans('Travel')}}",
                            },

                            {
                                id: 'resignation',
                                text: "{{trans('Resignation')}}",
                            },

                            {
                                id: 'complaint',
                                text: "{{trans('Complaint')}}",
                            },

                            {
                                id: 'warning',
                                text: "{{trans('Warning')}}",
                            },

                            {
                                id: 'termination',
                                text: "{{trans('Termination')}}",
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
                            },
                            {
                                id: 'office_shift',
                                text: "{{trans('Office Shift')}}",
                                checked: true,
                            },

                            {
                                id: 'holiday',
                                text: "{{trans('Holiday')}}",
                            },
                            {
                                id: 'leave',
                                text: "{{trans('Leave')}}",
                            },
                        ]
                    },
                    {
                        id: 'payment-module',
                        text: "{{trans('Payment Module')}}",
                    },
                    {
                        id: 'hr_report',
                        text: "{{trans('HR Reports')}}",
                    },

                    {
                        id: 'recruitment',
                        text: "{{__('Recruitment')}}",
                        expanded: true,
                        items: [
                            {
                                id: 'job_post',
                                text: "{{trans('Job Post')}}",
                            },
                            {
                                id: 'job_candidate',
                                text: "{{trans('Job Candidate')}}",
                            },
                            {
                                id: 'job_interview',
                                text: "{{trans('Job Interview')}}",
                            },
                            {
                                id: 'cms',
                                text: "{{__('CMS')}}",
                            }
                        ]
                    },
                    {
                        id: 'project-management',
                        text: "{{trans('Project Management')}}",
                        expanded: true,
                        items: [
                            {
                                id: 'project',
                                text: "{{trans('Project')}}",
                            },
                            {
                                id: 'task',
                                text: "{{trans('Task')}}",
                            },
                            {
                                id: 'client',
                                text: "{{trans('Client')}}",
                            },
                            {
                                id: 'invoice',
                                text: "{{trans('Invoice')}}",
                            },
                        ]
                    },
                    {
                        id: 'ticket',
                        text: "{{trans('Ticket')}}",
                    },
                    {
                        id: 'file_module',
                        text: "{{trans('File Module')}}",
                        expanded: true,
                        items: [
                            {
                                id: 'file_manager',
                                text: "{{trans('File Manager')}}",
                            },
                            {
                                id: 'official_document',
                                text: "{{trans('Official Document')}}",
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
                        expanded: true,
                        items: [
                            {
                                id: 'meeting',
                                text: "{{trans('Meeting')}}",
                            },
                            {
                                id: 'event',
                                text: "{{trans('Event')}}",
                            },
                        ]
                    },
                    {
                        id: 'assets-and-category',
                        text: "{{trans('Assets And Category')}}",
                    },
                    {
                        id: 'finance',
                        text: "{{trans('Finance')}}",
                        expanded: true,
                        items: [
                            {
                                id: 'account',
                                text: "{{trans('Account')}}",
                            },
                            {
                                id: 'expense',
                                text: "{{trans('Expense')}}",
                            },
                            {
                                id: 'deposit',
                                text: "{{trans('Deposit')}}",
                            },
                            {
                                id: 'payer',
                                text: "{{trans('Payer')}}",
                            },
                            {
                                id: 'payee',
                                text: "{{trans('payee')}}",
                            },
                        ]
                    },
                    {
                        id: 'training_module',
                        text: "{{trans('Training Module')}}",
                        expanded: true,
                        items: [
                            {
                                id: 'trainer',
                                text: "{{trans('Trainer')}}",
                            },
                            {
                                id: 'training',
                                text: "{{trans('Training')}}",
                            },
                        ]
                    },
                    {
                        id: 'announcement',
                        text: "{{trans('Announcement')}}",
                    },
                    {
                        id: 'policy',
                        text: "{{trans('Policy')}}",
                    },
                    {
                        id: 'performance',
                        text: "{{trans('Performance')}}",
                        expanded: true,
                        items: [
                            {
                                id: 'goal-type',
                                text: "{{trans('Goal Type')}}",
                            },
                            {
                                id: 'goal-tracking',
                                text: "{{trans('Goal Tracking')}}",
                            },
                            {
                                id: 'indicator',
                                text: "{{trans('Indicator')}}",
                            },
                            {
                                id: 'appraisal',
                                text: "{{trans('Appraisal')}}",
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

<script type="text/javascript" src="{{ asset('js/landlord/common-js/store.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>
@endpush
