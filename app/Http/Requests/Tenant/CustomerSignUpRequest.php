<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class CustomerSignUpRequest extends FormRequest
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
            'package_id' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_name' => 'required|string|min:3',
            'contact_no' => 'required|numeric',
            'email' => 'required|email|max:50|unique:customers,email,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:5|confirmed',
            'username' => ['required', 'regex:/^\S*$/', 'string','min:3','max:50','unique:customers,username,NULL,id,deleted_at,NULL'],
            'tenant' => 'required|string|lowercase|regex:/^\S*$/|min:3|max:100|unique:tenants,id,NULL,id,deleted_at,NULL',
        ];
    }

    public function messages(): array
    {
        return [
            'package_id.required' => "Package has been required",
            'tenant.required' => 'The sub-domain field is required.',
            'tenant.unique' => 'The sub-domain has already been taken.',
            'tenant.regex' => 'The :attribute must not contain any whitespace',
            'username.regex' => 'The :attribute must not contain any whitespace',
        ];
    }
}
