<div class="tab-pane fade" id="analyticsSetting" role="tabpanel" aria-labelledby="analytics-setting">    <div class="card">
        <h4 class="card-header p-3"><b>@lang('file.Analytics Setting')</b></h4>
        <hr>
        <div class="card-body">
            <form id="analyticSettingSubmit" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    @include('landlord.super-admin.partials.input-field',[
                        'colSize' => 12,
                        'labelName' => 'Google Analytics Script',
                        'fieldType' => 'text',
                        'nameData' => 'google_analytics_script',
                        'placeholderData' => 'Paste your Google Analytics Snippet',
                        'isRequired' => true,
                        'valueData'=> isset($analyticSetting->google_analytics_script) ? $analyticSetting->google_analytics_script : null
                    ])
                    @include('landlord.super-admin.partials.input-field',[
                        'colSize' => 12,
                        'labelName' => 'Facebook Pixel Script',
                        'fieldType' => 'text',
                        'nameData' => 'facebook_pixel_script',
                        'placeholderData' => 'Meta Pixel Snippet',
                        'isRequired' => true,
                        'valueData'=> isset($analyticSetting->facebook_pixel_script) ? $analyticSetting->facebook_pixel_script : null
                    ])
                    @include('landlord.super-admin.partials.input-field',[
                        'colSize' => 12,
                        'labelName' => 'Chat Script',
                        'fieldType' => 'text',
                        'nameData' => 'chat_script',
                        'placeholderData' => 'Chat Snippet Start',
                        'isRequired' => true,
                        'valueData'=> isset($analyticSetting->chat_script) ? $analyticSetting->chat_script : null
                    ])
                </div>
                <div class="form-group row">
                    <button type="submit" id="analyticButton" class="btn btn-primary btn-block">@lang('file.Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
