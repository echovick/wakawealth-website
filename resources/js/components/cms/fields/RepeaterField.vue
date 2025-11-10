<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Plus, Trash2, GripVertical, ChevronDown, ChevronUp, AlertCircle } from 'lucide-vue-next';
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
        min?: number;
        max?: number;
        button_label?: string;
        collapsed?: boolean;
    };
}

interface Props {
    field: Field;
    modelValue?: any[];
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

// Backwards compatibility: support both 'subfields' and 'sub_fields'
const subfields = computed(() => {
    const result = props.field.field_config.subfields || (props.field.field_config as any).sub_fields || [];

    // Debug logging
    if (!result || result.length === 0) {
        console.warn(`[RepeaterField] No subfields found for field "${props.field.name}"`, {
            field_config: props.field.field_config,
            has_subfields: !!props.field.field_config.subfields,
            has_sub_fields: !!(props.field.field_config as any).sub_fields,
        });
    }

    return result;
});

// Initialize with empty array or existing value
const items = ref<any[]>(props.modelValue || []);

// Track collapsed state for each item
const collapsedItems = ref<Record<number, boolean>>({});

const toggleItemCollapse = (index: number): void => {
    collapsedItems.value[index] = !collapsedItems.value[index];
};

// Watch for external changes
watch(() => props.modelValue, (newValue) => {
    items.value = newValue || [];
}, { deep: true });

// Create empty item based on subfields
const createEmptyItem = (): Record<string, any> => {
    const item: Record<string, any> = {};
    subfields.value?.forEach(subfield => {
        item[subfield.name] = '';
    });
    return item;
};

const addItem = () => {
    const max = props.field.field_config.max;
    if (max && items.value.length >= max) return;

    items.value.push(createEmptyItem());
    emit('update:modelValue', items.value);
};

const removeItem = (index: number) => {
    const min = props.field.field_config.min || 0;
    if (items.value.length <= min) return;

    items.value.splice(index, 1);
    emit('update:modelValue', items.value);
};

const updateItemField = (itemIndex: number, fieldName: string, value: any) => {
    items.value[itemIndex][fieldName] = value;
    emit('update:modelValue', items.value);
};

// Ensure minimum items
const min = props.field.field_config.min || 0;
if (items.value.length < min) {
    for (let i = items.value.length; i < min; i++) {
        items.value.push(createEmptyItem());
    }
    emit('update:modelValue', items.value);
}
</script>

<template>
    <div class="space-y-4">
        <Label>
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>

        <div class="space-y-3">
            <div
                v-for="(item, index) in items"
                :key="index"
                class="border rounded-lg p-4 space-y-4 bg-card"
            >
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <GripVertical class="h-4 w-4 text-muted-foreground cursor-move" />
                        <span class="text-sm font-medium">Item {{ index + 1 }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <Button
                            type="button"
                            variant="ghost"
                            size="icon"
                            @click="toggleItemCollapse(index)"
                        >
                            <ChevronDown v-if="collapsedItems[index]" class="h-4 w-4" />
                            <ChevronUp v-else class="h-4 w-4" />
                        </Button>
                        <Button
                            type="button"
                            variant="ghost"
                            size="sm"
                            @click="removeItem(index)"
                            :disabled="(field.field_config.min || 0) >= items.length"
                        >
                            <Trash2 class="h-4 w-4" />
                        </Button>
                    </div>
                </div>

                <div v-if="!collapsedItems[index]">
                    <!-- Warning when no subfields configured -->
                    <div v-if="!subfields || subfields.length === 0" class="flex items-center gap-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md text-yellow-800 dark:text-yellow-200 text-sm">
                        <AlertCircle class="h-4 w-4 flex-shrink-0" />
                        <div>
                            <p class="font-medium">No subfields configured</p>
                            <p class="text-xs mt-1 opacity-80">Edit the field group and add subfields to this repeater field.</p>
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
                            :model-value="item[subfield.name]"
                            @update:model-value="updateItemField(index, subfield.name, $event)"
                        />
                    </div>
                </div>
            </div>

            <div v-if="items.length === 0" class="text-center py-8 border-2 border-dashed rounded-lg text-muted-foreground">
                No items added yet
            </div>
        </div>

        <Button
            type="button"
            variant="outline"
            @click="addItem"
            :disabled="field.field_config.max && items.length >= field.field_config.max"
        >
            <Plus class="h-4 w-4 mr-2" />
            {{ field.field_config.button_label || 'Add Item' }}
        </Button>
    </div>
</template>
