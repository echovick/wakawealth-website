<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';

const menuItems = [
    {
        title: 'Dashboard',
        url: '/cms',
        icon: 'layout-dashboard',
    },
    {
        title: 'Pages',
        url: '/cms/pages',
        icon: 'file-text',
    },
    {
        title: 'Posts',
        url: '/cms/posts',
        icon: 'newspaper',
    },
    {
        title: 'Categories',
        url: '/cms/categories',
        icon: 'folder',
    },
    {
        title: 'Field Groups',
        url: '/cms/field-groups',
        icon: 'boxes',
    },
    {
        title: 'Settings',
        url: '/cms/settings',
        icon: 'settings',
    },
    {
        title: 'Contacts',
        url: '/cms/contacts',
        icon: 'mail',
    },
];
</script>

<template>
    <Sidebar>
        <SidebarHeader>
            <div class="flex items-center gap-2 px-4 py-2">
                <Link
                    href="/"
                    class="flex items-center gap-2 font-semibold text-lg"
                >
                    <span>WakaWealth CMS</span>
                </Link>
            </div>
        </SidebarHeader>

        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupLabel>Content Management</SidebarGroupLabel>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem
                            v-for="item in menuItems"
                            :key="item.title"
                        >
                            <SidebarMenuButton as-child>
                                <Link :href="item.url">
                                    <span>{{ item.title }}</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>

        <SidebarFooter>
            <div class="px-4 py-2 space-y-2">
                <Link href="/" class="block text-sm text-muted-foreground hover:text-foreground">
                    ← Back to Website
                </Link>
                <Link
                    href="/cms/logout"
                    method="post"
                    as="button"
                    class="block text-sm text-destructive hover:text-destructive/80"
                >
                    Logout
                </Link>
            </div>
        </SidebarFooter>
    </Sidebar>
</template>
