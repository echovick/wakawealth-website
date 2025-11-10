<?php

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Services\FieldGroupResolverService;

final class PageCreateController
{
    public function __construct(
        private readonly FieldGroupResolverService $fieldGroupResolver,
    ) {
    }

    public function __invoke(): Response
    {
        $fieldGroups = $this->fieldGroupResolver->resolveFieldGroups('page');

        return Inertia::render('Cms/Pages/Create', [
            'fieldGroups' => $fieldGroups,
        ]);
    }
}
