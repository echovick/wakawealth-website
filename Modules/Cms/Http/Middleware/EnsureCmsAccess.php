<?php

namespace Modules\Cms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class EnsureCmsAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('cms.login');
        }

        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'editor'])) {
            Auth::logout();
            return redirect()
                ->route('cms.login')
                ->withErrors(['email' => 'You do not have permission to access the CMS.']);
        }

        return $next($request);
    }
}
