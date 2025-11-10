<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import CmsSidebar from '@/components/cms/CmsSidebar.vue';
import CmsHeader from '@/components/cms/CmsHeader.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    title?: string;
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    title: 'CMS',
});
</script>

<template>
    <AppShell variant="sidebar">
        <CmsSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <CmsHeader :breadcrumbs="breadcrumbs" :title="title" />
            <div class="container mx-auto py-6 px-4">
                <slot />
            </div>
        </AppContent>
    </AppShell>
</template>
