<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class AnalyticSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'google_analytics_script' => 'required|string|min:3|max:50',
            'facebook_pixel_script' => 'required|string|min:3|max:50',
            'chat_script' => 'required|string|min:3|max:50',
        ];
    }
}
