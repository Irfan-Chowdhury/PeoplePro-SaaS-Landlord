<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> @lang('file.Edit Testimonial') </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" id="updateForm">
                    <input type="hidden" name="testimonial_id" id="modelId">

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
                            'isRequired' => false,
                        ])
                        @include('landlord.super-admin.partials.input-field',[
                            'colSize' => 12,
                            'labelName' => 'Description',
                            'fieldType' => 'text',
                            'nameData' => 'description',
                            'placeholderData' => 'e.g: Good Support Team.',
                            'isRequired' => true,
                        ])
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="updateButton">@lang('file.Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



