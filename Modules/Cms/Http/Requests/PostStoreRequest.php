<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @author WakaWealth Development Team
 */
final class PostStoreRequest extends FormRequest
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
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'post_type_id' => ['required', 'integer', 'exists:post_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'image' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'array'],
            'status' => ['required', 'string', 'in:draft,published'],
            'is_featured' => ['nullable', 'boolean'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ];
    }
}
