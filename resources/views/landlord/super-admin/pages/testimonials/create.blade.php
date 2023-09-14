<div class="container-fluid mb-3">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex align-items-center p-3">
                    <h4 >{{trans('file.Testimonial Section')}}</h4>
                </div>
                <hr>
                <div class="card-body">
                    <form id="submitForm" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            @include('landlord.super-admin.partials.input-field',[
                                'colSize' => 4,
                                'labelName' => 'Name',
                                'fieldType' => 'text',
                                'nameData' => 'name',
                                'placeholderData' => 'e.g: Irfan Chowdhury',
                                'isRequired' => true,
                            ])
                            @include('landlord.super-admin.partials.input-field',[
                                'colSize' => 4,
                                'labelName' => 'Business Name',
                                'fieldType' => 'text',
                                'nameData' => 'business_name',
                                'placeholderData' => 'e.g: LionCoders',
                                'isRequired' => true,
                            ])
                            @include('landlord.super-admin.partials.input-field',[
                                'colSize' => 4,
                                'labelName' => 'Image',
                                'fieldType' => 'file',
                                'nameData' => 'image',
                                'placeholderData' => null,
                                'isRequired' => true,
                            ])
                            @include('landlord.super-admin.partials.input-field',[
                                'colSize' => 12,
                                'labelName' => 'Description',
                                'fieldType' => 'textarea',
                                'nameData' => 'description',
                                'placeholderData' => 'e.g: Good Support Team.',
                                'isRequired' => true,
                            ])

                            <div class="col-4 form-group mt-3">
                                <button type="submit" id="submitButton" class="btn btn-primary">@lang('file.Submit')</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
