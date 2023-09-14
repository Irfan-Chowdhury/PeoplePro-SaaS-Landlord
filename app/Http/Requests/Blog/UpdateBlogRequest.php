<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:200|unique:blogs,title,'.$this->blog_id.',id,deleted_at,NULL',
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
            'description' => 'required|string',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'og_title' => 'string',
            'og_description' => 'string',
        ];
    }
}
