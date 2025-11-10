<?php

declare(strict_types=1);

namespace Modules\Cms\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\FieldGroup;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\Post;

/**
 * Service for evaluating field group location rules
 *
 * @author WakaWealth Development Team
 */
final readonly class FieldGroupLocationService
{
    /**
     * Determine if a field group should be displayed for the given entity
     *
     * @param FieldGroup $fieldGroup
     * @param Model $entity
     * @return bool
     */
    public function shouldShowFieldGroup(FieldGroup $fieldGroup, Model $entity): bool
    {
        $locations = $fieldGroup->locations;

        if ($locations->isEmpty()) {
            return false; // No locations means field group won't appear anywhere
        }

        // Group locations by rule_group (OR logic between groups, AND logic within groups)
        $ruleGroups = $locations->groupBy('rule_group');

        foreach ($ruleGroups as $group) {
            if ($this->evaluateRuleGroup($group, $entity)) {
                return true; // If any rule group matches, show the field group
            }
        }

        return false;
    }

    /**
     * Evaluate a single rule group (all rules must match)
     *
     * @param Collection $rules
     * @param Model $entity
     * @return bool
     */
    private function evaluateRuleGroup(Collection $rules, Model $entity): bool
    {
        foreach ($rules as $rule) {
            if (!$this->evaluateRule($rule, $entity)) {
                return false; // All rules in group must match
            }
        }

        return true;
    }

    /**
     * Evaluate a single location rule
     *
     * @param \Modules\Cms\Models\FieldGroupLocation $rule
     * @param Model $entity
     * @return bool
     */
    private function evaluateRule($rule, Model $entity): bool
    {
        $param = $rule->param;
        $operator = $rule->operator;
        $value = $rule->value;

        // Handle entity type checks
        if ($param === 'post_type') {
            if ($entity instanceof Post) {
                return $this->compareValues($entity->post_type_id, $value, $operator);
            }
            if ($entity instanceof Page) {
                return $this->compareValues('page', $value, $operator);
            }
            if ($entity instanceof Category) {
                return $this->compareValues('category', $value, $operator);
            }
            return false;
        }

        // Handle specific entity ID checks
        if ($param === 'post' && $entity instanceof Post) {
            return $this->compareValues($entity->id, $value, $operator);
        }

        if ($param === 'page' && $entity instanceof Page) {
            return $this->compareValues($entity->id, $value, $operator);
        }

        if ($param === 'category' && $entity instanceof Category) {
            return $this->compareValues($entity->id, $value, $operator);
        }

        return false;
    }

    /**
     * Compare two values based on operator
     *
     * @param mixed $actual
     * @param mixed $expected
     * @param string $operator
     * @return bool
     */
    private function compareValues($actual, $expected, string $operator): bool
    {
        return match ($operator) {
            '==' => $actual == $expected,
            '!=' => $actual != $expected,
            '>' => $actual > $expected,
            '<' => $actual < $expected,
            '>=' => $actual >= $expected,
            '<=' => $actual <= $expected,
            'contains' => str_contains((string) $actual, (string) $expected),
            'not_contains' => !str_contains((string) $actual, (string) $expected),
            default => false,
        };
    }

    /**
     * Get all field groups that should be displayed for the given entity
     *
     * @param Model $entity
     * @return Collection<int, FieldGroup>
     */
    public function getFieldGroupsForEntity(Model $entity): Collection
    {
        return FieldGroup::query()
            ->where('active', true)
            ->with(['fields' => function ($query) {
                $query->orderBy('order');
            }, 'locations'])
            ->get()
            ->filter(fn (FieldGroup $fieldGroup) => $this->shouldShowFieldGroup($fieldGroup, $entity));
    }
}
