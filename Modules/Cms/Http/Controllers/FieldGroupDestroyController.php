<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Models\FieldGroup;

/**
 * @author WakaWealth Development Team
 */
final class FieldGroupDestroyController
{
    /**
     * Remove the specified field group from storage.
     */
    public function __invoke(FieldGroup $fieldGroup): RedirectResponse
    {
        $fieldGroup->delete();

        return redirect()
            ->route('cms.field-groups.index')
            ->with('success', 'Field group deleted successfully.');
    }
}
