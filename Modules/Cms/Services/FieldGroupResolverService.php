<?php

namespace Modules\Cms\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Cms\Models\FieldGroup;

final readonly class FieldGroupResolverService
{
    /**
     * Resolve field groups for a given entity
     *
     * @param string $entityType
     * @param Model|null $entity
     * @return Collection<int, FieldGroup>
     */
    public function resolveFieldGroups(string $entityType, ?Model $entity = null): Collection
    {
        return FieldGroup::query()
            ->where('active', true)
            ->with(['fields', 'locations'])
            ->get()
            ->filter(function (FieldGroup $fieldGroup) use ($entityType, $entity): bool {
                return $this->matchesLocationRules($fieldGroup, $entityType, $entity);
            });
    }

    /**
     * Check if field group matches location rules
     *
     * @param FieldGroup $fieldGroup
     * @param string $entityType
     * @param Model|null $entity
     * @return bool
     */
    private function matchesLocationRules(FieldGroup $fieldGroup, string $entityType, ?Model $entity): bool
    {
        if ($fieldGroup->locations->isEmpty()) {
            return false;
        }

        // Group locations by rule_group (OR logic between groups, AND logic within groups)
        $ruleGroups = $fieldGroup->locations->groupBy('rule_group');

        foreach ($ruleGroups as $rules) {
            $groupMatches = true;

            foreach ($rules as $rule) {
                if (!$this->matchesRule($rule, $entityType, $entity)) {
                    $groupMatches = false;
                    break;
                }
            }

            // If any rule group matches completely, return true
            if ($groupMatches) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a single location rule matches
     *
     * @param \Modules\Cms\Models\FieldGroupLocation $rule
     * @param string $entityType
     * @param Model|null $entity
     * @return bool
     */
    private function matchesRule($rule, string $entityType, ?Model $entity): bool
    {
        $param = $rule->param;
        $operator = $rule->operator;
        $value = $rule->value;

        // Match by entity type
        if ($param === 'entity_type') {
            return $this->compareValues($entityType, $operator, $value);
        }

        // Match by specific entity attribute
        if ($entity !== null) {
            if ($param === 'entity_id') {
                return $this->compareValues($entity->id, $operator, $value);
            }

            // Match by model attribute (e.g., slug, post_type_id)
            if (str_starts_with($param, 'entity.')) {
                $attribute = substr($param, 7);
                if (isset($entity->$attribute)) {
                    return $this->compareValues($entity->$attribute, $operator, $value);
                }
            }
        }

        return false;
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
            'contains' => str_contains((string) $actualValue, (string) $expectedValue),
            'not_contains' => !str_contains((string) $actualValue, (string) $expectedValue),
            'starts_with' => str_starts_with((string) $actualValue, (string) $expectedValue),
            'ends_with' => str_ends_with((string) $actualValue, (string) $expectedValue),
            default => false,
        };
    }
}
