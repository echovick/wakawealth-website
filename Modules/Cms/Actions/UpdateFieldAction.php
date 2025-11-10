<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Field;

final readonly class UpdateFieldAction
{
    /**
     * Execute the action
     *
     * @param Field $field
     * @param array<string, mixed> $data
     * @return Field
     */
    public function execute(Field $field, array $data): Field
    {
        $field->key = $data['key'];
        $field->label = $data['label'];
        $field->name = $data['name'];
        $field->type = $data['type'];
        $field->instructions = $data['instructions'] ?? null;
        $field->required = $data['required'] ?? false;
        $field->conditional_logic = $data['conditional_logic'] ?? [];
        $field->field_config = $data['field_config'] ?? [];
        $field->order = $data['order'] ?? 0;
        $field->save();

        return $field;
    }
}
