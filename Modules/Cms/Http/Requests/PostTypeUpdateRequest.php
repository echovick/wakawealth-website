<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @author WakaWealth Development Team
 */
final class PostTypeUpdateRequest extends FormRequest
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
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $postTypeId = $this->route('post_type')->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('post_types', 'slug')->ignore($postTypeId)],
            'description' => ['nullable', 'string'],
            'active' => ['nullable', 'boolean'],
            'content' => ['nullable', 'array'],
        ];
    }
}
