<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        choices: Record<string, string>;
        layout?: 'vertical' | 'horizontal';
    };
}

interface Props {
    field: Field;
    modelValue?: string[];
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
});
const emit = defineEmits(['update:modelValue']);

const toggleValue = (value: string) => {
    const current = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const index = current.indexOf(value);

    if (index > -1) {
        current.splice(index, 1);
    } else {
        current.push(value);
    }

    emit('update:modelValue', current);
};
</script>

<template>
    <div class="space-y-2">
        <Label>
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>
        <div
            :class="[
                'space-y-2',
                field.field_config?.layout === 'horizontal' ? 'flex flex-wrap gap-4' : ''
            ]"
        >
            <div
                v-for="(label, value) in field.field_config?.choices"
                :key="value"
                class="flex items-center space-x-2"
            >
                <Checkbox
                    :id="`${field.name}-${value}`"
                    :checked="modelValue?.includes(String(value))"
                    @update:checked="toggleValue(String(value))"
                />
                <Label
                    :for="`${field.name}-${value}`"
                    class="font-normal cursor-pointer"
                >
                    {{ label }}
                </Label>
            </div>
        </div>
    </div>
</template>
