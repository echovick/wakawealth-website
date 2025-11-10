<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import FieldGroupForm from '@/components/cms/FieldGroupForm.vue';

interface Field {
  id: number;
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
  id: number;
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
  fieldGroup: FieldGroup;
  fieldTypes: FieldType[];
}

defineProps<Props>();
</script>

<template>
  <Head :title="`Edit ${fieldGroup.title}`" />

  <CmsLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Edit Field Group</h1>
        <p class="text-muted-foreground">
          Update field group settings and fields
        </p>
      </div>

      <FieldGroupForm
        :field-group="fieldGroup"
        :field-types="fieldTypes"
      />
    </div>
  </CmsLayout>
</template>
