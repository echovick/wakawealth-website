<script setup lang="ts">
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        choices: Record<string, string>;
        allow_null?: boolean;
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
        <Select
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
        >
            <SelectTrigger>
                <SelectValue placeholder="Select an option" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem
                    v-if="field.field_config?.allow_null"
                    value=""
                >
                    -- None --
                </SelectItem>
                <SelectItem
                    v-for="(label, value) in field.field_config?.choices"
                    :key="value"
                    :value="String(value)"
                >
                    {{ label }}
                </SelectItem>
            </SelectContent>
        </Select>
    </div>
</template>
