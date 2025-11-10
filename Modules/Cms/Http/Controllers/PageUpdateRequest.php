<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class PageUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $pageId = $this->route('page')->id;

        return [
            'slug' => ['required', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($pageId)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'array'],
        ];
    }
}
