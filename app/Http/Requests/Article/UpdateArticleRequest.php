<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'content' => 'string',
            'author' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'url' => 'nullable|url',
            'url_to_image' => 'nullable|url',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
