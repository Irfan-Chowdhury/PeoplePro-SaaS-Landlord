<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:100000',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => ['required', 'regex:/^\S*$/', 'string','min:3','max:50','unique:users,username,'.$this->user_id],
            'email' => 'required|email|max:50|unique:users,email,'.$this->user_id,
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'The :attribute must not contain any whitespace',
        ];
    }
}
