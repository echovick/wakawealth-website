<script setup lang="ts">
import { ref, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { Switch } from '@/components/ui/switch';
import { Plus, Trash2, ChevronDown, ChevronUp } from 'lucide-vue-next';

interface SubField {
  name: string;
  label: string;
  type: string;
  required: boolean;
  instructions: string;
  field_config: Record<string, any>;
}

interface FieldType {
  type: string;
  label: string;
}

interface Props {
  modelValue?: SubField[];
  fieldTypes: FieldType[];
  allowComplexTypes?: boolean; // Whether to allow repeater/group in subfields
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: () => [],
  allowComplexTypes: false,
});

const emit = defineEmits<{
  (e: 'update:modelValue', value: SubField[]): void;
}>();

const subfields = ref<SubField[]>(props.modelValue || []);
const collapsedSubfields = ref<Record<number, boolean>>({});

watch(() => props.modelValue, (newValue) => {
  subfields.value = newValue || [];
}, { deep: true });

const toggleSubFieldCollapse = (index: number): void => {
  collapsedSubfields.value[index] = !collapsedSubfields.value[index];
};

const addSubField = () => {
  subfields.value.push({
    name: '',
    label: '',
    type: 'text',
    required: false,
    instructions: '',
    field_config: {},
  });
  emit('update:modelValue', subfields.value);
};

const removeSubField = (index: number) => {
  subfields.value.splice(index, 1);
  emit('update:modelValue', subfields.value);
};

const generateFieldName = (subfield: SubField) => {
  subfield.name = subfield.label
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '_')
    .replace(/^_|_$/g, '');
  emit('update:modelValue', subfields.value);
};

const updateSubField = () => {
  emit('update:modelValue', subfields.value);
};

// Filter out complex types if not allowed
const availableFieldTypes = props.allowComplexTypes
  ? props.fieldTypes
  : props.fieldTypes.filter(ft => !['repeater', 'group', 'flexible_content'].includes(ft.type));
</script>

<template>
  <div class="space-y-4">
    <div class="flex items-center justify-between">
      <Label class="text-sm font-medium">Sub Fields</Label>
      <Button type="button" variant="outline" size="sm" @click="addSubField">
        <Plus class="h-3 w-3 mr-1" />
        Add Sub Field
      </Button>
    </div>

    <div v-if="subfields.length === 0" class="text-center text-muted-foreground text-sm py-4 border-2 border-dashed rounded">
      No sub fields. Click "Add Sub Field" to get started.
    </div>

    <div v-for="(subfield, index) in subfields" :key="index" class="border rounded-lg p-3 space-y-3 bg-muted/30">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 flex-1">
          <span class="text-sm font-medium">Sub Field {{ index + 1 }}</span>
          <span v-if="subfield.label" class="text-xs text-muted-foreground">- {{ subfield.label }}</span>
          <span v-if="subfield.type" class="text-[10px] px-1.5 py-0.5 rounded bg-muted">{{ subfield.type }}</span>
        </div>
        <div class="flex items-center gap-1">
          <Button
            type="button"
            variant="ghost"
            size="sm"
            @click="toggleSubFieldCollapse(index)"
          >
            <ChevronDown v-if="collapsedSubfields[index]" class="h-3 w-3" />
            <ChevronUp v-else class="h-3 w-3" />
          </Button>
          <Button
            type="button"
            variant="ghost"
            size="sm"
            @click="removeSubField(index)"
          >
            <Trash2 class="h-3 w-3 text-destructive" />
          </Button>
        </div>
      </div>

      <div v-if="!collapsedSubfields[index]" class="grid gap-3 md:grid-cols-2">
        <div class="space-y-1.5">
          <Label :for="`subfield-label-${index}`" class="text-xs">Label</Label>
          <Input
            :id="`subfield-label-${index}`"
            v-model="subfield.label"
            @blur="generateFieldName(subfield)"
            @input="updateSubField"
            placeholder="Field label"
            class="h-8 text-sm"
          />
        </div>

        <div class="space-y-1.5">
          <Label :for="`subfield-type-${index}`" class="text-xs">Type</Label>
          <Select v-model="subfield.type" @update:model-value="updateSubField">
            <SelectTrigger class="h-8 text-sm">
              <SelectValue />
            </SelectTrigger>
            <SelectContent>
              <SelectItem
                v-for="fieldType in availableFieldTypes"
                :key="fieldType.type"
                :value="fieldType.type"
              >
                {{ fieldType.label }}
              </SelectItem>
            </SelectContent>
          </Select>
        </div>

        <div class="space-y-1.5 md:col-span-2">
          <Label :for="`subfield-name-${index}`" class="text-xs">Name</Label>
          <Input
            :id="`subfield-name-${index}`"
            v-model="subfield.name"
            placeholder="field_name"
            readonly
            class="h-8 text-sm bg-muted"
          />
        </div>

        <div class="space-y-1.5 md:col-span-2">
          <Label :for="`subfield-instructions-${index}`" class="text-xs">Instructions</Label>
          <Textarea
            :id="`subfield-instructions-${index}`"
            v-model="subfield.instructions"
            @input="updateSubField"
            placeholder="Instructions for this field"
            rows="2"
            class="text-sm"
          />
        </div>

        <div class="flex items-center space-x-2">
          <Switch
            :id="`subfield-required-${index}`"
            :checked="subfield.required"
            @update:checked="(val) => { subfield.required = val; updateSubField(); }"
          />
          <Label :for="`subfield-required-${index}`" class="text-xs">Required</Label>
        </div>

        <!-- Nested subfield editor for repeater/group types -->
        <div v-if="(subfield.type === 'repeater' || subfield.type === 'group') && allowComplexTypes" class="md:col-span-2 mt-2 pl-4 border-l-2">
          <SubFieldEditor
            v-model="subfield.field_config.subfields"
            :field-types="fieldTypes"
            :allow-complex-types="false"
            @update:model-value="updateSubField"
          />
        </div>
      </div>
    </div>
  </div>
</template>
