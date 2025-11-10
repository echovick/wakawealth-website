<script setup lang="ts">
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import PostTypeForm from '@/components/cms/PostTypeForm.vue';

interface PostType {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    active: boolean;
}

interface Props {
    postType: PostType;
}

const props = defineProps<Props>();
</script>

<template>
    <CmsLayout
        :title="`Edit: ${postType.title}`"
        :breadcrumbs="[
            { label: 'CMS', url: '/cms' },
            { label: 'Post Types', url: '/cms/post-types' },
            { label: postType.title, url: `/cms/post-types/${postType.id}/edit` },
        ]"
    >
        <div class="max-w-4xl">
            <PostTypeForm
                :post-type="postType"
                :submit-url="`/cms/post-types/${postType.id}`"
                submit-method="put"
            />
        </div>
    </CmsLayout>
</template>
