<script setup lang="ts">
import { computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import FieldRenderer from '@/components/cms/fields/FieldRenderer.vue';

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
  image: string | null;
  content: Record<string, any>;
  published_at: string | null;
  is_featured: boolean;
  categories: Array<{ id: number }>;
}

interface Props {
  post?: Post;
  postTypes: PostType[];
  categories: Category[];
  fieldGroups?: FieldGroup[];
  fieldGroupsByPostType?: Record<number, FieldGroup[]>;
  posts?: any[];
  fieldTypes?: any;
}

const props = withDefaults(defineProps<Props>(), {
  posts: () => [],
  fieldTypes: () => ({}),
  fieldGroups: () => [],
  fieldGroupsByPostType: () => ({}),
});

const form = useForm({
  post_type_id: props.post?.post_type_id || (props.postTypes[0]?.id ?? null),
  title: props.post?.title || '',
  slug: props.post?.slug || '',
  image: props.post?.image || '',
  content: (props.post?.content && !Array.isArray(props.post.content)) ? props.post.content : {},
  status: props.post?.published_at ? 'published' : 'draft',
  is_featured: props.post?.is_featured || false,
  categories: props.post?.categories?.map(c => c.id) || [],
});

// Computed property to get field groups based on selected post type
const activeFieldGroups = computed(() => {
  // If editing, use the fieldGroups prop (from Edit page)
  if (props.post && props.fieldGroups && props.fieldGroups.length > 0) {
    return props.fieldGroups;
  }

  // If creating, use fieldGroupsByPostType based on selected post type
  if (form.post_type_id && props.fieldGroupsByPostType) {
    return props.fieldGroupsByPostType[form.post_type_id] || [];
  }

  return [];
});

watch(() => form.title, (newTitle) => {
  if (!props.post) {
    form.slug = newTitle
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-|-$/g, '');
  }
});

const submit = (): void => {
  if (props.post) {
    form.put(`/cms/posts/${props.post.id}`);
  } else {
    form.post('/cms/posts');
  }
};

const toggleCategory = (categoryId: number, checked: boolean): void => {
  const index = form.categories.indexOf(categoryId);

  if (checked && index === -1) {
    form.categories.push(categoryId);
  } else if (!checked && index > -1) {
    form.categories.splice(index, 1);
  }
};
</script>

<template>
  <form @submit.prevent="submit" class="space-y-8">
    <!-- Validation Errors Display -->
    <div v-if="Object.keys(form.errors).length > 0" class="rounded-lg border border-red-500 bg-red-50 dark:bg-red-900/20 p-4">
      <h3 class="font-semibold text-red-700 dark:text-red-400 mb-2">Validation Errors:</h3>
      <ul class="list-disc list-inside space-y-1 text-sm text-red-600 dark:text-red-300">
        <li v-for="(error, key) in form.errors" :key="key">
          <strong>{{ key }}:</strong> {{ error }}
        </li>
      </ul>
      <details class="mt-3">
        <summary class="cursor-pointer text-sm text-red-600 dark:text-red-300">Show Raw Errors</summary>
        <pre class="mt-2 text-xs bg-red-100 dark:bg-red-900/40 p-2 rounded overflow-auto">{{ form.errors }}</pre>
      </details>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
      <div class="md:col-span-2 space-y-6">
        <div class="space-y-2">
          <Label for="title">Title</Label>
          <Input
            id="title"
            v-model="form.title"
            placeholder="Enter post title"
            required
          />
          <p v-if="form.errors.title" class="text-sm text-destructive">
            {{ form.errors.title }}
          </p>
        </div>

        <div class="space-y-2">
          <Label for="slug">Slug</Label>
          <Input
            id="slug"
            v-model="form.slug"
            placeholder="post-slug"
            required
          />
          <p v-if="form.errors.slug" class="text-sm text-destructive">
            {{ form.errors.slug }}
          </p>
        </div>

        <div class="space-y-2">
          <Label for="image">Featured Image URL</Label>
          <Input
            id="image"
            v-model="form.image"
            type="url"
            placeholder="https://example.com/image.jpg"
          />
          <p class="text-xs text-muted-foreground">
            Optional - Enter the URL of a featured image for this post
          </p>
          <p v-if="form.errors.image" class="text-sm text-destructive">
            {{ form.errors.image }}
          </p>
        </div>

        <div
          v-for="fieldGroup in activeFieldGroups"
          :key="fieldGroup.id"
          class="space-y-4 rounded-lg border p-6"
        >
          <h3 class="font-semibold">{{ fieldGroup.title }}</h3>
          <div
            v-for="field in fieldGroup.fields"
            :key="field.id"
            class="space-y-2"
          >
            <FieldRenderer
              :field="field"
              :posts="posts"
              :categories="categories"
              :post-types="postTypes"
              :field-types="fieldTypes"
              v-model="form.content[field.name]"
            />
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="rounded-lg border p-6 space-y-4">
          <h3 class="font-semibold">Publish</h3>

          <div class="space-y-2">
            <Label for="status">Status</Label>
            <Select v-model="form.status">
              <SelectTrigger id="status">
                <SelectValue placeholder="Select status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="draft">Draft</SelectItem>
                <SelectItem value="published">Published</SelectItem>
              </SelectContent>
            </Select>
          </div>

          <div class="flex items-center space-x-2">
            <input
              type="checkbox"
              id="is_featured"
              v-model="form.is_featured"
              class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer"
            />
            <Label
              for="is_featured"
              class="text-sm font-normal cursor-pointer"
            >
              Featured Post
            </Label>
          </div>

          <Button
            type="submit"
            class="w-full"
            :disabled="form.processing"
          >
            {{ post ? 'Update' : 'Publish' }}
          </Button>
        </div>

        <div class="rounded-lg border p-6 space-y-4">
          <h3 class="font-semibold">Post Type</h3>
          <Select :model-value="String(form.post_type_id)" @update:model-value="(val) => form.post_type_id = Number(val)">
            <SelectTrigger>
              <SelectValue placeholder="Select post type" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem
                v-for="postType in postTypes"
                :key="postType.id"
                :value="String(postType.id)"
              >
                {{ postType.title }}
              </SelectItem>
            </SelectContent>
          </Select>
          <p v-if="form.errors.post_type_id" class="text-sm text-destructive">
            {{ form.errors.post_type_id }}
          </p>
        </div>

        <div class="rounded-lg border p-6 space-y-4">
          <h3 class="font-semibold">Categories</h3>
          <div class="space-y-2">
            <div
              v-for="category in categories"
              :key="category.id"
              class="flex items-center space-x-2"
            >
              <input
                type="checkbox"
                :id="`category-${category.id}`"
                :checked="form.categories.includes(category.id)"
                @change="(e) => toggleCategory(category.id, (e.target as HTMLInputElement).checked)"
                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer"
              />
              <Label
                :for="`category-${category.id}`"
                class="text-sm font-normal cursor-pointer"
              >
                {{ category.name }}
              </Label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
