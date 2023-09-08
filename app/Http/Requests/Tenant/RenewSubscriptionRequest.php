<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class RenewSubscriptionRequest extends FormRequest
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
            'subscription_type' => 'required',
            'package_id' => 'required',
            'tenant_id' => 'required|string|lowercase|regex:/^\S*$/|min:3|max:100|exists:tenants,id',
        ];
    }

    public function messages(): array
    {
        return [
            'tenant_id.exists' => "The sub-domain does not exists",
        ];
    }
}
