<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeId = $this->route('article');

        return [
            'title' => 'required|string|min:3|max:255|unique:articles,title,' . $routeId . ',uuid',
            "slug" => "nullable",
            "content" => "required",
            "published" => "required|in:0,1",
            "category_id" => "required|exists:categories,id",
            "tag_id" => "required|array",
            "tag_id.*" => "required|exists:tags,id",
            "keywords" => "required|min:3",
            "image" => $this->isMethod('POST') ? "required|file|image|max:2048|mimes:png,jpg,jpeg,webp|mimetypes:image/png,image/jpg,image/jpeg,image/webp" : "nullable|file|image|max:2048|mimes:png,jpg,jpeg,webp|mimetypes:image/png,image/jpg,image/jpeg,image/webp",
        ];
    }
}
