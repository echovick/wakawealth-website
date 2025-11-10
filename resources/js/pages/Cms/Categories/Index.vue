<script setup lang="ts">
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { MoreHorizontal, Plus, FolderOpen, FolderTree } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';

interface Category {
  id: number;
  name: string;
  slug: string;
  image: string | null;
  description: string | null;
  parent_id: number | null;
  posts_count: number;
  parent?: {
    id: number;
    name: string;
  };
}

interface Props {
  categories: {
    data: Category[];
    links: Array<{
      url: string | null;
      label: string;
      active: boolean;
    }>;
  };
}

const props = defineProps<Props>();

const isCreateDialogOpen = ref(false);
const isEditDialogOpen = ref(false);
const editingCategory = ref<Category | null>(null);

const createForm = useForm({
  name: '',
  slug: '',
  image: '',
  description: '',
  parent_id: null as number | null,
});

const editForm = useForm({
  name: '',
  slug: '',
  image: '',
  description: '',
  parent_id: null as number | null,
});

const createCategory = (): void => {
  createForm.post('/cms/categories', {
    onSuccess: () => {
      isCreateDialogOpen.value = false;
      createForm.reset();
    },
  });
};

const openEditDialog = (category: Category): void => {
  editingCategory.value = category;
  editForm.name = category.name;
  editForm.slug = category.slug;
  editForm.image = category.image || '';
  editForm.description = category.description || '';
  editForm.parent_id = category.parent_id;
  isEditDialogOpen.value = true;
};

const updateCategory = (): void => {
  if (!editingCategory.value) return;

  editForm.put(`/cms/categories/${editingCategory.value.id}`, {
    onSuccess: () => {
      isEditDialogOpen.value = false;
      editForm.reset();
      editingCategory.value = null;
    },
  });
};

const deleteCategory = (categoryId: number): void => {
  if (confirm('Are you sure you want to delete this category?')) {
    router.delete(`/cms/categories/${categoryId}`);
  }
};

const generateSlug = (name: string, form: typeof createForm): void => {
  form.slug = name
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '');
};
</script>

<template>
  <Head title="Categories" />

  <CmsLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold tracking-tight">Categories</h1>
          <p class="text-muted-foreground">
            Organize your posts with categories
          </p>
        </div>
        <Dialog v-model:open="isCreateDialogOpen">
          <DialogTrigger as-child>
            <Button>
              <Plus class="mr-2 h-4 w-4" />
              New Category
            </Button>
          </DialogTrigger>
          <DialogContent>
            <DialogHeader>
              <DialogTitle>Create Category</DialogTitle>
              <DialogDescription>
                Add a new category to organize your content
              </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="createCategory" class="space-y-4">
              <div class="space-y-2">
                <Label for="create-name">Name</Label>
                <Input
                  id="create-name"
                  v-model="createForm.name"
                  @input="generateSlug(createForm.name, createForm)"
                  placeholder="Category name"
                  required
                />
                <p v-if="createForm.errors.name" class="text-sm text-destructive">
                  {{ createForm.errors.name }}
                </p>
              </div>

              <div class="space-y-2">
                <Label for="create-slug">Slug</Label>
                <Input
                  id="create-slug"
                  v-model="createForm.slug"
                  placeholder="category-slug"
                  required
                />
                <p v-if="createForm.errors.slug" class="text-sm text-destructive">
                  {{ createForm.errors.slug }}
                </p>
              </div>

              <div class="space-y-2">
                <Label for="create-image">Image URL</Label>
                <Input
                  id="create-image"
                  v-model="createForm.image"
                  type="url"
                  placeholder="https://example.com/image.jpg"
                />
                <p v-if="createForm.errors.image" class="text-sm text-destructive">
                  {{ createForm.errors.image }}
                </p>
                <p class="text-xs text-muted-foreground">
                  Optional - Enter the URL of an image for this category
                </p>
              </div>

              <div class="space-y-2">
                <Label for="create-description">Description</Label>
                <Textarea
                  id="create-description"
                  v-model="createForm.description"
                  placeholder="Category description (optional)"
                />
              </div>

              <div class="space-y-2">
                <Label for="create-parent">Parent Category</Label>
                <Select v-model="createForm.parent_id">
                  <SelectTrigger>
                    <SelectValue placeholder="None (top level)" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem :value="null">None (top level)</SelectItem>
                    <SelectItem
                      v-for="category in categories.data.filter(c => !c.parent_id)"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </SelectItem>
                  </SelectContent>
                </Select>
                <p class="text-xs text-muted-foreground">
                  Only top-level categories can be parent categories
                </p>
              </div>

              <DialogFooter>
                <Button
                  type="submit"
                  :disabled="createForm.processing"
                >
                  Create Category
                </Button>
              </DialogFooter>
            </form>
          </DialogContent>
        </Dialog>
      </div>

      <div class="rounded-md border">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Name</TableHead>
              <TableHead>Slug</TableHead>
              <TableHead>Description</TableHead>
              <TableHead>Posts</TableHead>
              <TableHead class="w-[70px]"></TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-if="categories.data.length === 0">
              <TableCell colspan="5" class="text-center text-muted-foreground">
                No categories found. Create your first category to get started.
              </TableCell>
            </TableRow>
            <TableRow
              v-for="category in categories.data"
              :key="category.id"
              :class="category.parent_id ? 'bg-muted/30' : ''"
            >
              <TableCell>
                <div class="flex items-center gap-2">
                  <div
                    :class="category.parent_id ? 'ml-8' : ''"
                    class="flex items-center gap-2"
                  >
                    <FolderOpen
                      v-if="!category.parent_id"
                      class="h-4 w-4 text-primary"
                    />
                    <FolderTree
                      v-else
                      class="h-4 w-4 text-muted-foreground"
                    />
                    <span :class="category.parent_id ? 'font-normal' : 'font-semibold'">
                      {{ category.name }}
                    </span>
                  </div>
                  <Badge
                    v-if="category.parent"
                    variant="secondary"
                    class="text-xs"
                  >
                    {{ category.parent.name }}
                  </Badge>
                </div>
              </TableCell>
              <TableCell class="text-muted-foreground">{{ category.slug }}</TableCell>
              <TableCell class="text-muted-foreground">
                {{ category.description || '—' }}
              </TableCell>
              <TableCell>{{ category.posts_count }}</TableCell>
              <TableCell>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="ghost" size="icon">
                      <MoreHorizontal class="h-4 w-4" />
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent align="end">
                    <DropdownMenuItem @click="openEditDialog(category)">
                      Edit
                    </DropdownMenuItem>
                    <DropdownMenuItem
                      class="text-destructive"
                      @click="deleteCategory(category.id)"
                    >
                      Delete
                    </DropdownMenuItem>
                  </DropdownMenuContent>
                </DropdownMenu>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>

      <div v-if="categories.links.length > 3" class="flex items-center justify-center space-x-2">
        <a
          v-for="(link, index) in categories.links"
          :key="index"
          :href="link.url || '#'"
          :class="[
            'px-3 py-2 text-sm rounded-md',
            link.active
              ? 'bg-primary text-primary-foreground'
              : 'hover:bg-muted',
            !link.url && 'opacity-50 pointer-events-none',
          ]"
          v-html="link.label"
        />
      </div>
    </div>

    <Dialog v-model:open="isEditDialogOpen">
      <DialogContent>
        <DialogHeader>
          <DialogTitle>Edit Category</DialogTitle>
          <DialogDescription>
            Update category information
          </DialogDescription>
        </DialogHeader>
        <form @submit.prevent="updateCategory" class="space-y-4">
          <div class="space-y-2">
            <Label for="edit-name">Name</Label>
            <Input
              id="edit-name"
              v-model="editForm.name"
              placeholder="Category name"
              required
            />
            <p v-if="editForm.errors.name" class="text-sm text-destructive">
              {{ editForm.errors.name }}
            </p>
          </div>

          <div class="space-y-2">
            <Label for="edit-slug">Slug</Label>
            <Input
              id="edit-slug"
              v-model="editForm.slug"
              placeholder="category-slug"
              required
            />
            <p v-if="editForm.errors.slug" class="text-sm text-destructive">
              {{ editForm.errors.slug }}
            </p>
          </div>

          <div class="space-y-2">
            <Label for="edit-image">Image URL</Label>
            <Input
              id="edit-image"
              v-model="editForm.image"
              type="url"
              placeholder="https://example.com/image.jpg"
            />
            <p v-if="editForm.errors.image" class="text-sm text-destructive">
              {{ editForm.errors.image }}
            </p>
            <p class="text-xs text-muted-foreground">
              Optional - Enter the URL of an image for this category
            </p>
          </div>

          <div class="space-y-2">
            <Label for="edit-description">Description</Label>
            <Textarea
              id="edit-description"
              v-model="editForm.description"
              placeholder="Category description (optional)"
            />
          </div>

          <div class="space-y-2">
            <Label for="edit-parent">Parent Category</Label>
            <Select v-model="editForm.parent_id">
              <SelectTrigger>
                <SelectValue placeholder="None (top level)" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem :value="null">None (top level)</SelectItem>
                <SelectItem
                  v-for="category in categories.data.filter(c => c.id !== editingCategory?.id && !c.parent_id)"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.name }}
                </SelectItem>
              </SelectContent>
            </Select>
            <p class="text-xs text-muted-foreground">
              Only top-level categories can be parent categories
            </p>
          </div>

          <DialogFooter>
            <Button
              type="submit"
              :disabled="editForm.processing"
            >
              Update Category
            </Button>
          </DialogFooter>
        </form>
      </DialogContent>
    </Dialog>
  </CmsLayout>
</template>
