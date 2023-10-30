<?php

namespace App\Http\Requests\Mail;

use Illuminate\Foundation\Http\FormRequest;

class MailSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'driver' => ['required', 'string', 'regex:/^\S*$/', 'lowercase'],
            'host' => ['required', 'string', 'regex:/^\S*$/', 'lowercase'],
            'port' => ['required', 'numeric', 'regex:/^\S*$/', 'lowercase'],
            'from_address' => ['required', 'email', 'regex:/^\S*$/', 'lowercase'],
            'from_name' => 'required',
            'username' => ['required', 'string', 'regex:/^\S*$/'],
            'password' => ['required', 'regex:/^\S*$/'],
            'encryption' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'driver.regex' => 'The :attribute must not contain any whitespace',
            'driver.host' => 'The :attribute must not contain any whitespace',
            'driver.from_address' => 'The :attribute must not contain any whitespace',
            'driver.username' => 'The :attribute must not contain any whitespace',
            'driver.password' => 'The :attribute must not contain any whitespace',
        ];
    }
}
