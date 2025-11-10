<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        placeholder?: string;
        maxlength?: number;
        rows?: number;
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
        <Textarea
            :id="field.name"
            :value="modelValue"
            :placeholder="field.field_config?.placeholder"
            :maxlength="field.field_config?.maxlength"
            :rows="field.field_config?.rows || 4"
            :required="field.required"
            @input="emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)"
        />
    </div>
</template>
