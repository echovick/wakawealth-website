<?php

namespace Modules\Cms\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;

final class LoginShowController
{
    public function __invoke(): Response
    {
        return Inertia::render('Cms/Auth/Login');
    }
}
