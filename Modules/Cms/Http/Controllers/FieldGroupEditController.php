<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\FieldGroup;
use Modules\Cms\Services\FieldRegistryService;

/**
 * @author WakaWealth Development Team
 */
final class FieldGroupEditController
{
    public function __construct(
        private readonly FieldRegistryService $fieldRegistry,
    ) {}

    /**
     * Show the form for editing the specified field group.
     */
    public function __invoke(FieldGroup $fieldGroup): Response
    {
        $fieldGroup->load(['fields' => function ($query) {
            $query->orderBy('order');
        }, 'locations']);

        return Inertia::render('Cms/FieldGroups/Edit', [
            'fieldGroup' => $fieldGroup,
            'fieldTypes' => $this->fieldRegistry->getFieldTypes(),
        ]);
    }
}
