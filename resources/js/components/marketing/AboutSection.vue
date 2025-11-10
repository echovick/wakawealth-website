<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';

interface AboutSection {
    label: string;
    title: string;
    content: string;
    featured_images: Array<{ images: string }>;
    core_value_items: Array<{ value_item: string }>;
    core_values_snippet: string;
    stats: {
        count: string;
        metric: string;
    };
    cta_text?: string;
    cta_url?: string;
}

interface Props {
    about?: AboutSection;
}

const props = withDefaults(defineProps<Props>(), {
    about: () => ({
        label: 'Origin & Philosophy',
        title: 'What does Waka mean?',
        content: '<p><strong>"Waka"</strong> means to walk, to move, to journey forward in West African pidgin English, while <strong>"Wealth"</strong> represents the prosperity, security, and generational legacy that every family deserves.</p><p>The word "waka" resonates with millions across Nigeria, Ghana, and the broader West African diaspora—it\'s a word that feels like home. It\'s <strong>informal, approachable, and warm</strong>, yet carries the weight of determination and hustle.</p><p>We believe that building wealth through real estate and smart investments isn\'t about sudden windfalls or shortcuts. It\'s about taking <strong>intentional steps</strong>, making <strong>informed decisions</strong>, and moving forward with purpose—one property, one investment, one milestone at a time.</p>',
        featured_images: [],
        core_value_items: [
            { value_item: 'Stability for your family' },
            { value_item: 'Legacy for your children' },
            { value_item: 'Status in your community' },
            { value_item: 'Freedom from financial uncertainty' },
        ],
        core_values_snippet: 'In African communities, real estate represents more than just property—it\'s a symbol of:',
        stats: {
            count: '10+',
            metric: 'Years Building<br />Legacies',
        },
        cta_text: 'Learn Our Story',
        cta_url: '/about',
    }),
});

// Parse title to highlight "Waka" in red
const titleParts = computed(() => {
    const title = props.about.title;
    const match = title.match(/(.*)Waka(.*)/i);
    if (match) {
        return { before: match[1].trim(), highlight: 'Waka', after: match[2].trim() };
    }
    return { before: title, highlight: '', after: '' };
});
</script>

<template>
    <section class="bg-gray-900 py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
                <!-- Text Content -->
                <div data-aos="fade-right" data-aos-delay="100">
                    <div class="mb-4 inline-block">
                        <span
                            class="rounded-full bg-[#D31C00]/20 px-4 py-1.5 text-sm font-semibold text-[#D31C00]"
                        >
                            {{ about.label }}
                        </span>
                    </div>
                    <h2 class="mb-6 text-4xl font-bold text-white md:text-5xl">
                        <template v-if="titleParts.before">{{ titleParts.before }}</template>
                        <span v-if="titleParts.highlight" class="text-[#D31C00]">{{ titleParts.highlight }}</span>
                        <template v-if="titleParts.after">{{ titleParts.after }}</template>
                    </h2>
                    <div class="space-y-4 text-lg leading-relaxed text-gray-300 prose prose-invert max-w-none" v-html="about.content"></div>

                    <!-- Cultural Values -->
                    <div class="mt-8 rounded-2xl bg-gray-800 p-6 shadow-sm border border-gray-700">
                        <h3 class="mb-4 text-lg font-semibold text-white">
                            {{ about.core_values_snippet }}
                        </h3>
                        <ul class="space-y-3">
                            <li
                                v-for="(item, index) in about.core_value_items"
                                :key="index"
                                class="flex items-start"
                            >
                                <span
                                    class="mr-3 mt-1 h-5 w-5 flex-shrink-0 rounded-full bg-[#D31C00]/20 p-1"
                                >
                                    <svg
                                        class="h-full w-full text-[#D31C00]"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                                <span class="text-gray-300">{{ item.value_item }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-8">
                        <Link
                            :href="about.cta_url || '/about'"
                            class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-[#B01700]"
                        >
                            <span>{{ about.cta_text || 'Learn Our Story' }}</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                    </div>
                </div>

                <!-- Image Grid -->
                <div class="relative" data-aos="fade-left" data-aos-delay="200">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div
                                class="aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800 to-gray-700"
                            >
                                <img
                                    v-if="about.featured_images[0]?.images"
                                    :src="about.featured_images[0].images"
                                    alt=""
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div
                                class="aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800"
                            >
                                <img
                                    v-if="about.featured_images[1]?.images"
                                    :src="about.featured_images[1].images"
                                    alt=""
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                        <div class="mt-8 space-y-4">
                            <div
                                class="aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800 to-gray-700"
                            >
                                <img
                                    v-if="about.featured_images[2]?.images"
                                    :src="about.featured_images[2].images"
                                    alt=""
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div
                                class="aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800"
                            >
                                <img
                                    v-if="about.featured_images[3]?.images"
                                    :src="about.featured_images[3].images"
                                    alt=""
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div
                        class="absolute -bottom-4 -left-4 rounded-2xl bg-black border border-gray-800 p-6 shadow-xl"
                    >
                        <div class="text-center">
                            <div class="text-4xl font-bold text-[#D31C00]">{{ about.stats.count }}</div>
                            <div class="text-sm font-medium text-gray-400" v-html="about.stats.metric"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
