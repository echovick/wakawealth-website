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
     * Check if a single location rule matches (ACF-style rules)
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

        // Handle post_type param (determines entity type)
        if ($param === 'post_type') {
            // Check if it matches the entity type string
            if ($value === 'page' && $entityType === 'page') {
                return true;
            }
            if ($value === 'post' && $entityType === 'post') {
                return true;
            }
            if ($value === 'category' && $entityType === 'category') {
                return true;
            }

            // Check if it's a post type ID for posts
            if ($entityType === 'post' && $entity !== null) {
                if (isset($entity->post_type_id)) {
                    return $this->compareValues($entity->post_type_id, $operator, $value);
                }
            }

            return false;
        }

        // Handle specific entity ID checks
        if ($entity !== null) {
            // Check for specific page
            if ($param === 'page' && $entityType === 'page') {
                return $this->compareValues($entity->id, $operator, $value);
            }

            // Check for specific post
            if ($param === 'post' && $entityType === 'post') {
                return $this->compareValues($entity->id, $operator, $value);
            }

            // Check for specific category
            if ($param === 'category' && $entityType === 'category') {
                return $this->compareValues($entity->id, $operator, $value);
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
