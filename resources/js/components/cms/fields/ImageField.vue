<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { computed } from 'vue';

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

const placeholder = computed(() =>
    props.field.field_config?.placeholder || 'https://example.com/image.jpg'
);

const isValidImageUrl = computed(() => {
    if (!props.modelValue) return false;
    try {
        const url = new URL(props.modelValue);
        return /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(url.pathname);
    } catch {
        return false;
    }
});
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
            type="url"
            :placeholder="placeholder"
            :required="field.required"
            @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
        />
        <div v-if="isValidImageUrl && modelValue" class="mt-2 border rounded-lg p-2 bg-muted/20">
            <img
                :src="modelValue"
                :alt="field.label"
                class="max-w-full h-auto max-h-32 rounded object-contain"
                @error="() => {}"
            />
        </div>
    </div>
</template>
