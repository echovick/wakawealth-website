<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\FieldGroup;

/**
 * @author WakaWealth Development Team
 */
final class FieldGroupIndexController
{
    /**
     * Display a listing of field groups.
     */
    public function __invoke(): Response
    {
        $fieldGroups = FieldGroup::query()
            ->withCount('fields')
            ->orderBy('title')
            ->paginate(15);

        return Inertia::render('Cms/FieldGroups/Index', [
            'fieldGroups' => $fieldGroups,
        ]);
    }
}
