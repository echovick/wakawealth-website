<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Http\Requests\SettingUpdateRequest;
use Modules\Cms\Models\Setting;

/**
 * @author WakaWealth Development Team
 */
final class SettingUpdateController
{
    /**
     * Update settings in storage.
     */
    public function __invoke(SettingUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated['settings'] as $key => $value) {
            $setting = Setting::query()->where('key', $key)->first();

            if ($setting) {
                $setting->value = $value;
                $setting->save();
            } else {
                $newSetting = new Setting();
                $newSetting->group = $validated['group'] ?? 'general';
                $newSetting->key = $key;
                $newSetting->value = $value;
                $newSetting->label = ucfirst(str_replace('_', ' ', $key));
                $newSetting->type = 'text';
                $newSetting->save();
            }
        }

        return redirect()
            ->route('cms.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
