<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;

final class ContactStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['nullable', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'meta' => ['nullable', 'array'],
        ];
    }
}
