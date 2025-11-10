<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Setting;

/**
 * @author WakaWealth Development Team
 */
final class SettingIndexController
{
    /**
     * Display a listing of settings.
     */
    public function __invoke(): Response
    {
        $settings = Setting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        return Inertia::render('Cms/Settings/Index', [
            'settings' => $settings,
        ]);
    }
}
