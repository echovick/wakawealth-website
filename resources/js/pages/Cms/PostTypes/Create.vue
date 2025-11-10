<script setup lang="ts">
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import PostTypeForm from '@/components/cms/PostTypeForm.vue';
</script>

<template>
    <CmsLayout
        title="Create Post Type"
        :breadcrumbs="[
            { label: 'CMS', url: '/cms' },
            { label: 'Post Types', url: '/cms/post-types' },
            { label: 'Create', url: '/cms/post-types/create' },
        ]"
    >
        <div class="max-w-4xl">
            <PostTypeForm
                submit-url="/cms/post-types"
                submit-method="post"
            />
        </div>
    </CmsLayout>
</template>
