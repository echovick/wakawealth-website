<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import FieldGroupForm from '@/components/cms/FieldGroupForm.vue';

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
  fieldTypes: FieldType[];
  pages: Page[];
  posts: Post[];
  postTypes: PostType[];
  categories: Category[];
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

      <FieldGroupForm
        :field-types="fieldTypes"
        :pages="pages"
        :posts="posts"
        :post-types="postTypes"
        :categories="categories"
      />
    </div>
  </CmsLayout>
</template>
