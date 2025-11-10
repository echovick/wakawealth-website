<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        min?: number;
        max?: number;
        step?: number;
    };
}

interface Props {
    field: Field;
    modelValue?: number;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <div class="space-y-2">
        <Label :for="field.name">
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>
        <Input
            :id="field.name"
            :value="modelValue"
            type="number"
            :min="field.field_config?.min"
            :max="field.field_config?.max"
            :step="field.field_config?.step || 1"
            :required="field.required"
            @input="emit('update:modelValue', parseFloat(($event.target as HTMLInputElement).value))"
        />
    </div>
</template>
