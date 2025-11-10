<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;

final class PageStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'array'],
        ];
    }
}
