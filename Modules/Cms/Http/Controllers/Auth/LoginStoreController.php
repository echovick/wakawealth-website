<?php

namespace Modules\Cms\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Cms\Http\Controllers\Auth\LoginStoreRequest;

final class LoginStoreController
{
    public function __invoke(LoginStoreRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $credentials['remember'] ?? false)) {
            $request->session()->regenerate();

            // Check if user has admin or editor role
            $user = Auth::user();
            if (!in_array($user->role, ['admin', 'editor'])) {
                Auth::logout();
                return redirect()
                    ->route('cms.login')
                    ->withErrors(['email' => 'You do not have permission to access the CMS.']);
            }

            return redirect()->intended('/cms');
        }

        return redirect()
            ->back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('email', 'remember'));
    }
}
