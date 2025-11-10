<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        placeholder?: string;
        maxlength?: number;
        prepend?: string;
        append?: string;
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
        <div class="flex gap-2">
            <span v-if="field.field_config?.prepend" class="inline-flex items-center px-3 border border-r-0 rounded-l-md bg-muted text-sm">
                {{ field.field_config.prepend }}
            </span>
            <Input
                :id="field.name"
                :value="modelValue"
                type="text"
                :placeholder="field.field_config?.placeholder"
                :maxlength="field.field_config?.maxlength"
                :required="field.required"
                @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
            />
            <span v-if="field.field_config?.append" class="inline-flex items-center px-3 border border-l-0 rounded-r-md bg-muted text-sm">
                {{ field.field_config.append }}
            </span>
        </div>
    </div>
</template>
