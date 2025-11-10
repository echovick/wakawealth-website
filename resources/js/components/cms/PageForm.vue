<script setup lang="ts">
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { ChevronDown, ChevronUp } from 'lucide-vue-next';
import FieldRenderer from '@/components/cms/fields/FieldRenderer.vue';
import InputError from '@/components/InputError.vue';

interface Page {
    id?: number;
    slug: string;
    title: string;
    description: string | null;
    content: Record<string, any>;
}

interface FieldGroup {
    id: number;
    title: string;
    fields: Field[];
}

interface Field {
    id: number;
    name: string;
    label: string;
    type: string;
    required: boolean;
    instructions: string | null;
    field_config: Record<string, any>;
}

interface Props {
    page?: Page;
    fieldGroups?: FieldGroup[];
    posts?: any[];
    submitUrl: string;
    submitMethod?: 'post' | 'put';
}

const props = withDefaults(defineProps<Props>(), {
    page: () => ({
        slug: '',
        title: '',
        description: null,
        content: {},
    }),
    fieldGroups: () => [],
    posts: () => [],
    submitMethod: 'post',
});

// Normalize content to ensure it's always an object, not an array
const normalizeContent = (content: any): Record<string, any> => {
    if (!content) return {};
    if (Array.isArray(content)) return {};
    return content;
};

const form = useForm({
    slug: props.page?.slug || '',
    title: props.page?.title || '',
    description: props.page?.description || '',
    content: normalizeContent(props.page?.content),
});

// Track collapsed state for each field group
const collapsedFieldGroups = ref<Record<number, boolean>>({});

const toggleFieldGroupCollapse = (groupId: number): void => {
    collapsedFieldGroups.value[groupId] = !collapsedFieldGroups.value[groupId];
};

const generateSlug = () => {
    if (!form.title) return;
    form.slug = form.title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
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
            <h3 class="text-lg font-semibold">Basic Information</h3>

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
                    URL: /{{ form.slug }}
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
        </div>

        <div
            v-for="fieldGroup in fieldGroups"
            :key="fieldGroup.id"
            class="bg-card rounded-lg border"
        >
            <div class="flex items-center justify-between p-6 pb-4">
                <h3 class="text-lg font-semibold">{{ fieldGroup.title }}</h3>
                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    @click="toggleFieldGroupCollapse(fieldGroup.id)"
                >
                    <ChevronDown v-if="collapsedFieldGroups[fieldGroup.id]" class="h-5 w-5" />
                    <ChevronUp v-else class="h-5 w-5" />
                </Button>
            </div>

            <div v-if="!collapsedFieldGroups[fieldGroup.id]" class="px-6 pb-6 space-y-4">
                <div
                    v-for="field in fieldGroup.fields"
                    :key="field.id"
                    class="space-y-2"
                >
                    <FieldRenderer
                        :field="field"
                        :posts="posts"
                        v-model="form.content[field.name]"
                    />
                    <InputError :message="form.errors[`content.${field.name}`]" />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <Button
                type="button"
                variant="outline"
                @click="$inertia.visit('/cms/pages')"
            >
                Cancel
            </Button>
            <Button
                type="submit"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Saving...' : page?.id ? 'Update Page' : 'Create Page' }}
            </Button>
        </div>
    </form>
</template>
