<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $field_group_id
 * @property string $key
 * @property string $label
 * @property string $name
 * @property string $type
 * @property string|null $instructions
 * @property bool $required
 * @property array|null $conditional_logic
 * @property array|null $field_config
 * @property int $order
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Modules\Cms\Models\FieldGroup $fieldGroup
 */
final class Field extends Model
{
    /** @var array<string, scalar|bool|null> Default values for Eloquent attributes */
    protected $attributes = [
        'required' => false,
        'order' => 0,
        'conditional_logic' => '{}',
        'field_config' => '{}',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'required' => 'boolean',
            'conditional_logic' => 'array',
            'field_config' => 'array',
        ];
    }

    public function fieldGroup(): BelongsTo
    {
        return $this->belongsTo(FieldGroup::class);
    }
}
