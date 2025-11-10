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
    slug: string;
    active: boolean;
}

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        multiple?: boolean;
        max_items?: number;
    };
}

interface Props {
    field: Field;
    modelValue?: number | number[] | null;
    postTypes?: PostType[];
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const isMultiple = computed(() => props.field.field_config?.multiple ?? false);

const selectedPostTypeIds = computed(() => {
    if (!props.modelValue) return [];
    if (Array.isArray(props.modelValue)) return props.modelValue;
    return [props.modelValue];
});

const selectedPostTypes = computed(() => {
    if (!props.postTypes) return [];
    return props.postTypes.filter(postType => selectedPostTypeIds.value.includes(postType.id));
});

const togglePostType = (postTypeId: number) => {
    if (!isMultiple.value) {
        emit('update:modelValue', postTypeId);
        return;
    }

    const currentIds = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const index = currentIds.indexOf(postTypeId);

    if (index > -1) {
        currentIds.splice(index, 1);
    } else {
        const maxItems = props.field.field_config?.max_items ?? 0;
        if (maxItems > 0 && currentIds.length >= maxItems) {
            return;
        }
        currentIds.push(postTypeId);
    }

    emit('update:modelValue', currentIds.length > 0 ? currentIds : null);
};

const removePostType = (postTypeId: number) => {
    if (!isMultiple.value) {
        emit('update:modelValue', null);
        return;
    }

    const currentIds = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
    const filtered = currentIds.filter(id => id !== postTypeId);
    emit('update:modelValue', filtered.length > 0 ? filtered : null);
};

const handleSingleSelect = (value: string) => {
    if (!value) {
        emit('update:modelValue', null);
        return;
    }
    emit('update:modelValue', Number(value));
};

const getPostTypeStatus = (postType: PostType): string => {
    return postType.active ? 'Active' : 'Inactive';
};

const getPostTypeStatusColor = (postType: PostType): string => {
    return postType.active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400';
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
                    <SelectValue placeholder="Select a post type" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="">-- None --</SelectItem>
                    <SelectItem
                        v-for="postType in postTypes"
                        :key="postType.id"
                        :value="String(postType.id)"
                    >
                        {{ postType.title }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>

        <!-- Multiple Select Mode -->
        <div v-else class="space-y-3">
            <!-- Selected Post Types -->
            <div v-if="selectedPostTypes.length > 0" class="flex flex-wrap gap-2">
                <Badge
                    v-for="postType in selectedPostTypes"
                    :key="postType.id"
                    variant="secondary"
                    class="flex items-center gap-1 pr-1"
                >
                    <span>{{ postType.title }}</span>
                    <button
                        type="button"
                        @click="removePostType(postType.id)"
                        class="ml-1 hover:bg-muted rounded p-0.5"
                    >
                        <X class="h-3 w-3" />
                    </button>
                </Badge>
            </div>

            <!-- Available Post Types -->
            <div class="rounded-md border p-4 max-h-64 overflow-y-auto space-y-2">
                <div v-if="!postTypes || postTypes.length === 0" class="text-center text-muted-foreground py-4">
                    No post types available
                </div>
                <div
                    v-for="postType in postTypes"
                    :key="postType.id"
                    class="flex items-start gap-3 p-2 rounded hover:bg-muted/50 transition-colors"
                >
                    <Checkbox
                        :id="`post-type-${postType.id}`"
                        :checked="selectedPostTypeIds.includes(postType.id)"
                        @update:checked="() => togglePostType(postType.id)"
                    />
                    <label
                        :for="`post-type-${postType.id}`"
                        class="flex-1 cursor-pointer"
                    >
                        <div class="font-medium">{{ postType.title }}</div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-muted-foreground">
                                {{ postType.slug }}
                            </span>
                            <span
                                :class="['text-xs px-2 py-0.5 rounded', getPostTypeStatusColor(postType)]"
                            >
                                {{ getPostTypeStatus(postType) }}
                            </span>
                        </div>
                    </label>
                </div>
            </div>

            <p v-if="field.field_config?.max_items && field.field_config.max_items > 0" class="text-xs text-muted-foreground">
                Maximum {{ field.field_config.max_items }} post types can be selected
            </p>
        </div>
    </div>
</template>
