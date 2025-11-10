<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        message?: string;
        default_value?: boolean;
    };
}

interface Props {
    field: Field;
    modelValue?: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <div class="flex items-center justify-between space-x-2">
        <div class="space-y-0.5">
            <Label :for="field.name">
                {{ field.label }}
                <span v-if="field.required" class="text-destructive">*</span>
            </Label>
            <p v-if="field.field_config?.message" class="text-sm text-muted-foreground">
                {{ field.field_config.message }}
            </p>
        </div>
        <Switch
            :id="field.name"
            :checked="modelValue || field.field_config?.default_value || false"
            @update:checked="emit('update:modelValue', $event)"
        />
    </div>
</template>
