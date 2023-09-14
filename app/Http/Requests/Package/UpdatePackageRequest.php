<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:200|unique:packages,name,'.$this->package_id.',id,deleted_at,NULL',
            'monthly_fee' => 'required|numeric',
            'yearly_fee' => 'required|numeric',
            'number_of_user_account' => 'required|numeric',
            'number_of_employee' => 'required|numeric',
            'features' => $this->features ? 'required' : 'sometimes',
        ];
    }
}
