<script setup lang="ts">
import { ref, computed, watch } from 'vue';
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
import { Calendar } from '@/components/ui/calendar';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover';
import { Checkbox } from '@/components/ui/checkbox';
import FieldRenderer from '@/components/cms/fields/FieldRenderer.vue';
import { CalendarIcon } from 'lucide-vue-next';

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
  categories: Array<{ id: number }>;
}

interface Props {
  post?: Post;
  postTypes: PostType[];
  categories: Category[];
  fieldGroups: FieldGroup[];
  posts?: any[];
}

const props = withDefaults(defineProps<Props>(), {
  posts: () => [],
});

const form = useForm({
  post_type_id: props.post?.post_type_id || (props.postTypes[0]?.id ?? null),
  title: props.post?.title || '',
  slug: props.post?.slug || '',
  content: props.post?.content || {},
  published_at: props.post?.published_at || null,
  categories: props.post?.categories?.map(c => c.id) || [],
});

const publishDate = ref<Date | undefined>(
  props.post?.published_at ? new Date(props.post.published_at) : undefined
);

watch(() => form.title, (newTitle) => {
  if (!props.post) {
    form.slug = newTitle
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-|-$/g, '');
  }
});

watch(publishDate, (newDate) => {
  form.published_at = newDate ? newDate.toISOString() : null;
});

const submit = (): void => {
  if (props.post) {
    form.put(`/cms/posts/${props.post.id}`);
  } else {
    form.post('/cms/posts');
  }
};

const formatDate = (date: Date | undefined): string => {
  if (!date) return 'Pick a date';
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
};

const toggleCategory = (categoryId: number): void => {
  const index = form.categories.indexOf(categoryId);
  if (index > -1) {
    form.categories.splice(index, 1);
  } else {
    form.categories.push(categoryId);
  }
};
</script>

<template>
  <form @submit.prevent="submit" class="space-y-8">
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

        <div
          v-for="fieldGroup in fieldGroups"
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
              v-model="form.content[field.name]"
            />
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="rounded-lg border p-6 space-y-4">
          <h3 class="font-semibold">Publish</h3>

          <div class="space-y-2">
            <Label>Status</Label>
            <Popover>
              <PopoverTrigger as-child>
                <Button
                  variant="outline"
                  class="w-full justify-start text-left font-normal"
                >
                  <CalendarIcon class="mr-2 h-4 w-4" />
                  {{ formatDate(publishDate) }}
                </Button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <Calendar v-model="publishDate" />
              </PopoverContent>
            </Popover>
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
          <Select v-model="form.post_type_id">
            <SelectTrigger>
              <SelectValue placeholder="Select post type" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem
                v-for="postType in postTypes"
                :key="postType.id"
                :value="postType.id"
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
              <Checkbox
                :id="`category-${category.id}`"
                :checked="form.categories.includes(category.id)"
                @update:checked="toggleCategory(category.id)"
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
