<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\FieldGroup;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\Post;
use Modules\Cms\Models\PostType;
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
     * Convert ACF-style database rules back to UI format
     *
     * @param \Illuminate\Database\Eloquent\Collection $locations
     * @return array<int, array<string, mixed>>
     */
    private function convertLocationsToUiFormat($locations): array
    {
        $uiLocations = [];

        // Group by rule_group
        $grouped = $locations->groupBy('rule_group');

        foreach ($grouped as $ruleGroup => $rules) {
            $location = [
                'entity_type' => 'page',
                'entity_id' => null,
            ];

            foreach ($rules as $rule) {
                // Determine entity_type from post_type param
                if ($rule->param === 'post_type') {
                    if ($rule->value === 'page') {
                        $location['entity_type'] = 'page';
                    } elseif ($rule->value === 'post') {
                        $location['entity_type'] = 'post';
                    } elseif ($rule->value === 'category') {
                        $location['entity_type'] = 'category';
                    } else {
                        // It's a post type ID
                        $location['entity_type'] = 'post_type';
                        $location['entity_id'] = (int) $rule->value;
                    }
                }

                // Get specific entity ID
                if ($rule->param === 'page') {
                    $location['entity_id'] = (int) $rule->value;
                }
                if ($rule->param === 'post') {
                    $location['entity_id'] = (int) $rule->value;
                }
                if ($rule->param === 'category') {
                    $location['entity_id'] = (int) $rule->value;
                }
            }

            $uiLocations[] = $location;
        }

        return $uiLocations;
    }

    /**
     * Show the form for editing the specified field group.
     */
    public function __invoke(FieldGroup $fieldGroup): Response
    {
        $fieldGroup->load(['fields' => function ($query) {
            $query->orderBy('order');
        }, 'locations']);

        // Convert locations to UI format
        $fieldGroupArray = $fieldGroup->toArray();
        $fieldGroupArray['locations'] = $this->convertLocationsToUiFormat($fieldGroup->locations);

        return Inertia::render('Cms/FieldGroups/Edit', [
            'fieldGroup' => $fieldGroupArray,
            'fieldTypes' => $this->fieldRegistry->getFieldTypesForForm(),
            'pages' => Page::query()->orderBy('title')->get(['id', 'title']),
            'posts' => Post::query()->with('postType:id,title')->orderBy('title')->get(['id', 'title', 'post_type_id']),
            'postTypes' => PostType::query()->where('active', true)->orderBy('title')->get(['id', 'title']),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }
}
