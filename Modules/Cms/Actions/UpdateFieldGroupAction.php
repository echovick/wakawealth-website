<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\FieldGroup;

final readonly class UpdateFieldGroupAction
{
    /**
     * Execute the action
     *
     * @param FieldGroup $fieldGroup
     * @param array<string, mixed> $data
     * @return FieldGroup
     */
    public function execute(FieldGroup $fieldGroup, array $data): FieldGroup
    {
        $fieldGroup->title = $data['title'];
        $fieldGroup->key = $data['key'];
        $fieldGroup->position = $data['position'] ?? 'normal';
        $fieldGroup->style = $data['style'] ?? 'default';
        $fieldGroup->active = $data['active'] ?? true;
        $fieldGroup->save();

        return $fieldGroup;
    }
}
