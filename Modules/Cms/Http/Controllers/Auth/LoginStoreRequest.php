<?php

namespace Modules\Cms\Http\Controllers\Auth;

use Illuminate\Foundation\Http\FormRequest;

final class LoginStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }
}
