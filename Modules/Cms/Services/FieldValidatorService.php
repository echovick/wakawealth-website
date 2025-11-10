<?php

namespace Modules\Cms\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Cms\Models\Field;
use Modules\Cms\Models\FieldGroup;

final readonly class FieldValidatorService
{
    public function __construct(
        private FieldRegistryService $fieldRegistry,
    ) {
    }

    /**
     * Validate content data against field groups
     *
     * @param array<string, mixed> $data
     * @param \Illuminate\Support\Collection<int, FieldGroup> $fieldGroups
     * @return array<string, mixed>
     * @throws ValidationException
     */
    public function validate(array $data, $fieldGroups): array
    {
        $rules = [];
        $messages = [];
        $attributes = [];

        foreach ($fieldGroups as $fieldGroup) {
            foreach ($fieldGroup->fields as $field) {
                $fieldRules = $this->buildFieldRules($field);
                if (!empty($fieldRules)) {
                    $rules[$field->name] = $fieldRules;
                }

                // Custom attribute names for better error messages
                $attributes[$field->name] = $field->label;
            }
        }

        $validator = Validator::make($data, $rules, $messages, $attributes);

        return $validator->validate();
    }

    /**
     * Build validation rules for a field
     *
     * @param Field $field
     * @return array<int, string>
     */
    private function buildFieldRules(Field $field): array
    {
        $rules = [];

        // Required validation
        if ($field->required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }

        // Type-specific validation
        $typeRules = $this->getTypeValidationRules($field);
        $rules = array_merge($rules, $typeRules);

        // Custom field config validation
        $configRules = $this->getConfigValidationRules($field);
        $rules = array_merge($rules, $configRules);

        return $rules;
    }

    /**
     * Get validation rules based on field type
     *
     * @param Field $field
     * @return array<int, string>
     */
    private function getTypeValidationRules(Field $field): array
    {
        return match ($field->type) {
            'text', 'textarea', 'wysiwyg' => ['string'],
            'email' => ['string', 'email'],
            'url' => ['string', 'url'],
            'number' => ['numeric'],
            'date_picker' => ['date'],
            'time_picker' => ['string'],
            'true_false' => ['boolean'],
            'select', 'radio' => ['string'],
            'checkbox' => ['array'],
            'image', 'file' => ['string'],
            'repeater' => ['array'],
            'flexible_content' => ['array'],
            default => [],
        };
    }

    /**
     * Get validation rules from field config
     *
     * @param Field $field
     * @return array<int, string>
     */
    private function getConfigValidationRules(Field $field): array
    {
        $rules = [];
        $config = $field->field_config ?? [];

        // Maxlength for text fields
        if (isset($config['maxlength']) && $config['maxlength'] > 0) {
            $rules[] = 'max:' . $config['maxlength'];
        }

        // Min/Max for number fields
        if ($field->type === 'number') {
            if (isset($config['min']) && $config['min'] !== null) {
                $rules[] = 'min:' . $config['min'];
            }
            if (isset($config['max']) && $config['max'] !== null) {
                $rules[] = 'max:' . $config['max'];
            }
        }

        // Choices validation for select/radio/checkbox
        if (in_array($field->type, ['select', 'radio', 'checkbox']) && isset($config['choices'])) {
            $validChoices = array_keys($config['choices']);
            if (!empty($validChoices)) {
                if ($field->type === 'checkbox') {
                    $rules[] = 'array';
                } else {
                    $rules[] = 'in:' . implode(',', $validChoices);
                }
            }
        }

        return $rules;
    }
}
