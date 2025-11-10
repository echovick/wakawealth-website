<?php

namespace Modules\Cms\Services;

use Modules\Cms\Models\Field;

final readonly class ConditionalLogicService
{
    /**
     * Evaluate if a field should be visible based on conditional logic
     *
     * @param Field $field
     * @param array<string, mixed> $formData
     * @return bool
     */
    public function shouldShowField(Field $field, array $formData): bool
    {
        $conditionalLogic = $field->conditional_logic;

        // No conditional logic means always show
        if (empty($conditionalLogic) || !is_array($conditionalLogic)) {
            return true;
        }

        // If no rules defined, show the field
        if (!isset($conditionalLogic['rules']) || empty($conditionalLogic['rules'])) {
            return true;
        }

        $rules = $conditionalLogic['rules'];
        $operator = $conditionalLogic['operator'] ?? 'and';

        // Evaluate each rule
        $results = [];
        foreach ($rules as $rule) {
            $results[] = $this->evaluateRule($rule, $formData);
        }

        // Apply operator logic (AND/OR)
        if ($operator === 'or') {
            return in_array(true, $results, true);
        }

        // Default: AND operator
        return !in_array(false, $results, true);
    }

    /**
     * Evaluate a single conditional logic rule
     *
     * @param array<string, mixed> $rule
     * @param array<string, mixed> $formData
     * @return bool
     */
    private function evaluateRule(array $rule, array $formData): bool
    {
        $fieldName = $rule['field'] ?? null;
        $operator = $rule['operator'] ?? '==';
        $value = $rule['value'] ?? null;

        if ($fieldName === null) {
            return false;
        }

        $fieldValue = $formData[$fieldName] ?? null;

        return $this->compareValues($fieldValue, $operator, $value);
    }

    /**
     * Compare values based on operator
     *
     * @param mixed $actualValue
     * @param string $operator
     * @param mixed $expectedValue
     * @return bool
     */
    private function compareValues(mixed $actualValue, string $operator, mixed $expectedValue): bool
    {
        return match ($operator) {
            '==' => $actualValue == $expectedValue,
            '!=' => $actualValue != $expectedValue,
            '>' => $actualValue > $expectedValue,
            '<' => $actualValue < $expectedValue,
            '>=' => $actualValue >= $expectedValue,
            '<=' => $actualValue <= $expectedValue,
            'contains' => is_string($actualValue) && str_contains($actualValue, (string) $expectedValue),
            'not_contains' => is_string($actualValue) && !str_contains($actualValue, (string) $expectedValue),
            'empty' => empty($actualValue),
            'not_empty' => !empty($actualValue),
            default => false,
        };
    }
}
