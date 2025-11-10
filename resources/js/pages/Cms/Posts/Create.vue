<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import PostForm from '@/components/cms/PostForm.vue';

interface PostType {
  id: number;
  title: string;
  slug: string;
}

interface Category {
  id: number;
  name: string;
  slug: string;
}

interface FieldType {
  type: string;
  label: string;
  icon: string;
}

interface FieldGroup {
  id: number;
  title: string;
  key: string;
  fields: any[];
}

interface Props {
  postTypes: PostType[];
  categories: Category[];
  fieldTypes: FieldType[];
  posts?: any[];
  fieldGroupsByPostType?: Record<number, FieldGroup[]>;
}

defineProps<Props>();
</script>

<template>
  <Head title="Create Post" />

  <CmsLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Create Post</h1>
        <p class="text-muted-foreground">
          Add a new post to your website
        </p>
      </div>

      <PostForm
        :post-types="postTypes"
        :categories="categories"
        :field-groups-by-post-type="fieldGroupsByPostType || {}"
        :posts="posts"
        :field-types="fieldTypes"
      />
    </div>
  </CmsLayout>
</template>
