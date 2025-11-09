<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import {
    Clock,
    ArrowRight,
    Search,
    Filter,
    X,
    Calendar,
    User,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

interface BlogPost {
    id: number;
    title: string;
    slug: string;
    excerpt: string;
    category: string;
    readTime: string;
    author: string;
    publishedAt: string;
    tags: string[];
}

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface Props {
    posts?: BlogPost[];
    categories?: Category[];
}

const props = withDefaults(defineProps<Props>(), {
    posts: () => [],
    categories: () => [],
});

const spotlightPosition = ref({ x: 50, y: 50 });
const smokeParticles = ref<Array<{ id: number; x: number; y: number }>>([]);
let particleId = 0;

const handleMouseMove = (event: MouseEvent) => {
    const target = event.currentTarget as HTMLElement;
    const rect = target.getBoundingClientRect();

    spotlightPosition.value = {
        x: ((event.clientX - rect.left) / rect.width) * 100,
        y: ((event.clientY - rect.top) / rect.height) * 100,
    };

    const particle = {
        id: particleId++,
        x: event.clientX,
        y: event.clientY,
    };
    smokeParticles.value.push(particle);

    setTimeout(() => {
        smokeParticles.value = smokeParticles.value.filter((p) => p.id !== particle.id);
    }, 2000);
};

onMounted(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-out-cubic',
        once: false,
        mirror: true,
        offset: 100,
        delay: 0,
    });
});

const mockCategories: Category[] = [
    { id: 1, name: 'Investment Strategy', slug: 'investment-strategy' },
    { id: 2, name: 'Beginner Guide', slug: 'beginner-guide' },
    { id: 3, name: 'Diaspora', slug: 'diaspora' },
    { id: 4, name: 'Market Insights', slug: 'market-insights' },
    { id: 5, name: 'Legal & Tax', slug: 'legal-tax' },
    { id: 6, name: 'Property Management', slug: 'property-management' },
];

const mockPosts: BlogPost[] = [
    {
        id: 1,
        title: 'Beyond the Hype: Why the Best Investments Begin with Unshakeable Trust',
        slug: 'beyond-the-hype-trust',
        excerpt: 'The excitement fades, and one question takes its place: "How certain am I?" Discover why trust is the foundation of true wealth in real estate.',
        category: 'Investment Strategy',
        readTime: '8 min read',
        author: 'Adebayo Okonkwo',
        publishedAt: 'November 1, 2025',
        tags: ['trust', 'investment', 'strategy'],
    },
    {
        id: 2,
        title: 'The Complete Guide to Site & Services Investment in Abuja',
        slug: 'complete-guide-sites-services',
        excerpt: 'Everything you need to know about purchasing land in Abuja, from verification to construction. A comprehensive walkthrough.',
        category: 'Beginner Guide',
        readTime: '12 min read',
        author: 'Chioma Adeleke',
        publishedAt: 'October 28, 2025',
        tags: ['abuja', 'land', 'guide'],
    },
    {
        id: 3,
        title: 'Diaspora Investment: 5 Common Mistakes to Avoid',
        slug: 'diaspora-mistakes-avoid',
        excerpt: 'Investing from abroad comes with unique challenges. Learn the pitfalls to avoid and strategies that actually work.',
        category: 'Diaspora',
        readTime: '6 min read',
        author: 'Ibrahim Yusuf',
        publishedAt: 'October 25, 2025',
        tags: ['diaspora', 'mistakes', 'tips'],
    },
    {
        id: 4,
        title: 'Understanding Property Appreciation in Nigeria\'s Top Cities',
        slug: 'property-appreciation-nigeria',
        excerpt: 'A data-driven analysis of property value growth in Lagos, Abuja, and Port Harcourt over the past decade.',
        category: 'Market Insights',
        readTime: '10 min read',
        author: 'Adebayo Okonkwo',
        publishedAt: 'October 20, 2025',
        tags: ['appreciation', 'data', 'cities'],
    },
    {
        id: 5,
        title: 'Tax Benefits of Real Estate Investment You Should Know',
        slug: 'tax-benefits-real-estate',
        excerpt: 'Maximize your returns by understanding and leveraging tax advantages available to property investors in Nigeria.',
        category: 'Legal & Tax',
        readTime: '9 min read',
        author: 'Chioma Adeleke',
        publishedAt: 'October 15, 2025',
        tags: ['tax', 'benefits', 'legal'],
    },
    {
        id: 6,
        title: 'Property Management 101: Finding Reliable Tenants',
        slug: 'finding-reliable-tenants',
        excerpt: 'Essential strategies for screening, selecting, and retaining quality tenants for your rental properties.',
        category: 'Property Management',
        readTime: '7 min read',
        author: 'Ibrahim Yusuf',
        publishedAt: 'October 10, 2025',
        tags: ['tenants', 'management', 'rental'],
    },
];

const displayCategories = props.categories.length > 0 ? props.categories : mockCategories;
const allPosts = props.posts.length > 0 ? props.posts : mockPosts;

const selectedCategory = ref<string | null>(null);
const searchQuery = ref('');
const showFilters = ref(false);

const displayPosts = computed(() => {
    let filtered = allPosts;

    if (selectedCategory.value) {
        filtered = filtered.filter((post) => post.category === selectedCategory.value);
    }

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter((post) =>
            post.title.toLowerCase().includes(query) ||
            post.excerpt.toLowerCase().includes(query) ||
            post.tags.some((tag) => tag.toLowerCase().includes(query))
        );
    }

    return filtered;
});

const featuredPost = allPosts[0];

const clearFilters = () => {
    selectedCategory.value = null;
    searchQuery.value = '';
};
</script>

<template>
    <Head title="Blog - Waka Wealth Realty" />

    <div class="overflow-hidden bg-black">
        <!-- Hero Section -->
        <section
            class="relative min-h-[60vh] flex items-center justify-center bg-black overflow-hidden"
            @mousemove="handleMouseMove"
        >
            <div class="smoke-layer-1"></div>
            <div class="smoke-layer-2"></div>
            <div class="smoke-layer-3"></div>

            <div class="snow-container">
                <div v-for="i in 40" :key="i" class="snow-particle"></div>
            </div>

            <div
                class="cursor-spotlight"
                :style="{
                    left: `${spotlightPosition.x}%`,
                    top: `${spotlightPosition.y}%`,
                }"
            ></div>

            <div
                v-for="particle in smokeParticles"
                :key="particle.id"
                class="smoke-particle"
                :style="{
                    left: `${particle.x}px`,
                    top: `${particle.y}px`,
                }"
            ></div>

            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 text-center">
                <div data-aos="fade-up" data-aos-delay="200">
                    <h1 class="mb-6 text-5xl font-bold text-white md:text-6xl">
                        Insights & <span class="text-[#D31C00]">Knowledge</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300 mb-8">
                        Expert articles on real estate investment, market trends, and wealth-building strategies
                    </p>
                </div>
            </div>
        </section>

        <!-- Search & Filter -->
        <section class="bg-gray-900 py-8 sticky top-20 z-40 border-b border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <!-- Search -->
                    <div class="relative flex-1 max-w-md">
                        <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search articles..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-sm bg-gray-800 border border-gray-700 text-white placeholder-gray-400 focus:outline-none focus:border-[#D31C00]"
                        />
                    </div>

                    <!-- Filter & Count -->
                    <div class="flex items-center gap-4">
                        <button
                            @click="showFilters = !showFilters"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-sm bg-gray-800 text-white hover:bg-gray-700 transition"
                        >
                            <Filter class="h-4 w-4" />
                            <span>Categories</span>
                        </button>
                        <button
                            v-if="selectedCategory || searchQuery"
                            @click="clearFilters"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-sm bg-gray-800 text-white hover:bg-gray-700 transition"
                        >
                            <X class="h-4 w-4" />
                            <span>Clear</span>
                        </button>
                        <span class="text-gray-400">
                            {{ displayPosts.length }} {{ displayPosts.length === 1 ? 'article' : 'articles' }}
                        </span>
                    </div>
                </div>

                <!-- Category Filters -->
                <div v-if="showFilters" class="mt-4 pt-4 border-t border-gray-800">
                    <div class="flex flex-wrap gap-2">
                        <button
                            @click="selectedCategory = null"
                            :class="[
                                'px-4 py-2 rounded-full text-sm font-medium transition',
                                selectedCategory === null
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            All Categories
                        </button>
                        <button
                            v-for="category in displayCategories"
                            :key="category.id"
                            @click="selectedCategory = category.name"
                            :class="[
                                'px-4 py-2 rounded-full text-sm font-medium transition',
                                selectedCategory === category.name
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            {{ category.name }}
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Post -->
        <section class="bg-black py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-white">Featured Article</h2>
                </div>

                <Link
                    :href="`/blog/${featuredPost.slug}`"
                    class="group block rounded-2xl border border-gray-800 bg-gray-900 overflow-hidden transition-all hover:border-[#D31C00]"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="relative h-64 lg:h-auto bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                        </div>

                        <div class="p-8 lg:p-12">
                            <div class="mb-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#D31C00] text-white">
                                    {{ featuredPost.category }}
                                </span>
                            </div>
                            <h3 class="mb-4 text-3xl font-bold text-white group-hover:text-[#D31C00] transition-colors leading-tight">
                                {{ featuredPost.title }}
                            </h3>
                            <p class="text-gray-400 text-lg leading-relaxed mb-6">
                                {{ featuredPost.excerpt }}
                            </p>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                                <div class="flex items-center gap-2">
                                    <User class="h-4 w-4" />
                                    <span>{{ featuredPost.author }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Calendar class="h-4 w-4" />
                                    <span>{{ featuredPost.publishedAt }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Clock class="h-4 w-4" />
                                    <span>{{ featuredPost.readTime }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </section>

        <!-- Blog Posts Grid -->
        <section class="bg-gray-900 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div v-if="displayPosts.length === 0" class="text-center py-16">
                    <p class="text-xl text-gray-400">No articles found matching your criteria.</p>
                    <button
                        @click="clearFilters"
                        class="mt-6 inline-flex items-center gap-2 px-6 py-3 rounded-sm bg-[#D31C00] text-white hover:bg-[#B01700] transition"
                    >
                        Clear Filters
                    </button>
                </div>

                <div v-else class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="(post, index) in displayPosts.slice(1)"
                        :key="post.id"
                        :href="`/blog/${post.slug}`"
                        class="group rounded-2xl border border-gray-800 bg-black overflow-hidden transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 50)"
                    >
                        <div class="relative h-48 bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#D31C00] text-white">
                                    {{ post.category }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="mb-3 text-xl font-bold text-white group-hover:text-[#D31C00] transition-colors leading-tight">
                                {{ post.title }}
                            </h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                                {{ post.excerpt }}
                            </p>
                            <div class="flex items-center justify-between text-xs text-gray-400 mb-4">
                                <div class="flex items-center gap-2">
                                    <Clock class="h-3 w-3" />
                                    <span>{{ post.readTime }}</span>
                                </div>
                                <span>{{ post.publishedAt }}</span>
                            </div>
                            <div class="flex items-center text-[#D31C00] font-semibold text-sm">
                                <span>Read More</span>
                                <ArrowRight class="h-4 w-4 ml-2 transition-transform group-hover:translate-x-2" />
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Newsletter CTA -->
        <section class="relative overflow-hidden bg-gradient-to-br from-[#D31C00] to-[#B01700] py-20">
            <div class="absolute inset-0 bg-black/20" />
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/5" />
            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-white/5" />

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl" data-aos="fade-up">
                        Stay Informed
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Get the latest insights delivered to your inbox every week
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact?type=newsletter"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Subscribe to Newsletter</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.smoke-layer-1,
.smoke-layer-2,
.smoke-layer-3 {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.smoke-layer-1 {
    background: radial-gradient(circle at 20% 30%, rgba(200, 210, 220, 0.6) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(210, 220, 230, 0.6) 0%, transparent 50%);
    animation: smokeFloat1 28s ease-in-out infinite;
}

.smoke-layer-2 {
    background: radial-gradient(circle at 60% 20%, rgba(190, 200, 210, 0.6) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(200, 210, 220, 0.6) 0%, transparent 50%);
    animation: smokeFloat2 32s ease-in-out infinite;
    animation-delay: -8s;
}

.smoke-layer-3 {
    background: radial-gradient(circle at 50% 50%, rgba(180, 190, 200, 0.6) 0%, transparent 50%),
        radial-gradient(circle at 90% 40%, rgba(210, 220, 230, 0.6) 0%, transparent 50%);
    animation: smokeFloat3 22s ease-in-out infinite;
    animation-delay: -16s;
}

@keyframes smokeFloat1 {
    0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1) skewX(0deg); opacity: 0.6; }
    25% { transform: translate(-12%, 8%) rotate(25deg) scale(1.2) skewX(5deg); opacity: 0.75; }
    50% { transform: translate(5%, -10%) rotate(-15deg) scale(1.1) skewX(-8deg); opacity: 0.65; }
    75% { transform: translate(13%, 6%) rotate(30deg) scale(1.15) skewX(12deg); opacity: 0.7; }
}

@keyframes smokeFloat2 {
    0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1) skewY(0deg); opacity: 0.6; }
    30% { transform: translate(10%, -12%) rotate(-20deg) scale(1.25) skewY(-10deg); opacity: 0.8; }
    60% { transform: translate(-8%, 10%) rotate(28deg) scale(1.05) skewY(15deg); opacity: 0.7; }
    90% { transform: translate(6%, -5%) rotate(-12deg) scale(1.2) skewY(-5deg); opacity: 0.75; }
}

@keyframes smokeFloat3 {
    0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1) skewX(0deg) skewY(0deg); opacity: 0.6; }
    20% { transform: translate(-15%, 12%) rotate(38deg) scale(1.3) skewX(18deg) skewY(8deg); opacity: 0.85; }
    40% { transform: translate(8%, -15%) rotate(-25deg) scale(0.95) skewX(-12deg) skewY(-10deg); opacity: 0.65; }
    70% { transform: translate(12%, 8%) rotate(32deg) scale(1.15) skewX(15deg) skewY(12deg); opacity: 0.75; }
}

.cursor-spotlight {
    position: absolute;
    width: 600px;
    height: 600px;
    margin-left: -300px;
    margin-top: -300px;
    pointer-events: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 20%, transparent 50%),
        radial-gradient(circle, rgba(211, 28, 0, 0.2) 0%, rgba(211, 28, 0, 0.1) 30%, transparent 60%);
    filter: blur(40px);
}

.smoke-particle {
    position: fixed;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200, 210, 220, 0.9) 0%, rgba(210, 220, 230, 0.7) 30%, transparent 70%);
    pointer-events: none;
    animation: smokeParticleFade 2s ease-out forwards;
    filter: blur(35px);
    transform: translate(-50%, -50%);
    z-index: 1;
}

@keyframes smokeParticleFade {
    0% { opacity: 0.9; transform: translate(-50%, -50%) scale(0.5); }
    50% { opacity: 0.6; transform: translate(-50%, -50%) scale(1); }
    100% { opacity: 0; transform: translate(-50%, -50%) scale(1.2); }
}

.snow-container {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
}

.snow-particle {
    position: absolute;
    top: -10px;
    background: white;
    border-radius: 50%;
    opacity: 0;
    animation: snowFall linear infinite;
}

.snow-particle:nth-child(odd) { width: 4px; height: 4px; }
.snow-particle:nth-child(even) { width: 6px; height: 6px; }
.snow-particle:nth-child(3n) { width: 2px; height: 2px; }

@keyframes snowFall {
    0% { opacity: 0; transform: translateY(0) translateX(0) rotate(0deg); }
    10% { opacity: 0.5; }
    90% { opacity: 0.5; }
    100% { opacity: 0; transform: translateY(100vh) translateX(50px) rotate(360deg); }
}

.snow-particle:nth-child(1) { left: 5%; animation-duration: 12s; animation-delay: 0s; }
.snow-particle:nth-child(2) { left: 15%; animation-duration: 10s; animation-delay: 2s; }
.snow-particle:nth-child(3) { left: 25%; animation-duration: 14s; animation-delay: 4s; }
.snow-particle:nth-child(4) { left: 35%; animation-duration: 11s; animation-delay: 1s; }
.snow-particle:nth-child(5) { left: 45%; animation-duration: 13s; animation-delay: 3s; }
.snow-particle:nth-child(6) { left: 55%; animation-duration: 9s; animation-delay: 5s; }
.snow-particle:nth-child(7) { left: 65%; animation-duration: 15s; animation-delay: 2s; }
.snow-particle:nth-child(8) { left: 75%; animation-duration: 12s; animation-delay: 4s; }
.snow-particle:nth-child(9) { left: 85%; animation-duration: 10s; animation-delay: 1s; }
.snow-particle:nth-child(10) { left: 95%; animation-duration: 13s; animation-delay: 3s; }
</style>
