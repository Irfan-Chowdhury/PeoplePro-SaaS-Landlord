<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'title' => 'required|string|unique:pages,title,NULL,id,deleted_at,NULL',
            'description' => 'required|string',
            'meta_title' => 'string',
            'meta_description' => 'string',
        ];
    }
}
