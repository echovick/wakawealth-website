<?php

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Page;
use Modules\Cms\Services\FieldGroupResolverService;

final class PageEditController
{
    public function __construct(
        private readonly FieldGroupResolverService $fieldGroupResolver,
    ) {
    }

    public function __invoke(Page $page): Response
    {
        $fieldGroups = $this->fieldGroupResolver->resolveFieldGroups('page', $page);

        return Inertia::render('Cms/Pages/Edit', [
            'page' => $page,
            'fieldGroups' => $fieldGroups,
        ]);
    }
}
