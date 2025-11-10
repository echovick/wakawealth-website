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

interface FieldType {
    type: string;
    label: string;
    icon: string;
    category: string;
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
    modelValue?: string | string[] | null;
    fieldTypes?: Record<string, FieldType>;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const isMultiple = computed(() => props.field.field_config?.multiple ?? false);

const fieldTypesArray = computed(() => {
    if (!props.fieldTypes) return [];
    return Object.entries(props.fieldTypes).map(([type, data]) => ({
        type,
        ...data,
    }));
});

const selectedFieldTypeKeys = computed(() => {
    if (!props.modelValue) return [];
    if (Array.isArray(props.modelValue)) return props.modelValue;
    return [props.modelValue];
});

const selectedFieldTypes = computed(() => {
    return fieldTypesArray.value.filter(fieldType => selectedFieldTypeKeys.value.includes(fieldType.type));
});

const toggleFieldType = (fieldTypeKey: string) => {
    if (!isMultiple.value) {
        emit('update:modelValue', fieldTypeKey);
        return;
    }

    const currentKeys = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const index = currentKeys.indexOf(fieldTypeKey);

    if (index > -1) {
        currentKeys.splice(index, 1);
    } else {
        const maxItems = props.field.field_config?.max_items ?? 0;
        if (maxItems > 0 && currentKeys.length >= maxItems) {
            return;
        }
        currentKeys.push(fieldTypeKey);
    }

    emit('update:modelValue', currentKeys.length > 0 ? currentKeys : null);
};

const removeFieldType = (fieldTypeKey: string) => {
    if (!isMultiple.value) {
        emit('update:modelValue', null);
        return;
    }

    const currentKeys = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const filtered = currentKeys.filter(key => key !== fieldTypeKey);
    emit('update:modelValue', filtered.length > 0 ? filtered : null);
};

const handleSingleSelect = (value: string) => {
    if (!value) {
        emit('update:modelValue', null);
        return;
    }
    emit('update:modelValue', value);
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
                    <SelectValue placeholder="Select a field type" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="">-- None --</SelectItem>
                    <SelectItem
                        v-for="fieldType in fieldTypesArray"
                        :key="fieldType.type"
                        :value="fieldType.type"
                    >
                        {{ fieldType.label }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>

        <!-- Multiple Select Mode -->
        <div v-else class="space-y-3">
            <!-- Selected Field Types -->
            <div v-if="selectedFieldTypes.length > 0" class="flex flex-wrap gap-2">
                <Badge
                    v-for="fieldType in selectedFieldTypes"
                    :key="fieldType.type"
                    variant="secondary"
                    class="flex items-center gap-1 pr-1"
                >
                    <span>{{ fieldType.label }}</span>
                    <button
                        type="button"
                        @click="removeFieldType(fieldType.type)"
                        class="ml-1 hover:bg-muted rounded p-0.5"
                    >
                        <X class="h-3 w-3" />
                    </button>
                </Badge>
            </div>

            <!-- Available Field Types -->
            <div class="rounded-md border p-4 max-h-64 overflow-y-auto space-y-2">
                <div v-if="fieldTypesArray.length === 0" class="text-center text-muted-foreground py-4">
                    No field types available
                </div>
                <div
                    v-for="fieldType in fieldTypesArray"
                    :key="fieldType.type"
                    class="flex items-start gap-3 p-2 rounded hover:bg-muted/50 transition-colors"
                >
                    <Checkbox
                        :id="`field-type-${fieldType.type}`"
                        :checked="selectedFieldTypeKeys.includes(fieldType.type)"
                        @update:checked="() => toggleFieldType(fieldType.type)"
                    />
                    <label
                        :for="`field-type-${fieldType.type}`"
                        class="flex-1 cursor-pointer"
                    >
                        <div class="font-medium">{{ fieldType.label }}</div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-muted-foreground">
                                {{ fieldType.type }}
                            </span>
                            <Badge variant="outline" class="text-xs">
                                {{ fieldType.category }}
                            </Badge>
                        </div>
                    </label>
                </div>
            </div>

            <p v-if="field.field_config?.max_items && field.field_config.max_items > 0" class="text-xs text-muted-foreground">
                Maximum {{ field.field_config.max_items }} field types can be selected
            </p>
        </div>
    </div>
</template>
