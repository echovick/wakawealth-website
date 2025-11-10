<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';

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
    modelValue?: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <div class="space-y-2">
        <Label>
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>
        <RadioGroup
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
            :class="[
                field.field_config?.layout === 'horizontal' ? 'flex flex-wrap gap-4' : 'space-y-2'
            ]"
        >
            <div
                v-for="(label, value) in field.field_config?.choices"
                :key="value"
                class="flex items-center space-x-2"
            >
                <RadioGroupItem
                    :id="`${field.name}-${value}`"
                    :value="String(value)"
                />
                <Label
                    :for="`${field.name}-${value}`"
                    class="font-normal cursor-pointer"
                >
                    {{ label }}
                </Label>
            </div>
        </RadioGroup>
    </div>
</template>
