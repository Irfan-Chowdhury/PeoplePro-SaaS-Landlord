@extends('landlord.super-admin.layouts.master')
@section('landlord-content')



    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header d-flex align-items-center p-3">
                        <h4 >{{trans('file.Tenant Signup Description')}}</h4>
                    </div>
                    <hr>
                    <div class="card-body">
                        <form id="submitForm" action="{{ route('tenantSignupDescription.updateOrCreate') }}" method="POST">
                            @csrf

                            <div class="row">
                                @include('landlord.super-admin.partials.input-field',[
                                    'colSize' => 12,
                                    'labelName' => 'Heading',
                                    'fieldType' => 'text',
                                    'nameData' => 'heading',
                                    'placeholderData' => 'e.g: Customer Sign Up',
                                    'isRequired' => false,
                                    'valueData'=> isset($tenantSignupDescription->heading) ? $tenantSignupDescription->heading : null
                                ])
                                @include('landlord.super-admin.partials.input-field',[
                                    'colSize' => 12,
                                    'labelName' => 'Sub-Heading',
                                    'fieldType' => 'textarea',
                                    'nameData' => 'sub_heading',
                                    'placeholderData' => 'e.g:PeoplePro is packed with all the features you\'ll need to seamlessly run your business',
                                    'isRequired' => false,
                                    'valueData'=> isset($tenantSignupDescription->sub_heading) ? $tenantSignupDescription->sub_heading : null
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
@endsection


@push('scripts')
    <script type="text/javascript">
        (function($) {
            "use strict";

            $(document).ready(function() {
                let updateOrCreateURL = "{{ route('tenantSignupDescription.updateOrCreate') }}";

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $("#submitForm").on("submit", function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    updateOrCreate('submitButton', updateOrCreateURL, formData);
                });

            });

            let updateOrCreate = (submitButtonName, updateOrCreateURL, formData) => {
                $(`#${submitButtonName}`).text('Submitting...');
                $.post({
                    url: updateOrCreateURL,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    error: function(response) {
                        console.log(response);
                        let htmlContent = prepareMessage(response);
                        displayErrorMessage(htmlContent);
                        $(`#${submitButtonName}`).text('Submit');
                    },
                    success: function(response) {
                        console.log(response);
                        displaySuccessMessage(response.success);
                        $(`#${submitButtonName}`).text('Submit');
                    }
                });
            }
        })(jQuery);
    </script>

    <script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>
@endpush
