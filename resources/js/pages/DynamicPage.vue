<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

interface Page {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    content: Record<string, any>;
}

interface Props {
    page: Page;
}

const props = defineProps<Props>();

// Helper to render content based on field type
const renderContent = (content: Record<string, any>) => {
    return content;
};
</script>

<template>
    <div>
        <Head>
            <title>{{ page.title }}</title>
            <meta
                v-if="page.description"
                name="description"
                :content="page.description"
            />
        </Head>

        <div class="min-h-screen bg-background">
            <!-- Page Header -->
            <div class="bg-primary text-primary-foreground py-12">
                <div class="container mx-auto px-4">
                    <h1 class="text-4xl font-bold">{{ page.title }}</h1>
                    <p v-if="page.description" class="mt-2 text-lg opacity-90">
                        {{ page.description }}
                    </p>
                </div>
            </div>

            <!-- Page Content -->
            <div class="container mx-auto px-4 py-12">
                <div class="prose prose-lg max-w-none">
                    <!-- Render dynamic content -->
                    <div
                        v-for="(value, key) in page.content"
                        :key="key"
                        class="mb-6"
                    >
                        <!-- Text content -->
                        <div v-if="typeof value === 'string' && value" class="whitespace-pre-wrap">
                            {{ value }}
                        </div>

                        <!-- Array content (for repeaters, etc.) -->
                        <div v-else-if="Array.isArray(value)" class="space-y-4">
                            <div
                                v-for="(item, index) in value"
                                :key="index"
                                class="p-4 border rounded-lg"
                            >
                                <pre class="text-sm">{{ item }}</pre>
                            </div>
                        </div>

                        <!-- Object content -->
                        <div v-else-if="typeof value === 'object' && value !== null">
                            <pre class="text-sm bg-muted p-4 rounded">{{ value }}</pre>
                        </div>
                    </div>

                    <!-- Fallback if no content -->
                    <div
                        v-if="Object.keys(page.content).length === 0"
                        class="text-center text-muted-foreground py-12"
                    >
                        <p>This page has no content yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
