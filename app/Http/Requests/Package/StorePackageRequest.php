<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:packages,name,NULL,id,deleted_at,NULL',
            'monthly_fee' => 'required|numeric',
            'yearly_fee' => 'required|numeric',
            'number_of_user_account' => 'required|numeric',
            'number_of_employee' => 'required|numeric',
            'features' => $this->features ? 'required' : 'sometimes',
        ];
    }
}
