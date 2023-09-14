<?php

namespace App\Http\Requests\Setting;

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
            'driver' => 'required|string',
            'host' => 'required|string',
            'port' => 'required|numeric',
            'from_address' => 'required|string',
            'from_name' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'encryption' => 'required|string',
        ];
    }
}
