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

interface Field {
  id: number;
  key: string;
  label: string;
  name: string;
  type: string;
  instructions: string;
  required: boolean;
  field_config: Record<string, any>;
}

interface FieldGroup {
  id: number;
  title: string;
  key: string;
  fields: Field[];
}

interface Post {
  id: number;
  post_type_id: number;
  title: string;
  slug: string;
  content: Record<string, any>;
  published_at: string | null;
  categories: Category[];
}

interface Props {
  post: Post;
  postTypes: PostType[];
  categories: Category[];
  fieldGroups: FieldGroup[];
  posts?: any[];
}

defineProps<Props>();
</script>

<template>
  <Head :title="`Edit ${post.title}`" />

  <CmsLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Edit Post</h1>
        <p class="text-muted-foreground">
          Update your post content and settings
        </p>
      </div>

      <PostForm
        :post="post"
        :post-types="postTypes"
        :categories="categories"
        :field-groups="fieldGroups"
        :posts="posts"
        :field-types="fieldTypes"
      />
    </div>
  </CmsLayout>
</template>
