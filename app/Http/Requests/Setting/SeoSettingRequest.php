<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SeoSettingRequest extends FormRequest
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
            'meta_title' => 'required|string|min:3|max:60',
            'meta_description' => 'required|string|min:3|max:160',
            'og_title' => 'required|string|min:3|max:60',
            'og_description' => 'required|string|min:3|max:160',
            'og_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:100000',
        ];
    }
}
