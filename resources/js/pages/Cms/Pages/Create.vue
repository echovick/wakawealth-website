<script setup lang="ts">
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import PageForm from '@/components/cms/PageForm.vue';

interface FieldGroup {
    id: number;
    title: string;
    fields: any[];
}

interface Props {
    fieldGroups: FieldGroup[];
}

const props = defineProps<Props>();
</script>

<template>
    <CmsLayout
        title="Create Page"
        :breadcrumbs="[
            { label: 'CMS', url: '/cms' },
            { label: 'Pages', url: '/cms/pages' },
            { label: 'Create', url: '/cms/pages/create' },
        ]"
    >
        <div class="max-w-4xl">
            <PageForm
                :field-groups="fieldGroups"
                submit-url="/cms/pages"
                submit-method="post"
            />
        </div>
    </CmsLayout>
</template>
