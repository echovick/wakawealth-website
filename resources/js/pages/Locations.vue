<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { MapPin, Home, Building2, TrendingUp, ArrowRight } from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

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

const activeTab = ref<'sites' | 'homes'>('sites');

const siteLocations = [
    {
        name: 'Wuye',
        slug: 'wuye',
        propertyCount: 45,
        description: 'Prime location with excellent infrastructure and accessibility',
        highlights: ['Central Location', 'Well Developed', 'High Appreciation'],
    },
    {
        name: 'Kukwaba',
        slug: 'kukwaba',
        propertyCount: 38,
        description: 'Emerging area with great investment potential',
        highlights: ['Affordable', 'Growing Area', 'Good Access'],
    },
    {
        name: 'Katampe',
        slug: 'katampe',
        propertyCount: 42,
        description: 'Strategic location near major city centers',
        highlights: ['Strategic', 'Infrastructure', 'Investment Hub'],
    },
    {
        name: 'Lifecamp',
        slug: 'lifecamp',
        propertyCount: 52,
        description: 'Established residential area with modern amenities',
        highlights: ['Established', 'Modern', 'Family Friendly'],
    },
    {
        name: 'Karsana',
        slug: 'karsana',
        propertyCount: 35,
        description: 'Peaceful environment with excellent growth prospects',
        highlights: ['Peaceful', 'Growing', 'Affordable'],
    },
    {
        name: 'Kabusa',
        slug: 'kabusa',
        propertyCount: 28,
        description: 'Developing area with good road networks',
        highlights: ['Developing', 'Good Roads', 'Potential'],
    },
    {
        name: 'Apo-Wasa',
        slug: 'apo-wasa',
        propertyCount: 31,
        description: 'Well-planned estate with organized layout',
        highlights: ['Organized', 'Estate', 'Secure'],
    },
    {
        name: 'Idu',
        slug: 'idu',
        propertyCount: 40,
        description: 'Industrial and commercial hub with mixed-use potential',
        highlights: ['Commercial', 'Industrial', 'Mixed-Use'],
    },
    {
        name: 'Lugbe',
        slug: 'lugbe',
        propertyCount: 48,
        description: 'Popular location near airport with diverse options',
        highlights: ['Near Airport', 'Popular', 'Diverse'],
    },
    {
        name: 'Kyami',
        slug: 'kyami',
        propertyCount: 25,
        description: 'Budget-friendly location with expanding infrastructure',
        highlights: ['Budget Friendly', 'Expanding', 'Accessible'],
    },
    {
        name: 'Gwagwalada',
        slug: 'gwagwalada',
        propertyCount: 33,
        description: 'Educational hub with university presence',
        highlights: ['Educational', 'University Area', 'Growing'],
    },
];

const homeLocations = [
    {
        name: 'Wuye',
        slug: 'wuye',
        propertyCount: 24,
        description: 'Luxury homes in prime central location',
        highlights: ['Luxury', 'Central', 'Premium'],
    },
    {
        name: 'Lifecamp',
        slug: 'lifecamp',
        propertyCount: 32,
        description: 'Modern homes with excellent amenities',
        highlights: ['Modern', 'Amenities', 'Established'],
    },
    {
        name: 'Guzape',
        slug: 'guzape',
        propertyCount: 18,
        description: 'Exclusive residential area for high-end homes',
        highlights: ['Exclusive', 'High-End', 'Prestigious'],
    },
    {
        name: 'Gaduwa',
        slug: 'gaduwa',
        propertyCount: 28,
        description: 'Family-friendly neighborhood with great facilities',
        highlights: ['Family Friendly', 'Facilities', 'Safe'],
    },
    {
        name: 'Kaura',
        slug: 'kaura',
        propertyCount: 15,
        description: 'Serene environment with quality housing',
        highlights: ['Serene', 'Quality', 'Peaceful'],
    },
    {
        name: 'Idu',
        slug: 'idu',
        propertyCount: 22,
        description: 'Mixed residential and commercial properties',
        highlights: ['Mixed-Use', 'Strategic', 'Investment'],
    },
];

const displayLocations = computed(() => {
    return activeTab.value === 'sites' ? siteLocations : homeLocations;
});

const stats = [
    { number: '11', label: 'Site Locations', icon: Building2 },
    { number: '6', label: 'Home Locations', icon: Home },
    { number: '450+', label: 'Properties', icon: MapPin },
    { number: '15%', label: 'Avg. ROI', icon: TrendingUp },
];
</script>

<template>
    <Head title="Locations - Waka Wealth Realty" />

    <div class="overflow-hidden bg-black">
        <!-- Hero Section with Smoke Effect -->
        <section
            class="relative min-h-[50vh] flex items-center justify-center bg-black overflow-hidden"
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
                        Our <span class="text-[#D31C00]">Locations</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300">
                        Prime locations across Abuja with verified titles and excellent infrastructure
                    </p>
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
                        <div class="mb-3 inline-flex rounded-full bg-[#D31C00]/10 p-3">
                            <component :is="stat.icon" class="h-8 w-8 text-[#D31C00]" />
                        </div>
                        <div class="text-4xl font-bold text-white">{{ stat.number }}</div>
                        <div class="mt-1 text-sm font-medium text-gray-400">{{ stat.label }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location Type Tabs -->
        <section class="bg-black py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center gap-4" data-aos="fade-up">
                    <button
                        @click="activeTab = 'sites'"
                        :class="[
                            'px-8 py-4 rounded-sm font-semibold text-lg transition-all',
                            activeTab === 'sites'
                                ? 'bg-[#D31C00] text-white shadow-lg scale-105'
                                : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                        ]"
                    >
                        Sites & Services
                    </button>
                    <button
                        @click="activeTab = 'homes'"
                        :class="[
                            'px-8 py-4 rounded-sm font-semibold text-lg transition-all',
                            activeTab === 'homes'
                                ? 'bg-[#D31C00] text-white shadow-lg scale-105'
                                : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                        ]"
                    >
                        Homes
                    </button>
                </div>
            </div>
        </section>

        <!-- Locations Grid -->
        <section class="bg-gray-900 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">
                        {{ activeTab === 'sites' ? 'Sites & Services' : 'Homes' }} Locations
                    </h2>
                    <p class="text-lg text-gray-400">
                        {{ displayLocations.length }} locations with verified titles and excellent infrastructure
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="(location, index) in displayLocations"
                        :key="location.slug"
                        :href="`/properties?location=${location.slug}`"
                        class="group relative overflow-hidden rounded-2xl bg-gray-800 border border-gray-700 transition-all hover:border-[#D31C00] hover:shadow-xl hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 50)"
                    >
                        <!-- Location Image/Gradient -->
                        <div class="relative h-48 bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                            <!-- Location Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-black/70 backdrop-blur-sm text-white font-semibold">
                                    <MapPin class="h-4 w-4 text-[#D31C00]" />
                                    {{ location.name }}
                                </span>
                            </div>

                            <!-- Property Count -->
                            <div class="absolute bottom-4 right-4">
                                <span class="px-4 py-2 rounded-full bg-[#D31C00]/90 backdrop-blur-sm text-white font-bold">
                                    {{ location.propertyCount }} Properties
                                </span>
                            </div>
                        </div>

                        <!-- Location Details -->
                        <div class="p-6">
                            <p class="mb-4 text-gray-300 leading-relaxed">
                                {{ location.description }}
                            </p>

                            <!-- Highlights -->
                            <div class="mb-4 flex flex-wrap gap-2">
                                <span
                                    v-for="highlight in location.highlights"
                                    :key="highlight"
                                    class="px-3 py-1 rounded-full text-xs font-medium bg-gray-700 text-gray-300"
                                >
                                    {{ highlight }}
                                </span>
                            </div>

                            <!-- View Properties Link -->
                            <div class="flex items-center justify-between">
                                <span class="text-[#D31C00] font-semibold group-hover:underline">
                                    View Properties
                                </span>
                                <ArrowRight class="h-5 w-5 text-[#D31C00] transition-transform group-hover:translate-x-2" />
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Why These Locations Section -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Why These <span class="text-[#D31C00]">Locations?</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        We carefully select locations based on rigorous criteria to ensure your investment is sound
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        class="rounded-2xl border border-gray-800 bg-gray-900/50 p-8"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <svg class="h-8 w-8 text-[#D31C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">Verified Titles</h3>
                        <p class="text-gray-400">
                            Every location has been thoroughly vetted for clear and legitimate land titles
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-gray-800 bg-gray-900/50 p-8"
                        data-aos="fade-up"
                        data-aos-delay="200"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <svg class="h-8 w-8 text-[#D31C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">High Appreciation</h3>
                        <p class="text-gray-400">
                            Selected areas with proven track records of property value growth
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-gray-800 bg-gray-900/50 p-8"
                        data-aos="fade-up"
                        data-aos-delay="300"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <svg class="h-8 w-8 text-[#D31C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">Infrastructure</h3>
                        <p class="text-gray-400">
                            Good road networks, electricity, water supply, and proximity to amenities
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-gray-800 bg-gray-900/50 p-8"
                        data-aos="fade-up"
                        data-aos-delay="400"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <svg class="h-8 w-8 text-[#D31C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">Strategic Position</h3>
                        <p class="text-gray-400">
                            Proximity to city centers, schools, hospitals, and commercial hubs
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Investment Guide Section -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="rounded-2xl border-2 border-[#D31C00] bg-[#D31C00]/5 p-12" data-aos="fade-up">
                    <div class="text-center">
                        <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">
                            Not Sure Which Location Is Right for You?
                        </h2>
                        <p class="mx-auto mb-8 max-w-2xl text-lg text-gray-300">
                            Our investment advisors can help you choose the perfect location based on your budget, goals, and timeline.
                        </p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <Link
                                href="/contact"
                                class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 font-semibold text-white transition-colors hover:bg-[#B01700]"
                            >
                                <span>Schedule Consultation</span>
                                <ArrowRight class="h-5 w-5" />
                            </Link>
                            <Link
                                href="/investment/calculator"
                                class="inline-flex items-center space-x-2 rounded-sm border-2 border-[#D31C00] bg-transparent px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-[#D31C00] hover:text-white"
                            >
                                <span>Calculate ROI</span>
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
                        Ready to Invest?
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Browse properties in your preferred location and take the first step toward building wealth
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/properties"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>View All Properties</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
/* Reuse smoke effect styles */
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
