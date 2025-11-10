<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Cms\Http\Requests\FieldGroupStoreRequest;
use Modules\Cms\Models\Field;
use Modules\Cms\Models\FieldGroup;
use Modules\Cms\Models\FieldGroupLocation;

/**
 * @author WakaWealth Development Team
 */
final class FieldGroupStoreController
{
    /**
     * Convert UI location data to ACF-style rules
     *
     * @param array<string, mixed> $locationData
     * @return array<int, array<string, string>>
     */
    private function convertToRules(array $locationData): array
    {
        $entityType = $locationData['entity_type'];
        $entityId = $locationData['entity_id'] ?? null;

        $rules = [];

        // Add post_type rule
        if ($entityType === 'post_type') {
            $rules[] = [
                'param' => 'post_type',
                'operator' => '==',
                'value' => (string) $entityId,
            ];
        } elseif ($entityType === 'page') {
            $rules[] = [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ];

            // If specific page selected
            if ($entityId !== null) {
                $rules[] = [
                    'param' => 'page',
                    'operator' => '==',
                    'value' => (string) $entityId,
                ];
            }
        } elseif ($entityType === 'post') {
            $rules[] = [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ];

            // If specific post selected
            if ($entityId !== null) {
                $rules[] = [
                    'param' => 'post',
                    'operator' => '==',
                    'value' => (string) $entityId,
                ];
            }
        } elseif ($entityType === 'category') {
            $rules[] = [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'category',
            ];

            // If specific category selected
            if ($entityId !== null) {
                $rules[] = [
                    'param' => 'category',
                    'operator' => '==',
                    'value' => (string) $entityId,
                ];
            }
        }

        return $rules;
    }

    /**
     * Store a newly created field group in storage.
     */
    public function __invoke(FieldGroupStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $fieldGroup = DB::transaction(function () use ($validated) {
                $fieldGroup = new FieldGroup();
                $fieldGroup->title = $validated['title'];
                $fieldGroup->key = $validated['key'];
                $fieldGroup->position = $validated['position'] ?? 'normal';
                $fieldGroup->style = $validated['style'] ?? 'default';
                $fieldGroup->active = $validated['active'] ?? true;
                $fieldGroup->save();

                Log::info('Field group created', ['field_group_id' => $fieldGroup->id]);

                if (isset($validated['fields'])) {
                    foreach ($validated['fields'] as $index => $fieldData) {
                        $field = new Field();
                        $field->field_group_id = $fieldGroup->id;
                        $field->key = $fieldData['key'];
                        $field->label = $fieldData['label'];
                        $field->name = $fieldData['name'];
                        $field->type = $fieldData['type'];
                        $field->instructions = $fieldData['instructions'] ?? '';
                        $field->required = $fieldData['required'] ?? false;

                        // Ensure empty arrays are saved as objects in JSON
                        $conditionalLogic = $fieldData['conditional_logic'] ?? [];
                        $field->conditional_logic = empty($conditionalLogic) ? (object) [] : $conditionalLogic;

                        $fieldConfig = $fieldData['field_config'] ?? [];
                        $field->field_config = empty($fieldConfig) ? (object) [] : $fieldConfig;

                        $field->order = $index;
                        $field->save();

                        Log::info('Field created', ['field_id' => $field->id, 'key' => $field->key]);
                    }
                }

                if (isset($validated['locations'])) {
                    foreach ($validated['locations'] as $index => $locationData) {
                        $rules = $this->convertToRules($locationData);

                        foreach ($rules as $rule) {
                            $location = new FieldGroupLocation();
                            $location->field_group_id = $fieldGroup->id;
                            $location->rule_group = $index;
                            $location->param = $rule['param'];
                            $location->operator = $rule['operator'];
                            $location->value = $rule['value'];
                            $location->save();

                            Log::info('Location created', ['location_id' => $location->id]);
                        }
                    }
                }

                return $fieldGroup;
            });

            return redirect()
                ->route('cms.field-groups.index')
                ->with('success', 'Field group created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create field group', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create field group: '.$e->getMessage()]);
        }
    }
}
