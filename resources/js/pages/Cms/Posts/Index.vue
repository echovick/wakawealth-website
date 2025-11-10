<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import { Button } from '@/components/ui/button';

declare const route: any;
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { MoreHorizontal, Plus } from 'lucide-vue-next';

interface Post {
  id: number;
  title: string;
  slug: string;
  post_type: {
    id: number;
    title: string;
  };
  user: {
    id: number;
    name: string;
  };
  published_at: string | null;
  created_at: string;
}

interface Props {
  posts: {
    data: Post[];
    links: Array<{
      url: string | null;
      label: string;
      active: boolean;
    }>;
  };
}

const props = defineProps<Props>();

const deletePost = (postId: number): void => {
  if (confirm('Are you sure you want to delete this post?')) {
    router.delete(route('cms.posts.destroy', postId));
  }
};

const formatDate = (date: string | null): string => {
  if (!date) return 'Draft';
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};
</script>

<template>
  <Head title="Posts" />

  <CmsLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold tracking-tight">Posts</h1>
          <p class="text-muted-foreground">
            Manage your blog posts and custom post types
          </p>
        </div>
        <Link :href="route('cms.posts.create')">
          <Button>
            <Plus class="mr-2 h-4 w-4" />
            New Post
          </Button>
        </Link>
      </div>

      <div class="rounded-md border">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Title</TableHead>
              <TableHead>Post Type</TableHead>
              <TableHead>Author</TableHead>
              <TableHead>Status</TableHead>
              <TableHead>Date</TableHead>
              <TableHead class="w-[70px]"></TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-if="posts.data.length === 0">
              <TableCell colspan="6" class="text-center text-muted-foreground">
                No posts found. Create your first post to get started.
              </TableCell>
            </TableRow>
            <TableRow v-for="post in posts.data" :key="post.id">
              <TableCell class="font-medium">{{ post.title }}</TableCell>
              <TableCell>{{ post.post_type.title }}</TableCell>
              <TableCell>{{ post.user.name }}</TableCell>
              <TableCell>
                <span
                  v-if="post.published_at"
                  class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                >
                  Published
                </span>
                <span
                  v-else
                  class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10"
                >
                  Draft
                </span>
              </TableCell>
              <TableCell>{{ formatDate(post.published_at || post.created_at) }}</TableCell>
              <TableCell>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="ghost" size="icon">
                      <MoreHorizontal class="h-4 w-4" />
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent align="end">
                    <DropdownMenuItem as-child>
                      <Link :href="route('cms.posts.edit', post.id)">
                        Edit
                      </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem
                      class="text-destructive"
                      @click="deletePost(post.id)"
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

      <div v-if="posts.links.length > 3" class="flex items-center justify-center space-x-2">
        <Link
          v-for="(link, index) in posts.links"
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
  </CmsLayout>
</template>
