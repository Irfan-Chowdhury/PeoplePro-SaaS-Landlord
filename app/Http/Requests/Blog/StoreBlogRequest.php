<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'title' => 'required|string|unique:blogs,title,NULL,id,deleted_at,NULL',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:100000',
            'description' => 'required|string',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'og_title' => 'string',
            'og_description' => 'string',
        ];
    }
}
