<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Label } from '@/components/ui/label';
import { AlertCircle } from 'lucide-vue-next';
import FieldRenderer from './FieldRenderer.vue';

interface SubField {
    name: string;
    label: string;
    type: string;
    required: boolean;
    instructions: string | null;
    field_config: Record<string, any>;
}

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        subfields?: SubField[];
        layout?: 'block' | 'row';
    };
}

interface Props {
    field: Field;
    modelValue?: Record<string, any>;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

// Backwards compatibility: support both 'subfields' and 'sub_fields'
const subfields = computed(() => {
    const result = props.field.field_config.subfields || (props.field.field_config as any).sub_fields || [];

    // Debug logging
    if (!result || result.length === 0) {
        console.warn(`[GroupField] No subfields found for field "${props.field.name}"`, {
            field_config: props.field.field_config,
            has_subfields: !!props.field.field_config.subfields,
            has_sub_fields: !!(props.field.field_config as any).sub_fields,
        });
    }

    return result;
});

// Initialize with empty object or existing value
const groupData = ref<Record<string, any>>(props.modelValue || {});

// Watch for external changes
watch(() => props.modelValue, (newValue) => {
    groupData.value = newValue || {};
}, { deep: true });

// Initialize empty values for subfields based on their type
if (!props.modelValue) {
    subfields.value?.forEach(subfield => {
        if (!(subfield.name in groupData.value)) {
            // Initialize with appropriate default value based on field type
            if (subfield.type === 'repeater' || subfield.type === 'checkbox') {
                groupData.value[subfield.name] = [];
            } else if (subfield.type === 'group') {
                groupData.value[subfield.name] = {};
            } else if (subfield.type === 'number') {
                groupData.value[subfield.name] = null;
            } else if (subfield.type === 'true_false') {
                groupData.value[subfield.name] = false;
            } else {
                groupData.value[subfield.name] = '';
            }
        }
    });
    emit('update:modelValue', groupData.value);
}

const updateField = (fieldName: string, value: any) => {
    groupData.value[fieldName] = value;
    emit('update:modelValue', groupData.value);
};
</script>

<template>
    <div class="space-y-4">
        <Label>
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>

        <div class="border rounded-lg p-4 space-y-4 bg-card">
            <!-- Warning when no subfields configured -->
            <div v-if="!subfields || subfields.length === 0" class="flex items-center gap-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md text-yellow-800 dark:text-yellow-200 text-sm">
                <AlertCircle class="h-4 w-4 flex-shrink-0" />
                <div>
                    <p class="font-medium">No subfields configured</p>
                    <p class="text-xs mt-1 opacity-80">Edit the field group and add subfields to this group field.</p>
                </div>
            </div>

            <!-- Render subfields -->
            <div
                v-for="subfield in subfields"
                :key="subfield.name"
                class="space-y-2"
            >
                <FieldRenderer
                    :field="subfield"
                    :model-value="groupData[subfield.name]"
                    @update:model-value="updateField(subfield.name, $event)"
                />
            </div>
        </div>
    </div>
</template>
