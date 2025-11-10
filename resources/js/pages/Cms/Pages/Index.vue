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

interface Page {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    created_at: string;
    updated_at: string;
}

interface PaginatedPages {
    data: Page[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    pages: PaginatedPages;
}

const props = defineProps<Props>();

const deletePage = (pageId: number) => {
    if (confirm('Are you sure you want to delete this page?')) {
        router.delete(`/cms/pages/${pageId}`);
    }
};
</script>

<template>
    <CmsLayout
        title="Pages"
        :breadcrumbs="[
            { label: 'CMS', url: '/cms' },
            { label: 'Pages', url: '/cms/pages' },
        ]"
    >
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Pages</h2>
                    <p class="text-muted-foreground">
                        Manage your website pages
                    </p>
                </div>
                <Link href="/cms/pages/create">
                    <Button>Create Page</Button>
                </Link>
            </div>

            <div class="border rounded-lg">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Title</TableHead>
                            <TableHead>Slug</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead>Created</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-if="pages.data.length === 0"
                        >
                            <TableCell colspan="5" class="text-center py-8 text-muted-foreground">
                                No pages found. Create your first page to get started.
                            </TableCell>
                        </TableRow>
                        <TableRow
                            v-for="page in pages.data"
                            :key="page.id"
                        >
                            <TableCell class="font-medium">
                                {{ page.title }}
                            </TableCell>
                            <TableCell>
                                <code class="text-xs bg-muted px-2 py-1 rounded">
                                    /{{ page.slug }}
                                </code>
                            </TableCell>
                            <TableCell>
                                <span class="text-sm text-muted-foreground line-clamp-1">
                                    {{ page.description || '-' }}
                                </span>
                            </TableCell>
                            <TableCell>
                                <span class="text-sm text-muted-foreground">
                                    {{ new Date(page.created_at).toLocaleDateString() }}
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
                                            <Link :href="`/${page.slug}`" target="_blank">
                                                View
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem as-child>
                                            <Link :href="`/cms/pages/${page.id}/edit`">
                                                Edit
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem
                                            class="text-destructive"
                                            @click="deletePage(page.id)"
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

            <div v-if="pages.last_page > 1" class="flex justify-center gap-2">
                <Button
                    v-for="page in pages.last_page"
                    :key="page"
                    :variant="page === pages.current_page ? 'default' : 'outline'"
                    size="sm"
                    @click="router.get(`/cms/pages?page=${page}`)"
                >
                    {{ page }}
                </Button>
            </div>
        </div>
    </CmsLayout>
</template>
