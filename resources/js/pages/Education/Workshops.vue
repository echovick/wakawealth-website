<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import {
    Calendar,
    Clock,
    Video,
    MapPin,
    Users,
    CheckCircle2,
    ArrowRight,
    Filter,
    X,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

interface Workshop {
    id: number;
    title: string;
    slug: string;
    description: string;
    date: string;
    time: string;
    duration: string;
    format: string;
    seatsAvailable: number;
    isFree: boolean;
    status: 'upcoming' | 'past';
    category: 'beginner' | 'intermediate' | 'advanced';
    topics: string[];
}

interface Props {
    workshops?: Workshop[];
}

const props = withDefaults(defineProps<Props>(), {
    workshops: () => [],
});

// Smoke effect state
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

// Mock data for demonstration
const mockWorkshops: Workshop[] = [
    {
        id: 1,
        title: 'Real Estate Investment 101: Getting Started',
        slug: 'real-estate-investment-101',
        description: 'Learn the fundamentals of real estate investment, from understanding market dynamics to making your first purchase.',
        date: 'November 15, 2025',
        time: '6:00 PM - 8:00 PM WAT',
        duration: '2 hours',
        format: 'Virtual (Zoom)',
        seatsAvailable: 45,
        isFree: true,
        status: 'upcoming',
        category: 'beginner',
        topics: ['Understanding the market', 'Financing basics', 'First steps to ownership', 'Legal requirements'],
    },
    {
        id: 2,
        title: 'Diaspora Investment: Building Back Home',
        slug: 'diaspora-investment-building-back-home',
        description: 'Specialized workshop for Nigerians abroad looking to invest in real estate back home. Learn remote investment strategies.',
        date: 'November 22, 2025',
        time: '3:00 PM - 5:00 PM GMT',
        duration: '2 hours',
        format: 'Virtual (Zoom)',
        seatsAvailable: 32,
        isFree: true,
        status: 'upcoming',
        category: 'intermediate',
        topics: ['Remote investment strategies', 'Legal considerations', 'Managing from abroad', 'Trusted partners'],
    },
    {
        id: 3,
        title: 'Portfolio Optimization Masterclass',
        slug: 'portfolio-optimization-masterclass',
        description: 'Advanced strategies for maximizing returns and building lasting wealth through strategic property portfolio management.',
        date: 'December 1, 2025',
        time: '10:00 AM - 1:00 PM WAT',
        duration: '3 hours',
        format: 'In-Person (Abuja Office)',
        seatsAvailable: 15,
        isFree: false,
        status: 'upcoming',
        category: 'advanced',
        topics: ['Advanced strategies', 'Tax optimization', 'Wealth transfer planning', 'Market timing'],
    },
    {
        id: 4,
        title: 'Understanding Property Valuation',
        slug: 'understanding-property-valuation',
        description: 'Master the art and science of property valuation to make informed investment decisions.',
        date: 'October 15, 2025',
        time: '5:00 PM - 7:00 PM WAT',
        duration: '2 hours',
        format: 'Virtual (Zoom)',
        seatsAvailable: 0,
        isFree: true,
        status: 'past',
        category: 'intermediate',
        topics: ['Valuation methods', 'Market analysis', 'Comparative approach', 'Investment returns'],
    },
];

const displayWorkshops = computed(() => {
    const allWorkshops = props.workshops.length > 0 ? props.workshops : mockWorkshops;

    let filtered = allWorkshops.filter((workshop) => {
        const statusMatch = selectedTab.value === 'all' || workshop.status === selectedTab.value;
        const categoryMatch = selectedCategory.value === 'all' || workshop.category === selectedCategory.value;
        return statusMatch && categoryMatch;
    });

    return filtered;
});

const selectedTab = ref<'upcoming' | 'past' | 'all'>('upcoming');
const selectedCategory = ref<'all' | 'beginner' | 'intermediate' | 'advanced'>('all');
const showFilters = ref(false);

const stats = [
    { number: '50+', label: 'Workshops Conducted' },
    { number: '2,000+', label: 'Students Educated' },
    { number: '95%', label: 'Satisfaction Rate' },
    { number: '4.9/5', label: 'Average Rating' },
];

const clearFilters = () => {
    selectedCategory.value = 'all';
};
</script>

<template>
    <Head title="Workshops - Waka Wealth Realty" />

    <div class="overflow-hidden bg-black">
        <!-- Hero Section with Smoke Effect -->
        <section
            class="relative min-h-[60vh] flex items-center justify-center bg-black overflow-hidden"
            @mousemove="handleMouseMove"
        >
            <!-- Ambient Smoke Layers -->
            <div class="smoke-layer-1"></div>
            <div class="smoke-layer-2"></div>
            <div class="smoke-layer-3"></div>

            <!-- Snow/Dust Particles -->
            <div class="snow-container">
                <div v-for="i in 40" :key="i" class="snow-particle"></div>
            </div>

            <!-- Cursor Spotlight -->
            <div
                class="cursor-spotlight"
                :style="{
                    left: `${spotlightPosition.x}%`,
                    top: `${spotlightPosition.y}%`,
                }"
            ></div>

            <!-- Smoke Trail Particles -->
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
                        "Waka to Wealth" <span class="text-[#D31C00]">Workshops</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300 mb-8">
                        Free monthly educational workshops designed to empower you with knowledge and confidence
                    </p>
                    <Link
                        href="/contact?type=workshop"
                        class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 font-semibold text-white transition-colors hover:bg-[#B01700]"
                    >
                        <span>Register for Next Workshop</span>
                        <ArrowRight class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="bg-gray-900 py-12 border-b border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                    <div
                        v-for="(stat, index) in stats"
                        :key="index"
                        class="text-center"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="text-4xl font-bold text-[#D31C00]">{{ stat.number }}</div>
                        <div class="mt-1 text-sm font-medium text-gray-400">{{ stat.label }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="bg-gray-900 py-8 sticky top-20 z-40 border-b border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <!-- Status Tabs -->
                    <div class="flex gap-2">
                        <button
                            @click="selectedTab = 'all'"
                            :class="[
                                'px-6 py-2.5 rounded-sm font-semibold transition',
                                selectedTab === 'all'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            All
                        </button>
                        <button
                            @click="selectedTab = 'upcoming'"
                            :class="[
                                'px-6 py-2.5 rounded-sm font-semibold transition',
                                selectedTab === 'upcoming'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            Upcoming
                        </button>
                        <button
                            @click="selectedTab = 'past'"
                            :class="[
                                'px-6 py-2.5 rounded-sm font-semibold transition',
                                selectedTab === 'past'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            Past
                        </button>
                    </div>

                    <!-- Filter Toggle & Clear -->
                    <div class="flex items-center gap-4">
                        <button
                            @click="showFilters = !showFilters"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-sm bg-gray-800 text-white hover:bg-gray-700 transition"
                        >
                            <Filter class="h-4 w-4" />
                            <span>Filter by Level</span>
                        </button>
                        <button
                            v-if="selectedCategory !== 'all'"
                            @click="clearFilters"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-sm bg-gray-800 text-white hover:bg-gray-700 transition"
                        >
                            <X class="h-4 w-4" />
                            <span>Clear</span>
                        </button>
                        <span class="text-gray-400">
                            {{ displayWorkshops.length }} {{ displayWorkshops.length === 1 ? 'workshop' : 'workshops' }}
                        </span>
                    </div>
                </div>

                <!-- Category Filters -->
                <div v-if="showFilters" class="mt-4 pt-4 border-t border-gray-800">
                    <div class="flex flex-wrap gap-2">
                        <button
                            @click="selectedCategory = 'all'"
                            :class="[
                                'px-4 py-2 rounded-full text-sm font-medium transition',
                                selectedCategory === 'all'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            All Levels
                        </button>
                        <button
                            @click="selectedCategory = 'beginner'"
                            :class="[
                                'px-4 py-2 rounded-full text-sm font-medium transition',
                                selectedCategory === 'beginner'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            Beginner
                        </button>
                        <button
                            @click="selectedCategory = 'intermediate'"
                            :class="[
                                'px-4 py-2 rounded-full text-sm font-medium transition',
                                selectedCategory === 'intermediate'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            Intermediate
                        </button>
                        <button
                            @click="selectedCategory = 'advanced'"
                            :class="[
                                'px-4 py-2 rounded-full text-sm font-medium transition',
                                selectedCategory === 'advanced'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            Advanced
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Workshops Grid -->
        <section class="bg-black py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div v-if="displayWorkshops.length === 0" class="text-center py-16">
                    <p class="text-xl text-gray-400">No workshops found matching your criteria.</p>
                    <button
                        @click="clearFilters(); selectedTab = 'all'"
                        class="mt-6 inline-flex items-center gap-2 px-6 py-3 rounded-sm bg-[#D31C00] text-white hover:bg-[#B01700] transition"
                    >
                        Clear All Filters
                    </button>
                </div>

                <div v-else class="grid grid-cols-1 gap-8 lg:grid-cols-2 xl:grid-cols-3">
                    <div
                        v-for="(workshop, index) in displayWorkshops"
                        :key="workshop.id"
                        class="rounded-2xl border border-gray-800 bg-gray-900 overflow-hidden transition-all hover:border-[#D31C00]"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 50)"
                    >
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex gap-2">
                                    <div
                                        v-if="workshop.isFree"
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400"
                                    >
                                        FREE
                                    </div>
                                    <div
                                        v-else
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-[#D31C00]/20 text-[#D31C00]"
                                    >
                                        PREMIUM
                                    </div>
                                    <div
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400 capitalize"
                                    >
                                        {{ workshop.category }}
                                    </div>
                                </div>
                                <div
                                    v-if="workshop.status === 'upcoming'"
                                    class="text-xs font-medium text-gray-400"
                                >
                                    {{ workshop.seatsAvailable }} seats left
                                </div>
                            </div>

                            <h3 class="mb-4 text-xl font-bold text-white leading-tight">
                                {{ workshop.title }}
                            </h3>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <Calendar class="h-4 w-4 text-[#D31C00]" />
                                    <span>{{ workshop.date }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <Clock class="h-4 w-4 text-[#D31C00]" />
                                    <span>{{ workshop.time }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <Video class="h-4 w-4 text-[#D31C00]" />
                                    <span>{{ workshop.format }}</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-xs font-semibold text-gray-400 mb-2">TOPICS COVERED:</h4>
                                <ul class="space-y-1">
                                    <li
                                        v-for="(topic, idx) in workshop.topics.slice(0, 3)"
                                        :key="idx"
                                        class="text-sm text-gray-300 flex items-start gap-2"
                                    >
                                        <span class="text-[#D31C00] mt-1">•</span>
                                        <span>{{ topic }}</span>
                                    </li>
                                    <li v-if="workshop.topics.length > 3" class="text-sm text-gray-400">
                                        +{{ workshop.topics.length - 3 }} more topics
                                    </li>
                                </ul>
                            </div>

                            <Link
                                :href="`/education/workshops/${workshop.slug}`"
                                class="w-full flex items-center justify-center space-x-2 rounded-sm bg-black border border-gray-700 px-6 py-3 font-semibold text-white transition-colors hover:bg-[#D31C00] hover:border-[#D31C00]"
                            >
                                <span>{{ workshop.status === 'upcoming' ? 'Register Now' : 'View Details' }}</span>
                                <ArrowRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-[#D31C00] to-[#B01700] py-20">
            <div class="absolute inset-0 bg-black/20" />
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/5" />
            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-white/5" />

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl" data-aos="fade-up">
                        Ready to Start Learning?
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Join thousands of successful investors who started their journey with our workshops
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact?type=workshop"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Register for Workshop</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/education/learning-paths"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>View Learning Paths</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
/* Smoke effect styles */
.smoke-layer-1,
.smoke-layer-2,
.smoke-layer-3 {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.smoke-layer-1 {
    background: radial-gradient(
            circle at 20% 30%,
            rgba(200, 210, 220, 0.6) 0%,
            transparent 50%
        ),
        radial-gradient(circle at 80% 70%, rgba(210, 220, 230, 0.6) 0%, transparent 50%);
    animation: smokeFloat1 28s ease-in-out infinite;
}

.smoke-layer-2 {
    background: radial-gradient(
            circle at 60% 20%,
            rgba(190, 200, 210, 0.6) 0%,
            transparent 50%
        ),
        radial-gradient(circle at 40% 80%, rgba(200, 210, 220, 0.6) 0%, transparent 50%);
    animation: smokeFloat2 32s ease-in-out infinite;
    animation-delay: -8s;
}

.smoke-layer-3 {
    background: radial-gradient(
            circle at 50% 50%,
            rgba(180, 190, 200, 0.6) 0%,
            transparent 50%
        ),
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

