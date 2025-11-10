<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import FieldGroupForm from '@/components/cms/FieldGroupForm.vue';

interface FieldType {
  type: string;
  label: string;
  icon: string;
}

interface Props {
  fieldTypes: FieldType[];
}

defineProps<Props>();
</script>

<template>
  <Head title="Create Field Group" />

  <CmsLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Create Field Group</h1>
        <p class="text-muted-foreground">
          Define a new set of custom fields for your content
        </p>
      </div>

      <FieldGroupForm :field-types="fieldTypes" />
    </div>
  </CmsLayout>
</template>
