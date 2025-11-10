<script setup lang="ts">
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
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
import { Plus, Trash2, GripVertical } from 'lucide-vue-next';

interface Field {
  id?: number;
  key: string;
  label: string;
  name: string;
  type: string;
  instructions: string;
  required: boolean;
  conditional_logic: Record<string, any>;
  field_config: Record<string, any>;
  order: number;
}

interface Location {
  id?: number;
  entity_type: string;
  entity_id: number | null;
  rules: Record<string, any>;
}

interface FieldGroup {
  id: number;
  title: string;
  key: string;
  position: string;
  style: string;
  active: boolean;
  fields: Field[];
  locations: Location[];
}

interface FieldType {
  type: string;
  label: string;
  icon: string;
}

interface Props {
  fieldGroup?: FieldGroup;
  fieldTypes: FieldType[];
}

const props = defineProps<Props>();

const form = useForm({
  title: props.fieldGroup?.title || '',
  key: props.fieldGroup?.key || '',
  position: props.fieldGroup?.position || 'normal',
  style: props.fieldGroup?.style || 'default',
  active: props.fieldGroup?.active ?? true,
  fields: props.fieldGroup?.fields || [],
  locations: props.fieldGroup?.locations || [],
});

watch(() => form.title, (newTitle) => {
  if (!props.fieldGroup) {
    form.key = newTitle
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '_')
      .replace(/^_|_$/g, '');
  }
});

const addField = (): void => {
  form.fields.push({
    key: '',
    label: '',
    name: '',
    type: 'text',
    instructions: '',
    required: false,
    conditional_logic: {},
    field_config: {},
    order: form.fields.length,
  });
};

const removeField = (index: number): void => {
  form.fields.splice(index, 1);
  form.fields.forEach((field, idx) => {
    field.order = idx;
  });
};

const generateFieldKey = (field: Field): void => {
  field.name = field.label
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '_')
    .replace(/^_|_$/g, '');
  field.key = `field_${Date.now()}_${field.name}`;
};

const addLocation = (): void => {
  form.locations.push({
    entity_type: 'page',
    entity_id: null,
    rules: {},
  });
};

const removeLocation = (index: number): void => {
  form.locations.splice(index, 1);
};

const submit = (): void => {
  if (props.fieldGroup) {
    form.put(route('cms.field-groups.update', props.fieldGroup.id));
  } else {
    form.post(route('cms.field-groups.store'));
  }
};
</script>

<template>
  <form @submit.prevent="submit" class="space-y-8">
    <div class="grid gap-6 md:grid-cols-3">
      <div class="md:col-span-2 space-y-6">
        <div class="rounded-lg border p-6 space-y-4">
          <h3 class="font-semibold">Field Group Settings</h3>

          <div class="space-y-2">
            <Label for="title">Title</Label>
            <Input
              id="title"
              v-model="form.title"
              placeholder="Field group title"
              required
            />
            <p v-if="form.errors.title" class="text-sm text-destructive">
              {{ form.errors.title }}
            </p>
          </div>

          <div class="space-y-2">
            <Label for="key">Key</Label>
            <Input
              id="key"
              v-model="form.key"
              placeholder="field_group_key"
              required
            />
            <p v-if="form.errors.key" class="text-sm text-destructive">
              {{ form.errors.key }}
            </p>
          </div>
        </div>

        <div class="rounded-lg border p-6 space-y-4">
          <div class="flex items-center justify-between">
            <h3 class="font-semibold">Fields</h3>
            <Button type="button" variant="outline" size="sm" @click="addField">
              <Plus class="mr-2 h-4 w-4" />
              Add Field
            </Button>
          </div>

          <div v-if="form.fields.length === 0" class="text-center text-muted-foreground py-8">
            No fields added yet. Click "Add Field" to get started.
          </div>

          <div v-for="(field, index) in form.fields" :key="index" class="border rounded-lg p-4 space-y-4">
            <div class="flex items-start justify-between">
              <div class="flex items-center gap-2">
                <GripVertical class="h-4 w-4 text-muted-foreground" />
                <span class="font-medium">Field {{ index + 1 }}</span>
              </div>
              <Button
                type="button"
                variant="ghost"
                size="icon"
                @click="removeField(index)"
              >
                <Trash2 class="h-4 w-4 text-destructive" />
              </Button>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
              <div class="space-y-2">
                <Label :for="`field-label-${index}`">Label</Label>
                <Input
                  :id="`field-label-${index}`"
                  v-model="field.label"
                  @blur="generateFieldKey(field)"
                  placeholder="Field label"
                />
              </div>

              <div class="space-y-2">
                <Label :for="`field-type-${index}`">Type</Label>
                <Select v-model="field.type">
                  <SelectTrigger>
                    <SelectValue />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem
                      v-for="fieldType in fieldTypes"
                      :key="fieldType.type"
                      :value="fieldType.type"
                    >
                      {{ fieldType.label }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div class="space-y-2 md:col-span-2">
                <Label :for="`field-name-${index}`">Name</Label>
                <Input
                  :id="`field-name-${index}`"
                  v-model="field.name"
                  placeholder="field_name"
                  readonly
                />
              </div>

              <div class="space-y-2 md:col-span-2">
                <Label :for="`field-instructions-${index}`">Instructions</Label>
                <Textarea
                  :id="`field-instructions-${index}`"
                  v-model="field.instructions"
                  placeholder="Instructions for this field"
                />
              </div>

              <div class="flex items-center space-x-2">
                <Switch
                  :id="`field-required-${index}`"
                  v-model:checked="field.required"
                />
                <Label :for="`field-required-${index}`">Required</Label>
              </div>
            </div>
          </div>
        </div>

        <div class="rounded-lg border p-6 space-y-4">
          <div class="flex items-center justify-between">
            <h3 class="font-semibold">Location Rules</h3>
            <Button type="button" variant="outline" size="sm" @click="addLocation">
              <Plus class="mr-2 h-4 w-4" />
              Add Location
            </Button>
          </div>

          <div v-if="form.locations.length === 0" class="text-center text-muted-foreground py-8">
            No location rules added. This field group won't appear anywhere.
          </div>

          <div v-for="(location, index) in form.locations" :key="index" class="border rounded-lg p-4 space-y-4">
            <div class="flex items-start justify-between">
              <span class="font-medium">Location {{ index + 1 }}</span>
              <Button
                type="button"
                variant="ghost"
                size="icon"
                @click="removeLocation(index)"
              >
                <Trash2 class="h-4 w-4 text-destructive" />
              </Button>
            </div>

            <div class="space-y-2">
              <Label :for="`location-type-${index}`">Entity Type</Label>
              <Select v-model="location.entity_type">
                <SelectTrigger>
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="page">Page</SelectItem>
                  <SelectItem value="post">Post</SelectItem>
                  <SelectItem value="category">Category</SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="rounded-lg border p-6 space-y-4">
          <h3 class="font-semibold">Settings</h3>

          <div class="space-y-2">
            <Label for="position">Position</Label>
            <Select v-model="form.position">
              <SelectTrigger>
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="normal">Normal</SelectItem>
                <SelectItem value="side">Side</SelectItem>
              </SelectContent>
            </Select>
          </div>

          <div class="space-y-2">
            <Label for="style">Style</Label>
            <Select v-model="form.style">
              <SelectTrigger>
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="default">Default</SelectItem>
                <SelectItem value="seamless">Seamless</SelectItem>
              </SelectContent>
            </Select>
          </div>

          <div class="flex items-center space-x-2">
            <Switch id="active" v-model:checked="form.active" />
            <Label for="active">Active</Label>
          </div>
        </div>

        <Button
          type="submit"
          class="w-full"
          :disabled="form.processing"
        >
          {{ fieldGroup ? 'Update' : 'Create' }} Field Group
        </Button>
      </div>
    </div>
  </form>
</template>
