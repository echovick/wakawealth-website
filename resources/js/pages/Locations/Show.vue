<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { MapPin, Home, Tag } from 'lucide-vue-next';

defineOptions({ layout: MarketingLayout });

interface Category {
    id: number;
    name: string;
    slug: string;
    description: string | null;
}

interface PostType {
    id: number;
    title: string;
}

interface Property {
    id: number;
    title: string;
    slug: string;
    post_type_id: number;
    published_at: string | null;
    post_type: PostType;
    categories: Category[];
}

interface Props {
    location: Category;
    properties: {
        data: Property[];
        links: any;
        meta: any;
    };
}

const props = defineProps<Props>();
</script>

<template>
    <Head :title="`${location.name} - Properties & Investments | Waka Wealth`" />

    <div class="min-h-screen bg-black">
        <!-- Header Section -->
        <section class="relative bg-gradient-to-br from-gray-900 to-black py-20">
            <div class="absolute inset-0 bg-grid-white/[0.02]" />
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="mb-8 flex items-center space-x-2 text-sm text-gray-400">
                    <Link href="/" class="hover:text-white transition-colors">Home</Link>
                    <span>/</span>
                    <Link href="/locations" class="hover:text-white transition-colors">Locations</Link>
                    <span>/</span>
                    <span class="text-white">{{ location.name }}</span>
                </nav>

                <!-- Location Header -->
                <div class="flex items-start gap-4">
                    <div class="rounded-full bg-[#D31C00]/20 p-4">
                        <MapPin class="h-8 w-8 text-[#D31C00]" />
                    </div>
                    <div>
                        <h1 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                            {{ location.name }}
                        </h1>
                        <p v-if="location.description" class="text-lg text-gray-400 max-w-3xl">
                            {{ location.description }}
                        </p>
                        <div class="mt-4 flex items-center gap-2 text-gray-400">
                            <Home class="h-5 w-5" />
                            <span>{{ properties.meta?.total || 0 }} {{ (properties.meta?.total || 0) === 1 ? 'Property' : 'Properties' }} Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Properties Grid -->
        <section class="py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Empty State -->
                <div
                    v-if="properties.data.length === 0"
                    class="flex flex-col items-center justify-center rounded-2xl border border-gray-800 bg-gray-900 py-20 text-center"
                >
                    <MapPin class="mb-4 h-16 w-16 text-gray-600" />
                    <h3 class="mb-2 text-xl font-semibold text-white">No Properties Yet</h3>
                    <p class="mb-6 text-gray-400">
                        We don't have any properties listed in {{ location.name }} at the moment.
                    </p>
                    <Link
                        href="/locations"
                        class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-[#B01700]"
                    >
                        <span>View All Locations</span>
                    </Link>
                </div>

                <!-- Properties Grid -->
                <div v-else class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="property in properties.data"
                        :key="property.id"
                        :href="`/properties/${property.slug}`"
                        class="group rounded-2xl border border-gray-800 bg-gray-900 overflow-hidden transition-all hover:border-[#D31C00] hover:shadow-lg hover:shadow-[#D31C00]/20"
                    >
                        <!-- Image Placeholder -->
                        <div class="aspect-[4/3] bg-gradient-to-br from-gray-800 to-gray-700">
                            <!-- Property image would go here -->
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="mb-3 flex items-center gap-2">
                                <span class="rounded-full bg-[#D31C00]/20 px-3 py-1 text-xs font-semibold text-[#D31C00]">
                                    {{ property.post_type.title }}
                                </span>
                                <span
                                    v-if="property.published_at"
                                    class="rounded-full bg-green-500/20 px-3 py-1 text-xs font-semibold text-green-400"
                                >
                                    Available
                                </span>
                                <span
                                    v-else
                                    class="rounded-full bg-gray-500/20 px-3 py-1 text-xs font-semibold text-gray-400"
                                >
                                    Coming Soon
                                </span>
                            </div>

                            <h3 class="mb-2 text-xl font-bold text-white group-hover:text-[#D31C00] transition-colors">
                                {{ property.title }}
                            </h3>

                            <div class="flex items-center gap-2 text-sm text-gray-400">
                                <MapPin class="h-4 w-4" />
                                <span>{{ location.name }}</span>
                            </div>

                            <!-- Additional Categories -->
                            <div v-if="property.categories.length > 1" class="mt-3 flex flex-wrap gap-2">
                                <span
                                    v-for="cat in property.categories.filter(c => c.id !== location.id)"
                                    :key="cat.id"
                                    class="inline-flex items-center gap-1 rounded-full bg-gray-800 px-2 py-1 text-xs text-gray-400"
                                >
                                    <Tag class="h-3 w-3" />
                                    {{ cat.name }}
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Pagination -->
                <div v-if="properties.meta?.last_page > 1" class="mt-12 flex justify-center gap-2">
                    <Link
                        v-for="(link, index) in properties.links || []"
                        :key="index"
                        :href="link.url || '#'"
                        :class="[
                            'px-4 py-2 rounded transition-colors',
                            link.active
                                ? 'bg-[#D31C00] text-white'
                                : link.url
                                    ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                    : 'bg-gray-800 text-gray-600 cursor-not-allowed',
                        ]"
                        :disabled="!link.url"
                        v-html="link.label"
                    />
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.bg-grid-white\/\[0\.02\] {
    background-image: linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
    background-size: 64px 64px;
}
</style>
