<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
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
import { Plus, Trash2, GripVertical, ChevronDown, ChevronUp, AlertCircle } from 'lucide-vue-next';
import SubFieldEditor from '@/components/cms/fields/SubFieldEditor.vue';

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

interface Page {
  id: number;
  title: string;
}

interface Post {
  id: number;
  title: string;
  post_type_id: number;
}

interface PostType {
  id: number;
  title: string;
}

interface Category {
  id: number;
  name: string;
}

interface Props {
  fieldGroup?: FieldGroup;
  fieldTypes: FieldType[];
  pages: Page[];
  posts: Post[];
  postTypes: PostType[];
  categories: Category[];
}

const props = defineProps<Props>();

// Normalize fields to ensure field_config is always an object
const normalizeFields = (fields: Field[]): Field[] => {
  return fields.map(field => {
    const fieldConfig = Array.isArray(field.field_config) ? {} : (field.field_config || {});

    // Initialize subfields for repeater/group types
    if ((field.type === 'repeater' || field.type === 'group') && !fieldConfig.subfields) {
      fieldConfig.subfields = [];
    }

    return {
      ...field,
      field_config: fieldConfig,
      conditional_logic: Array.isArray(field.conditional_logic) && field.conditional_logic.length === 0 ? {} : (field.conditional_logic || {}),
    };
  });
};

const form = useForm({
  title: props.fieldGroup?.title || '',
  key: props.fieldGroup?.key || '',
  position: props.fieldGroup?.position || 'normal',
  style: props.fieldGroup?.style || 'default',
  active: props.fieldGroup?.active ?? true,
  fields: props.fieldGroup?.fields ? normalizeFields(props.fieldGroup.fields) : [],
  locations: props.fieldGroup?.locations || [],
});

// Track collapsed state for each field and location
const collapsedFields = ref<Record<number, boolean>>({});
const collapsedLocations = ref<Record<number, boolean>>({});

const toggleFieldCollapse = (index: number): void => {
  collapsedFields.value[index] = !collapsedFields.value[index];
};

const toggleLocationCollapse = (index: number): void => {
  collapsedLocations.value[index] = !collapsedLocations.value[index];
};

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

const onFieldTypeChange = (field: Field): void => {
  // Ensure field_config is an object (not an array)
  if (Array.isArray(field.field_config)) {
    field.field_config = {};
  }

  // Initialize subfields array for repeater and group types
  if ((field.type === 'repeater' || field.type === 'group') && !field.field_config.subfields) {
    field.field_config.subfields = [];
  }
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
  console.log('[FieldGroupForm] Submitting form data:', form.data());
  console.log('[FieldGroupForm] Form errors before submit:', form.errors);

  if (props.fieldGroup) {
    form.put(`/cms/field-groups/${props.fieldGroup.id}`, {
      onSuccess: () => {
        console.log('[FieldGroupForm] Update successful');
      },
      onError: (errors) => {
        console.error('[FieldGroupForm] Update failed with errors:', errors);
      },
    });
  } else {
    form.post('/cms/field-groups', {
      onSuccess: () => {
        console.log('[FieldGroupForm] Create successful');
      },
      onError: (errors) => {
        console.error('[FieldGroupForm] Create failed with errors:', errors);
      },
    });
  }
};

const getAvailableEntities = (entityType: string) => {
  switch (entityType) {
    case 'page':
      return props.pages.map(page => ({ id: page.id, label: page.title }));
    case 'post':
      return props.posts.map(post => ({ id: post.id, label: post.title }));
    case 'post_type':
      return props.postTypes.map(type => ({ id: type.id, label: type.title }));
    case 'category':
      return props.categories.map(cat => ({ id: cat.id, label: cat.name }));
    default:
      return [];
  }
};
</script>

<template>
  <form @submit.prevent="submit" class="space-y-8">
    <!-- Error Alert -->
    <div v-if="Object.keys(form.errors).length > 0" class="rounded-lg border border-destructive bg-destructive/10 p-4">
      <div class="flex items-start gap-3">
        <AlertCircle class="h-5 w-5 text-destructive flex-shrink-0 mt-0.5" />
        <div class="flex-1">
          <h3 class="font-semibold text-destructive mb-2">Validation Errors</h3>
          <ul class="list-disc list-inside space-y-1 text-sm text-destructive/90">
            <li v-for="(error, key) in form.errors" :key="key">
              <strong>{{ key }}:</strong> {{ error }}
            </li>
          </ul>
        </div>
      </div>
    </div>

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
              <div class="flex items-center gap-2 flex-1">
                <GripVertical class="h-4 w-4 text-muted-foreground" />
                <span class="font-medium">Field {{ index + 1 }}</span>
                <span v-if="field.label" class="text-sm text-muted-foreground">- {{ field.label }}</span>
                <span v-if="field.type" class="text-xs px-2 py-0.5 rounded bg-muted">{{ field.type }}</span>
              </div>
              <div class="flex items-center gap-1">
                <Button
                  type="button"
                  variant="ghost"
                  size="icon"
                  @click="toggleFieldCollapse(index)"
                >
                  <ChevronDown v-if="collapsedFields[index]" class="h-4 w-4" />
                  <ChevronUp v-else class="h-4 w-4" />
                </Button>
                <Button
                  type="button"
                  variant="ghost"
                  size="icon"
                  @click="removeField(index)"
                >
                  <Trash2 class="h-4 w-4 text-destructive" />
                </Button>
              </div>
            </div>

            <div v-if="!collapsedFields[index]" class="grid gap-4 md:grid-cols-2">
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
                <Select v-model="field.type" @update:model-value="onFieldTypeChange(field)">
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

              <!-- Subfield editor for repeater and group types -->
              <div v-if="field.type === 'repeater' || field.type === 'group'" class="md:col-span-2 mt-4 pt-4 border-t">
                <SubFieldEditor
                  v-model="field.field_config.subfields"
                  :field-types="fieldTypes"
                  :allow-complex-types="true"
                />
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
              <div class="flex items-center gap-2 flex-1">
                <span class="font-medium">Location {{ index + 1 }}</span>
                <span v-if="location.entity_type" class="text-xs px-2 py-0.5 rounded bg-muted">{{ location.entity_type }}</span>
              </div>
              <div class="flex items-center gap-1">
                <Button
                  type="button"
                  variant="ghost"
                  size="icon"
                  @click="toggleLocationCollapse(index)"
                >
                  <ChevronDown v-if="collapsedLocations[index]" class="h-4 w-4" />
                  <ChevronUp v-else class="h-4 w-4" />
                </Button>
                <Button
                  type="button"
                  variant="ghost"
                  size="icon"
                  @click="removeLocation(index)"
                >
                  <Trash2 class="h-4 w-4 text-destructive" />
                </Button>
              </div>
            </div>

            <div v-if="!collapsedLocations[index]" class="grid gap-4 md:grid-cols-2">
              <div class="space-y-2">
                <Label :for="`location-type-${index}`">Entity Type</Label>
                <Select v-model="location.entity_type" @update:model-value="location.entity_id = null">
                  <SelectTrigger>
                    <SelectValue />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="page">Page</SelectItem>
                    <SelectItem value="post">Post</SelectItem>
                    <SelectItem value="post_type">Post Type</SelectItem>
                    <SelectItem value="category">Category</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div class="space-y-2">
                <Label :for="`location-entity-${index}`">Specific {{ location.entity_type === 'post_type' ? 'Post Type' : location.entity_type.charAt(0).toUpperCase() + location.entity_type.slice(1) }} (Optional)</Label>
                <Select :model-value="location.entity_id !== null ? String(location.entity_id) : 'all'" @update:model-value="(val) => location.entity_id = val === 'all' ? null : Number(val)">
                  <SelectTrigger>
                    <SelectValue :placeholder="`All ${location.entity_type}s`" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="all">All {{ location.entity_type }}s</SelectItem>
                    <SelectItem
                      v-for="entity in getAvailableEntities(location.entity_type)"
                      :key="entity.id"
                      :value="String(entity.id)"
                    >
                      {{ entity.label }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>
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
          <template v-if="form.processing">
            {{ fieldGroup ? 'Updating...' : 'Creating...' }}
          </template>
          <template v-else>
            {{ fieldGroup ? 'Update' : 'Create' }} Field Group
          </template>
        </Button>
      </div>
    </div>
  </form>
</template>
