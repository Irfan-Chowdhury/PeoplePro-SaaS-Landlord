@extends('layout.main') @section('content')


    @include('includes.session_message')

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{__('Mail Setting')}}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                            <form method="POST"  id="mail_settings_form" action="{{route('setting.mailStore')}}" >
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{__('Mail Driver')}} *</strong></label>
                                        <input type="text" name="driver" class="form-control" value="{{ isset($mailSetting->driver) ? $mailSetting->driver : '' }}" required />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{__('Mail Host')}} *</strong></label>
                                        <input type="text" name="host" class="form-control" value="{{ isset($mailSetting->host) ? $mailSetting->host : '' }}" required />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{__('Mail Port')}} *</strong></label>
                                        <input type="text" name="port" class="form-control" value="{{ isset($mailSetting->port) ? $mailSetting->port : '' }} " required />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{__('Mail Address')}} *</strong></label>
                                        <input type="email" name="from_address" class="form-control" value="{{ isset($mailSetting->from_address) ? $mailSetting->from_address : '' }}" required />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{__('Name')}} *</strong></label>
                                        <input type="text" name="from_name" class="form-control" value="{{ isset($mailSetting->from_name) ? $mailSetting->from_name : '' }}" required />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{__('Username')}} *</strong></label>
                                        <input type="text" name="username" class="form-control" value="{{ isset($mailSetting->username) ? $mailSetting->username : '' }}" required />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{trans('file.Password')}} *</strong></label>
                                        <input type="text" name="password" class="form-control" value="{{ $decryptPassword }}" required />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{trans('file.Encryption')}} *</strong></label>
                                        <select name="encryption" class="form-control">
                                            <option value="tls" {{ (isset($mailSetting->encryption) && $mailSetting->encryption==='tls') ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ (isset($mailSetting->encryption) && $mailSetting->encryption==='ssl') ? 'selected' : '' }}>SSL</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
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
<script type="text/javascript">
    (function($) {
        "use strict";

        $("ul#setting").siblings('a').attr('aria-expanded','true');
        $("ul#setting").addClass("show");
        $("ul#setting #mail-setting-menu").addClass("active");

        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });
    })(jQuery);
</script>
@endpush
