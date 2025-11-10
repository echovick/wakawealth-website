<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';

// You can pass stats from the backend if needed
interface Props {
    stats?: {
        pagesCount?: number;
        postsCount?: number;
        categoriesCount?: number;
        contactsCount?: number;
    };
}

const props = withDefaults(defineProps<Props>(), {
    stats: () => ({
        pagesCount: 0,
        postsCount: 0,
        categoriesCount: 0,
        contactsCount: 0,
    }),
});
</script>

<template>
    <CmsLayout
        title="Dashboard"
        :breadcrumbs="[{ label: 'CMS', url: '/cms' }]"
    >
        <div class="space-y-6">
            <!-- Welcome Section -->
            <div>
                <h2 class="text-3xl font-bold">Welcome to WakaWealth CMS</h2>
                <p class="text-muted-foreground mt-2">
                    Manage your website content, pages, and settings from here.
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader class="pb-2">
                        <CardDescription>Total Pages</CardDescription>
                        <CardTitle class="text-3xl">
                            {{ stats.pagesCount }}
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Link href="/cms/pages">
                            <Button variant="link" class="p-0 h-auto">
                                View all pages →
                            </Button>
                        </Link>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="pb-2">
                        <CardDescription>Total Posts</CardDescription>
                        <CardTitle class="text-3xl">
                            {{ stats.postsCount }}
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Link href="/cms/posts">
                            <Button variant="link" class="p-0 h-auto">
                                View all posts →
                            </Button>
                        </Link>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="pb-2">
                        <CardDescription>Categories</CardDescription>
                        <CardTitle class="text-3xl">
                            {{ stats.categoriesCount }}
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Link href="/cms/categories">
                            <Button variant="link" class="p-0 h-auto">
                                Manage categories →
                            </Button>
                        </Link>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="pb-2">
                        <CardDescription>Contact Messages</CardDescription>
                        <CardTitle class="text-3xl">
                            {{ stats.contactsCount }}
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Link href="/cms/contacts">
                            <Button variant="link" class="p-0 h-auto">
                                View messages →
                            </Button>
                        </Link>
                    </CardContent>
                </Card>
            </div>

            <!-- Quick Actions -->
            <div class="grid gap-4 md:grid-cols-2">
                <Card>
                    <CardHeader>
                        <CardTitle>Content Management</CardTitle>
                        <CardDescription>
                            Create and manage your website content
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <Link href="/cms/pages/create">
                            <Button variant="outline" class="w-full justify-start">
                                + Create New Page
                            </Button>
                        </Link>
                        <Link href="/cms/posts/create">
                            <Button variant="outline" class="w-full justify-start">
                                + Create New Post
                            </Button>
                        </Link>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Customization</CardTitle>
                        <CardDescription>
                            Configure your CMS settings and fields
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <Link href="/cms/field-groups">
                            <Button variant="outline" class="w-full justify-start">
                                Manage Field Groups
                            </Button>
                        </Link>
                        <Link href="/cms/settings">
                            <Button variant="outline" class="w-full justify-start">
                                CMS Settings
                            </Button>
                        </Link>
                    </CardContent>
                </Card>
            </div>
        </div>
    </CmsLayout>
</template>
