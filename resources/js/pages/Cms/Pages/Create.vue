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
    posts?: any[];
    categories?: any[];
    postTypes?: any[];
    fieldTypes?: any;
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
                :posts="posts"
                :categories="categories"
                :post-types="postTypes"
                :field-types="fieldTypes"
                submit-url="/cms/pages"
                submit-method="post"
            />
        </div>
    </CmsLayout>
</template>
