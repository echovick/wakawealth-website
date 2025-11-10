<script setup lang="ts">
import { SidebarTrigger } from '@/components/ui/sidebar';
import { Separator } from '@/components/ui/separator';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    title?: string;
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    title: '',
});
</script>

<template>
    <header class="sticky top-0 z-10 flex h-16 shrink-0 items-center gap-2 border-b bg-background px-4">
        <SidebarTrigger class="-ml-1" />
        <Separator orientation="vertical" class="mr-2 h-4" />
        <div class="flex flex-1 items-center justify-between">
            <div>
                <h1 v-if="title" class="text-lg font-semibold">
                    {{ title }}
                </h1>
                <Breadcrumbs v-if="breadcrumbs.length" :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </header>
</template>
