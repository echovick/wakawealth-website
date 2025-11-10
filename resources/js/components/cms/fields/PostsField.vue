<script setup lang="ts">
import { computed } from 'vue';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Checkbox } from '@/components/ui/checkbox';
import { Badge } from '@/components/ui/badge';
import { X } from 'lucide-vue-next';

interface PostType {
    id: number;
    title: string;
}

interface Post {
    id: number;
    title: string;
    slug: string;
    post_type_id: number;
    published_at: string | null;
    post_type?: PostType;
}

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        post_type_filter?: number | null;
        multiple?: boolean;
        max_items?: number;
    };
}

interface Props {
    field: Field;
    modelValue?: number | number[] | null;
    posts?: Post[];
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const isMultiple = computed(() => props.field.field_config?.multiple ?? false);

const filteredPosts = computed(() => {
    if (!props.posts) return [];

    const postTypeFilter = props.field.field_config?.post_type_filter;
    if (!postTypeFilter) return props.posts;

    return props.posts.filter(post => post.post_type_id === postTypeFilter);
});

const selectedPostIds = computed(() => {
    if (!props.modelValue) return [];
    if (Array.isArray(props.modelValue)) return props.modelValue;
    return [props.modelValue];
});

const selectedPosts = computed(() => {
    return filteredPosts.value.filter(post => selectedPostIds.value.includes(post.id));
});

const togglePost = (postId: number) => {
    if (!isMultiple.value) {
        emit('update:modelValue', postId);
        return;
    }

    const currentIds = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const index = currentIds.indexOf(postId);

    if (index > -1) {
        currentIds.splice(index, 1);
    } else {
        const maxItems = props.field.field_config?.max_items ?? 0;
        if (maxItems > 0 && currentIds.length >= maxItems) {
            return;
        }
        currentIds.push(postId);
    }

    emit('update:modelValue', currentIds.length > 0 ? currentIds : null);
};

const removePost = (postId: number) => {
    if (!isMultiple.value) {
        emit('update:modelValue', null);
        return;
    }

    const currentIds = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const filtered = currentIds.filter(id => id !== postId);
    emit('update:modelValue', filtered.length > 0 ? filtered : null);
};

const handleSingleSelect = (value: string) => {
    if (!value) {
        emit('update:modelValue', null);
        return;
    }
    emit('update:modelValue', Number(value));
};

const getPostStatus = (post: Post): string => {
    return post.published_at ? 'Published' : 'Draft';
};

const getPostStatusColor = (post: Post): string => {
    return post.published_at ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400';
};
</script>

<template>
    <div class="space-y-2">
        <Label :for="field.name">
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>

        <!-- Single Select Mode -->
        <div v-if="!isMultiple">
            <Select
                :model-value="modelValue ? String(modelValue) : ''"
                @update:model-value="handleSingleSelect"
            >
                <SelectTrigger>
                    <SelectValue placeholder="Select a post" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="">-- None --</SelectItem>
                    <SelectItem
                        v-for="post in filteredPosts"
                        :key="post.id"
                        :value="String(post.id)"
                    >
                        <div class="flex items-center gap-2">
                            <span>{{ post.title }}</span>
                            <span
                                v-if="post.post_type"
                                class="text-xs px-1.5 py-0.5 rounded bg-muted"
                            >
                                {{ post.post_type.title }}
                            </span>
                        </div>
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>

        <!-- Multiple Select Mode -->
        <div v-else class="space-y-3">
            <!-- Selected Posts -->
            <div v-if="selectedPosts.length > 0" class="flex flex-wrap gap-2">
                <Badge
                    v-for="post in selectedPosts"
                    :key="post.id"
                    variant="secondary"
                    class="flex items-center gap-1 pr-1"
                >
                    <span>{{ post.title }}</span>
                    <button
                        type="button"
                        @click="removePost(post.id)"
                        class="ml-1 hover:bg-muted rounded p-0.5"
                    >
                        <X class="h-3 w-3" />
                    </button>
                </Badge>
            </div>

            <!-- Available Posts -->
            <div class="rounded-md border p-4 max-h-64 overflow-y-auto space-y-2">
                <div v-if="filteredPosts.length === 0" class="text-center text-muted-foreground py-4">
                    No posts available
                </div>
                <div
                    v-for="post in filteredPosts"
                    :key="post.id"
                    class="flex items-start gap-3 p-2 rounded hover:bg-muted/50 transition-colors"
                >
                    <Checkbox
                        :id="`post-${post.id}`"
                        :checked="selectedPostIds.includes(post.id)"
                        @update:checked="() => togglePost(post.id)"
                    />
                    <label
                        :for="`post-${post.id}`"
                        class="flex-1 cursor-pointer"
                    >
                        <div class="font-medium">{{ post.title }}</div>
                        <div class="flex items-center gap-2 mt-1">
                            <span
                                v-if="post.post_type"
                                class="text-xs px-2 py-0.5 rounded bg-muted"
                            >
                                {{ post.post_type.title }}
                            </span>
                            <span
                                :class="['text-xs px-2 py-0.5 rounded', getPostStatusColor(post)]"
                            >
                                {{ getPostStatus(post) }}
                            </span>
                        </div>
                    </label>
                </div>
            </div>

            <p v-if="field.field_config?.max_items && field.field_config.max_items > 0" class="text-xs text-muted-foreground">
                Maximum {{ field.field_config.max_items }} posts can be selected
            </p>
        </div>
    </div>
</template>
