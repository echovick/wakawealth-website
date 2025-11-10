<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Http\Requests\FieldGroupUpdateRequest;
use Modules\Cms\Models\Field;
use Modules\Cms\Models\FieldGroup;
use Modules\Cms\Models\FieldGroupLocation;

/**
 * @author WakaWealth Development Team
 */
final class FieldGroupUpdateController
{
    /**
     * Update the specified field group in storage.
     */
    public function __invoke(FieldGroupUpdateRequest $request, FieldGroup $fieldGroup): RedirectResponse
    {
        $validated = $request->validated();

        $fieldGroup->title = $validated['title'];
        $fieldGroup->key = $validated['key'];
        $fieldGroup->position = $validated['position'] ?? 'normal';
        $fieldGroup->style = $validated['style'] ?? 'default';
        $fieldGroup->active = $validated['active'] ?? true;
        $fieldGroup->save();

        $fieldGroup->fields()->delete();

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
                $field->conditional_logic = $fieldData['conditional_logic'] ?? [];
                $field->field_config = $fieldData['field_config'] ?? [];
                $field->order = $index;
                $field->save();
            }
        }

        $fieldGroup->locations()->delete();

        if (isset($validated['locations'])) {
            foreach ($validated['locations'] as $locationData) {
                $location = new FieldGroupLocation();
                $location->field_group_id = $fieldGroup->id;
                $location->entity_type = $locationData['entity_type'];
                $location->entity_id = $locationData['entity_id'] ?? null;
                $location->rules = $locationData['rules'] ?? [];
                $location->save();
            }
        }

        return redirect()
            ->route('cms.field-groups.index')
            ->with('success', 'Field group updated successfully.');
    }
}
