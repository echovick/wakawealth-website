<script setup lang="ts">
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import PageForm from '@/components/cms/PageForm.vue';

interface Page {
    id: number;
    slug: string;
    title: string;
    description: string | null;
    content: Record<string, any>;
}

interface FieldGroup {
    id: number;
    title: string;
    fields: any[];
}

interface Props {
    page: Page;
    fieldGroups: FieldGroup[];
}

const props = defineProps<Props>();
</script>

<template>
    <CmsLayout
        :title="`Edit: ${page.title}`"
        :breadcrumbs="[
            { label: 'CMS', url: '/cms' },
            { label: 'Pages', url: '/cms/pages' },
            { label: page.title, url: `/cms/pages/${page.id}/edit` },
        ]"
    >
        <div class="max-w-4xl">
            <PageForm
                :page="page"
                :field-groups="fieldGroups"
                :submit-url="`/cms/pages/${page.id}`"
                submit-method="put"
            />
        </div>
    </CmsLayout>
</template>
