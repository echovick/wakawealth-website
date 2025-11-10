<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        placeholder?: string;
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
        <Label :for="field.name">
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>
        <Input
            :id="field.name"
            :value="modelValue"
            type="email"
            :placeholder="field.field_config?.placeholder"
            :required="field.required"
            @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
        />
    </div>
</template>
