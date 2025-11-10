<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Services\FieldRegistryService;

/**
 * @author WakaWealth Development Team
 */
final class FieldGroupCreateController
{
    public function __construct(
        private readonly FieldRegistryService $fieldRegistry,
    ) {}

    /**
     * Show the form for creating a new field group.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Cms/FieldGroups/Create', [
            'fieldTypes' => $this->fieldRegistry->getFieldTypes(),
        ]);
    }
}
