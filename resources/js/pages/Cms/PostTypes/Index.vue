<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import { Button } from '@/components/ui/button';
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
import { Badge } from '@/components/ui/badge';

interface PostType {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    active: boolean;
    created_at: string;
    updated_at: string;
}

interface PaginatedPostTypes {
    data: PostType[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    postTypes: PaginatedPostTypes;
}

const props = defineProps<Props>();

const deletePostType = (postTypeId: number) => {
    if (confirm('Are you sure you want to delete this post type?')) {
        router.delete(`/cms/post-types/${postTypeId}`);
    }
};
</script>

<template>
    <CmsLayout
        title="Post Types"
        :breadcrumbs="[
            { label: 'CMS', url: '/cms' },
            { label: 'Post Types', url: '/cms/post-types' },
        ]"
    >
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Post Types</h2>
                    <p class="text-muted-foreground">
                        Manage custom post types for your content
                    </p>
                </div>
                <Link href="/cms/post-types/create">
                    <Button>Create Post Type</Button>
                </Link>
            </div>

            <div class="border rounded-lg">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Title</TableHead>
                            <TableHead>Slug</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Created</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-if="postTypes.data.length === 0"
                        >
                            <TableCell colspan="6" class="text-center py-8 text-muted-foreground">
                                No post types found. Create your first post type to get started.
                            </TableCell>
                        </TableRow>
                        <TableRow
                            v-for="postType in postTypes.data"
                            :key="postType.id"
                        >
                            <TableCell class="font-medium">
                                {{ postType.title }}
                            </TableCell>
                            <TableCell>
                                <code class="text-xs bg-muted px-2 py-1 rounded">
                                    {{ postType.slug }}
                                </code>
                            </TableCell>
                            <TableCell>
                                <span class="text-sm text-muted-foreground line-clamp-1">
                                    {{ postType.description || '-' }}
                                </span>
                            </TableCell>
                            <TableCell>
                                <Badge :variant="postType.active ? 'default' : 'secondary'">
                                    {{ postType.active ? 'Active' : 'Inactive' }}
                                </Badge>
                            </TableCell>
                            <TableCell>
                                <span class="text-sm text-muted-foreground">
                                    {{ new Date(postType.created_at).toLocaleDateString() }}
                                </span>
                            </TableCell>
                            <TableCell class="text-right">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button variant="ghost" size="sm">
                                            •••
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem as-child>
                                            <Link :href="`/cms/post-types/${postType.id}/edit`">
                                                Edit
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem
                                            class="text-destructive"
                                            @click="deletePostType(postType.id)"
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

            <div v-if="postTypes.last_page > 1" class="flex justify-center gap-2">
                <Button
                    v-for="page in postTypes.last_page"
                    :key="page"
                    :variant="page === postTypes.current_page ? 'default' : 'outline'"
                    size="sm"
                    @click="router.get(`/cms/post-types?page=${page}`)"
                >
                    {{ page }}
                </Button>
            </div>
        </div>
    </CmsLayout>
</template>
