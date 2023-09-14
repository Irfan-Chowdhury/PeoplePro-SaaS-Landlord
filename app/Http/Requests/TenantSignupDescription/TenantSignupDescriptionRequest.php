<?php

namespace App\Http\Requests\TenantSignupDescription;

use Illuminate\Foundation\Http\FormRequest;

class TenantSignupDescriptionRequest extends FormRequest
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
            'heading' => 'required|string|min:3|max:50',
            'sub_heading' => 'required|string|min:3',
        ];
    }
}
