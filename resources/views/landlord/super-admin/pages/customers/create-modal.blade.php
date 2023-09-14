<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> {{ __('file.Add Customer') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" id="submitForm" action="{{ route('customer.signup') }}" method="POST">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="created_by" value="admin">

                        <div class="col-md-6">
                            <label><strong>@lang('file.Package')</strong></label>
                            <select name="package_id" class="form-control">
                                @foreach ($packages as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.Subscription Type') }} *</label>
                            <div class="form-check">
                                <input type="radio" name="subscription_type" value="free" class="form-check-input"
                                    id="subscription-type-1" checked>
                                <label class="form-check-label" for="subscription-type-1">
                                    @lang('file.Free')
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="subscription_type" value="monthly" class="form-check-input"
                                    id="subscription-type-1">
                                <label class="form-check-label" for="subscription-type-1">
                                    @lang('file.Monthly')
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="subscription_type" value="yearly" class="form-check-input"
                                    id="subscription-type-2">
                                <label class="form-check-label" for="subscription-type-2">
                                    @lang('file.Yearly')
                                </label>
                            </div>
                        </div>

                        @include('landlord.super-admin.partials.input-field', [
                            'colSize' => 6,
                            'labelName' => 'First Name',
                            'fieldType' => 'text',
                            'nameData' => 'first_name',
                            'placeholderData' => 'First Name',
                            'isRequired' => false,
                        ])
                        @include('landlord.super-admin.partials.input-field', [
                            'colSize' => 6,
                            'labelName' => 'Last Name',
                            'fieldType' => 'text',
                            'nameData' => 'last_name',
                            'placeholderData' => 'Last Name',
                            'isRequired' => false,
                        ])
                        @include('landlord.super-admin.partials.input-field', [
                            'colSize' => 6,
                            'labelName' => 'Contact No',
                            'fieldType' => 'number',
                            'nameData' => 'contact_no',
                            'placeholderData' => '123456789',
                            'isRequired' => false,
                        ])
                        @include('landlord.super-admin.partials.input-field', [
                            'colSize' => 6,
                            'labelName' => 'Email',
                            'fieldType' => 'text',
                            'nameData' => 'email',
                            'placeholderData' => 'Email',
                            'isRequired' => false,
                        ])
                        @include('landlord.super-admin.partials.input-field', [
                            'colSize' => 6,
                            'labelName' => 'Username',
                            'fieldType' => 'text',
                            'nameData' => 'username',
                            'placeholderData' => 'Username',
                            'isRequired' => false,
                        ])
                        @include('landlord.super-admin.partials.input-field', [
                            'colSize' => 6,
                            'labelName' => 'Company Name',
                            'fieldType' => 'text',
                            'nameData' => 'company_name',
                            'placeholderData' => 'Company Name',
                            'isRequired' => false,
                        ])
                        @include('landlord.super-admin.partials.input-field', [
                            'colSize' => 6,
                            'labelName' => 'Password',
                            'fieldType' => 'text',
                            'nameData' => 'password',
                            'placeholderData' => 'Password',
                            'isRequired' => false,
                        ])
                        @include('landlord.super-admin.partials.input-field', [
                            'colSize' => 6,
                            'labelName' => 'Password Confirmation',
                            'fieldType' => 'text',
                            'nameData' => 'password_confirmation',
                            'placeholderData' => 'Password Confirmation',
                            'isRequired' => false,
                        ])

                        <div class="col-md-12">
                            <label><strong>@lang('file.Sub-domain')</strong></label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="tenant" placeholder="Subdomain..."
                                    aria-label="subdomain..." aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{ '@' . env('CENTRAL_DOMAIN') }}</span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary submitButton" id="submitButton">@lang('file.Save')</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
