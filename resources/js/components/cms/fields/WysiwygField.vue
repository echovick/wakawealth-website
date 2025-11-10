<script setup lang="ts">
import { onMounted, onBeforeUnmount, watch } from 'vue';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import Placeholder from '@tiptap/extension-placeholder';
import { Label } from '@/components/ui/label';
import {
    Bold,
    Italic,
    Heading1,
    Heading2,
    Heading3,
    List,
    ListOrdered,
    Link as LinkIcon,
    Image as ImageIcon,
    Quote,
    Code,
} from 'lucide-vue-next';

interface Field {
    name: string;
    label: string;
    required: boolean;
    field_config: {
        toolbar?: 'full' | 'basic';
        media_upload?: boolean;
        placeholder?: string;
    };
}

interface Props {
    field: Field;
    modelValue?: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const toolbar = props.field.field_config?.toolbar || 'full';
const mediaUpload = props.field.field_config?.media_upload ?? true;

const editor = useEditor({
    content: props.modelValue || '',
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [1, 2, 3],
            },
        }),
        Link.configure({
            openOnClick: false,
            HTMLAttributes: {
                class: 'text-blue-500 underline',
            },
        }),
        Image.configure({
            HTMLAttributes: {
                class: 'max-w-full h-auto rounded',
            },
        }),
        Placeholder.configure({
            placeholder: props.field.field_config?.placeholder || 'Start typing...',
        }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-invert max-w-none focus:outline-none min-h-[200px] p-4',
        },
    },
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML());
    },
});

watch(() => props.modelValue, (newValue) => {
    const isSame = editor.value?.getHTML() === newValue;
    if (!isSame && newValue !== undefined) {
        editor.value?.commands.setContent(newValue, false);
    }
});

const addImage = () => {
    const url = window.prompt('Enter image URL:');
    if (url && editor.value) {
        editor.value.chain().focus().setImage({ src: url }).run();
    }
};

const addLink = () => {
    const url = window.prompt('Enter URL:');
    if (url && editor.value) {
        editor.value.chain().focus().setLink({ href: url }).run();
    }
};

onMounted(() => {
    // Editor is already initialized via useEditor
});

onBeforeUnmount(() => {
    editor.value?.destroy();
});
</script>

<template>
    <div class="space-y-2">
        <Label :for="field.name">
            {{ field.label }}
            <span v-if="field.required" class="text-destructive">*</span>
        </Label>

        <div v-if="editor" class="rounded-md border border-gray-700 bg-gray-900 overflow-hidden">
            <!-- Toolbar -->
            <div class="flex flex-wrap gap-1 border-b border-gray-700 bg-gray-800 p-2">
                <!-- Bold -->
                <button
                    type="button"
                    @click="editor.chain().focus().toggleBold().run()"
                    :class="[
                        'p-2 rounded hover:bg-gray-700 transition-colors',
                        editor.isActive('bold') ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                    ]"
                    title="Bold"
                >
                    <Bold class="h-4 w-4" />
                </button>

                <!-- Italic -->
                <button
                    type="button"
                    @click="editor.chain().focus().toggleItalic().run()"
                    :class="[
                        'p-2 rounded hover:bg-gray-700 transition-colors',
                        editor.isActive('italic') ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                    ]"
                    title="Italic"
                >
                    <Italic class="h-4 w-4" />
                </button>

                <template v-if="toolbar === 'full'">
                    <div class="w-px bg-gray-700 mx-1" />

                    <!-- Heading 1 -->
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                        :class="[
                            'p-2 rounded hover:bg-gray-700 transition-colors',
                            editor.isActive('heading', { level: 1 }) ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                        ]"
                        title="Heading 1"
                    >
                        <Heading1 class="h-4 w-4" />
                    </button>

                    <!-- Heading 2 -->
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                        :class="[
                            'p-2 rounded hover:bg-gray-700 transition-colors',
                            editor.isActive('heading', { level: 2 }) ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                        ]"
                        title="Heading 2"
                    >
                        <Heading2 class="h-4 w-4" />
                    </button>

                    <!-- Heading 3 -->
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                        :class="[
                            'p-2 rounded hover:bg-gray-700 transition-colors',
                            editor.isActive('heading', { level: 3 }) ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                        ]"
                        title="Heading 3"
                    >
                        <Heading3 class="h-4 w-4" />
                    </button>

                    <div class="w-px bg-gray-700 mx-1" />

                    <!-- Bullet List -->
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleBulletList().run()"
                        :class="[
                            'p-2 rounded hover:bg-gray-700 transition-colors',
                            editor.isActive('bulletList') ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                        ]"
                        title="Bullet List"
                    >
                        <List class="h-4 w-4" />
                    </button>

                    <!-- Ordered List -->
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleOrderedList().run()"
                        :class="[
                            'p-2 rounded hover:bg-gray-700 transition-colors',
                            editor.isActive('orderedList') ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                        ]"
                        title="Numbered List"
                    >
                        <ListOrdered class="h-4 w-4" />
                    </button>

                    <div class="w-px bg-gray-700 mx-1" />

                    <!-- Blockquote -->
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleBlockquote().run()"
                        :class="[
                            'p-2 rounded hover:bg-gray-700 transition-colors',
                            editor.isActive('blockquote') ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                        ]"
                        title="Blockquote"
                    >
                        <Quote class="h-4 w-4" />
                    </button>

                    <!-- Code Block -->
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleCodeBlock().run()"
                        :class="[
                            'p-2 rounded hover:bg-gray-700 transition-colors',
                            editor.isActive('codeBlock') ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                        ]"
                        title="Code Block"
                    >
                        <Code class="h-4 w-4" />
                    </button>

                    <div class="w-px bg-gray-700 mx-1" />
                </template>

                <!-- Link -->
                <button
                    type="button"
                    @click="addLink"
                    :class="[
                        'p-2 rounded hover:bg-gray-700 transition-colors',
                        editor.isActive('link') ? 'bg-gray-700 text-[#D31C00]' : 'text-gray-400'
                    ]"
                    title="Add Link"
                >
                    <LinkIcon class="h-4 w-4" />
                </button>

                <!-- Image (if media upload enabled) -->
                <button
                    v-if="mediaUpload && toolbar === 'full'"
                    type="button"
                    @click="addImage"
                    class="p-2 rounded hover:bg-gray-700 transition-colors text-gray-400"
                    title="Add Image"
                >
                    <ImageIcon class="h-4 w-4" />
                </button>
            </div>

            <!-- Editor Content -->
            <EditorContent :editor="editor" class="wysiwyg-editor" />
        </div>
    </div>
</template>

<style>
.wysiwyg-editor .ProseMirror {
    min-height: 200px;
    outline: none;
}

.wysiwyg-editor .ProseMirror p.is-editor-empty:first-child::before {
    content: attr(data-placeholder);
    float: left;
    color: #6b7280;
    pointer-events: none;
    height: 0;
}

.wysiwyg-editor .ProseMirror h1 {
    font-size: 2em;
    font-weight: bold;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}

.wysiwyg-editor .ProseMirror h2 {
    font-size: 1.5em;
    font-weight: bold;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}

.wysiwyg-editor .ProseMirror h3 {
    font-size: 1.25em;
    font-weight: bold;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}

.wysiwyg-editor .ProseMirror ul,
.wysiwyg-editor .ProseMirror ol {
    padding-left: 1.5em;
    margin: 0.5em 0;
}

.wysiwyg-editor .ProseMirror blockquote {
    border-left: 4px solid #d31c00;
    padding-left: 1em;
    margin: 1em 0;
    font-style: italic;
    color: #9ca3af;
}

.wysiwyg-editor .ProseMirror pre {
    background: #1f2937;
    border-radius: 0.375rem;
    padding: 0.75rem 1rem;
    margin: 0.5em 0;
}

.wysiwyg-editor .ProseMirror code {
    background: #1f2937;
    border-radius: 0.25rem;
    padding: 0.125rem 0.375rem;
    font-family: 'Courier New', monospace;
    font-size: 0.875em;
}

.wysiwyg-editor .ProseMirror img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    margin: 0.5em 0;
}
</style>
