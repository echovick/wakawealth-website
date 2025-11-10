<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Switch } from '@/components/ui/switch';
import InputError from '@/components/InputError.vue';

interface PostType {
    id?: number;
    title: string;
    slug: string;
    description: string | null;
    active: boolean;
}

interface Props {
    postType?: PostType;
    submitUrl: string;
    submitMethod?: 'post' | 'put';
}

const props = withDefaults(defineProps<Props>(), {
    postType: () => ({
        title: '',
        slug: '',
        description: null,
        active: true,
    }),
    submitMethod: 'post',
});

const form = useForm({
    title: props.postType?.title || '',
    slug: props.postType?.slug || '',
    description: props.postType?.description || '',
    active: props.postType?.active ?? true,
});

const generateSlug = () => {
    if (!form.title) return;
    form.slug = form.title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '_')
        .replace(/(^_|_$)/g, '');
};

const submit = () => {
    if (props.submitMethod === 'put') {
        form.put(props.submitUrl);
    } else {
        form.post(props.submitUrl);
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div class="space-y-4 bg-card p-6 rounded-lg border">
            <h3 class="text-lg font-semibold">Post Type Information</h3>

            <div class="space-y-2">
                <Label for="title">Title</Label>
                <Input
                    id="title"
                    v-model="form.title"
                    type="text"
                    required
                    @blur="generateSlug"
                />
                <InputError :message="form.errors.title" />
            </div>

            <div class="space-y-2">
                <Label for="slug">Slug</Label>
                <Input
                    id="slug"
                    v-model="form.slug"
                    type="text"
                />
                <p class="text-sm text-muted-foreground">
                    Used to identify this post type (e.g., blog_post, news_article)
                </p>
                <InputError :message="form.errors.slug" />
            </div>

            <div class="space-y-2">
                <Label for="description">Description</Label>
                <Textarea
                    id="description"
                    v-model="form.description"
                    rows="3"
                />
                <InputError :message="form.errors.description" />
            </div>

            <div class="flex items-center space-x-2">
                <Switch
                    id="active"
                    :checked="form.active"
                    @update:checked="(val) => form.active = val"
                />
                <Label for="active">Active</Label>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <Button
                type="button"
                variant="outline"
                @click="$inertia.visit('/cms/post-types')"
            >
                Cancel
            </Button>
            <Button
                type="submit"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Saving...' : postType?.id ? 'Update Post Type' : 'Create Post Type' }}
            </Button>
        </div>
    </form>
</template>
