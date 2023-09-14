<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:200|unique:pages,title,'.$this->page_id.',id,deleted_at,NULL',
            'description' => 'required|string',
            'meta_title' => 'string',
            'meta_description' => 'string',
        ];
    }
}
