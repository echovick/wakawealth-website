<script setup lang="ts">
import { computed } from 'vue';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Checkbox } from '@/components/ui/checkbox';
import { Badge } from '@/components/ui/badge';
import { X } from 'lucide-vue-next';

interface Category {
    id: number;
    name: string;
    slug: string;
    parent_id: number | null;
}

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        multiple?: boolean;
        max_items?: number;
    };
}

interface Props {
    field: Field;
    modelValue?: number | number[] | null;
    categories?: Category[];
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const isMultiple = computed(() => props.field.field_config?.multiple ?? false);

const selectedCategoryIds = computed(() => {
    if (!props.modelValue) return [];
    if (Array.isArray(props.modelValue)) return props.modelValue;
    return [props.modelValue];
});

const selectedCategories = computed(() => {
    if (!props.categories) return [];
    return props.categories.filter(category => selectedCategoryIds.value.includes(category.id));
});

const toggleCategory = (categoryId: number) => {
    if (!isMultiple.value) {
        emit('update:modelValue', categoryId);
        return;
    }

    const currentIds = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const index = currentIds.indexOf(categoryId);

    if (index > -1) {
        currentIds.splice(index, 1);
    } else {
        const maxItems = props.field.field_config?.max_items ?? 0;
        if (maxItems > 0 && currentIds.length >= maxItems) {
            return;
        }
        currentIds.push(categoryId);
    }

    emit('update:modelValue', currentIds.length > 0 ? currentIds : null);
};

const removeCategory = (categoryId: number) => {
    if (!isMultiple.value) {
        emit('update:modelValue', null);
        return;
    }

    const currentIds = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const filtered = currentIds.filter(id => id !== categoryId);
    emit('update:modelValue', filtered.length > 0 ? filtered : null);
};

const handleSingleSelect = (value: string) => {
    if (!value) {
        emit('update:modelValue', null);
        return;
    }
    emit('update:modelValue', Number(value));
};
</script>

<template>
    <div class="space-y-2">
        <Label :for="field.name">
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>

        <!-- Single Select Mode -->
        <div v-if="!isMultiple">
            <Select
                :model-value="modelValue ? String(modelValue) : ''"
                @update:model-value="handleSingleSelect"
            >
                <SelectTrigger>
                    <SelectValue placeholder="Select a category" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="">-- None --</SelectItem>
                    <SelectItem
                        v-for="category in categories"
                        :key="category.id"
                        :value="String(category.id)"
                    >
                        {{ category.name }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>

        <!-- Multiple Select Mode -->
        <div v-else class="space-y-3">
            <!-- Selected Categories -->
            <div v-if="selectedCategories.length > 0" class="flex flex-wrap gap-2">
                <Badge
                    v-for="category in selectedCategories"
                    :key="category.id"
                    variant="secondary"
                    class="flex items-center gap-1 pr-1"
                >
                    <span>{{ category.name }}</span>
                    <button
                        type="button"
                        @click="removeCategory(category.id)"
                        class="ml-1 hover:bg-muted rounded p-0.5"
                    >
                        <X class="h-3 w-3" />
                    </button>
                </Badge>
            </div>

            <!-- Available Categories -->
            <div class="rounded-md border p-4 max-h-64 overflow-y-auto space-y-2">
                <div v-if="!categories || categories.length === 0" class="text-center text-muted-foreground py-4">
                    No categories available
                </div>
                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="flex items-start gap-3 p-2 rounded hover:bg-muted/50 transition-colors"
                >
                    <Checkbox
                        :id="`category-${category.id}`"
                        :checked="selectedCategoryIds.includes(category.id)"
                        @update:checked="() => toggleCategory(category.id)"
                    />
                    <label
                        :for="`category-${category.id}`"
                        class="flex-1 cursor-pointer"
                    >
                        <div class="font-medium">{{ category.name }}</div>
                        <div class="text-xs text-muted-foreground mt-1">
                            {{ category.slug }}
                        </div>
                    </label>
                </div>
            </div>

            <p v-if="field.field_config?.max_items && field.field_config.max_items > 0" class="text-xs text-muted-foreground">
                Maximum {{ field.field_config.max_items }} categories can be selected
            </p>
        </div>
    </div>
</template>
