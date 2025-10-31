<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { MapPin, Home, DollarSign, Maximize, Filter, X, ArrowRight } from 'lucide-vue-next';
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

interface Props {
    properties?: Array<{
        id: number;
        title: string;
        type: 'site' | 'home';
        location: string;
        price: number;
        size: string;
        image: string;
        slug: string;
        status: 'available' | 'sold' | 'reserved';
        bedrooms?: number;
        bathrooms?: number;
    }>;
}

const props = withDefaults(defineProps<Props>(), {
    properties: () => [],
});

// Mock data for demonstration
const mockProperties = [
    {
        id: 1,
        title: 'Premium Site at Wuye District',
        type: 'site' as const,
        location: 'Wuye',
        price: 15000000,
        size: '500 sqm',
        image: '',
        slug: 'premium-site-wuye',
        status: 'available' as const,
    },
    {
        id: 2,
        title: 'Luxury 4-Bedroom Duplex',
        type: 'home' as const,
        location: 'Lifecamp',
        price: 85000000,
        size: '350 sqm',
        image: '',
        slug: 'luxury-duplex-lifecamp',
        status: 'available' as const,
        bedrooms: 4,
        bathrooms: 5,
    },
    {
        id: 3,
        title: 'Commercial Plot Katampe',
        type: 'site' as const,
        location: 'Katampe',
        price: 22000000,
        size: '800 sqm',
        image: '',
        slug: 'commercial-plot-katampe',
        status: 'available' as const,
    },
    {
        id: 4,
        title: 'Modern 3-Bedroom Apartment',
        type: 'home' as const,
        location: 'Guzape',
        price: 65000000,
        size: '280 sqm',
        image: '',
        slug: 'modern-apartment-guzape',
        status: 'reserved' as const,
        bedrooms: 3,
        bathrooms: 4,
    },
    {
        id: 5,
        title: 'Development Land Kukwaba',
        type: 'site' as const,
        location: 'Kukwaba',
        price: 12000000,
        size: '600 sqm',
        image: '',
        slug: 'development-land-kukwaba',
        status: 'available' as const,
    },
    {
        id: 6,
        title: 'Executive 5-Bedroom Villa',
        type: 'home' as const,
        location: 'Gaduwa',
        price: 120000000,
        size: '450 sqm',
        image: '',
        slug: 'executive-villa-gaduwa',
        status: 'available' as const,
        bedrooms: 5,
        bathrooms: 6,
    },
];

const siteLocations = ['Wuye', 'Kukwaba', 'Katampe', 'Lifecamp', 'Karsana', 'Kabusa', 'Apo-Wasa', 'Idu', 'Lugbe', 'Kyami', 'Gwagwalada'];
const homeLocations = ['Wuye', 'Lifecamp', 'Guzape', 'Gaduwa', 'Kaura', 'Idu'];

const propertyType = ref<'all' | 'site' | 'home'>('all');
const selectedLocation = ref<string | null>(null);
const showFilters = ref(false);

const availableLocations = computed(() => {
    if (propertyType.value === 'site') return siteLocations;
    if (propertyType.value === 'home') return homeLocations;
    return [...new Set([...siteLocations, ...homeLocations])].sort();
});

const displayProperties = computed(() => {
    const allProperties = props.properties.length > 0 ? props.properties : mockProperties;

    return allProperties.filter(property => {
        const typeMatch = propertyType.value === 'all' || property.type === propertyType.value;
        const locationMatch = !selectedLocation.value || property.location === selectedLocation.value;
        return typeMatch && locationMatch;
    });
});

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: 'NGN',
        minimumFractionDigits: 0,
    }).format(price);
};

const getStatusColor = (status: string) => {
    switch (status) {
        case 'available':
            return 'bg-green-100 text-green-700 border-green-200';
        case 'reserved':
            return 'bg-yellow-100 text-yellow-700 border-yellow-200';
        case 'sold':
            return 'bg-gray-100 text-gray-700 border-gray-200';
        default:
            return 'bg-gray-100 text-gray-700 border-gray-200';
    }
};

const clearFilters = () => {
    propertyType.value = 'all';
    selectedLocation.value = null;
};
</script>

<template>
    <Head title="Properties - Waka Wealth Realty" />

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
                        Explore Our <span class="text-[#D31C00]">Properties</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300">
                        Premium sites and homes across Abuja's most sought-after locations
                    </p>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="bg-gray-900 py-8 sticky top-0 z-40 border-b border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <!-- Property Type Tabs -->
                    <div class="flex gap-2">
                        <button
                            @click="propertyType = 'all'"
                            :class="[
                                'px-6 py-2.5 rounded-sm font-semibold transition',
                                propertyType === 'all'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            All Properties
                        </button>
                        <button
                            @click="propertyType = 'site'"
                            :class="[
                                'px-6 py-2.5 rounded-sm font-semibold transition',
                                propertyType === 'site'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            Sites & Services
                        </button>
                        <button
                            @click="propertyType = 'home'"
                            :class="[
                                'px-6 py-2.5 rounded-sm font-semibold transition',
                                propertyType === 'home'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            Homes
                        </button>
                    </div>

                    <!-- Filter Toggle & Clear -->
                    <div class="flex items-center gap-4">
                        <button
                            @click="showFilters = !showFilters"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-sm bg-gray-800 text-white hover:bg-gray-700 transition"
                        >
                            <Filter class="h-4 w-4" />
                            <span>Locations</span>
                        </button>
                        <button
                            v-if="selectedLocation"
                            @click="clearFilters"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-sm bg-gray-800 text-white hover:bg-gray-700 transition"
                        >
                            <X class="h-4 w-4" />
                            <span>Clear</span>
                        </button>
                        <span class="text-gray-400">
                            {{ displayProperties.length }} {{ displayProperties.length === 1 ? 'property' : 'properties' }}
                        </span>
                    </div>
                </div>

                <!-- Location Filters -->
                <div v-if="showFilters" class="mt-4 pt-4 border-t border-gray-800">
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="location in availableLocations"
                            :key="location"
                            @click="selectedLocation = selectedLocation === location ? null : location"
                            :class="[
                                'px-4 py-2 rounded-full text-sm font-medium transition',
                                selectedLocation === location
                                    ? 'bg-[#D31C00] text-white'
                                    : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                            ]"
                        >
                            {{ location }}
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Properties Grid -->
        <section class="bg-black py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div v-if="displayProperties.length === 0" class="text-center py-16">
                    <p class="text-xl text-gray-400">No properties found matching your criteria.</p>
                    <button
                        @click="clearFilters"
                        class="mt-6 inline-flex items-center gap-2 px-6 py-3 rounded-sm bg-[#D31C00] text-white hover:bg-[#B01700] transition"
                    >
                        Clear Filters
                    </button>
                </div>

                <div v-else class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="(property, index) in displayProperties"
                        :key="property.id"
                        class="group overflow-hidden rounded-2xl bg-gray-900 border border-gray-800 transition-all hover:border-[#D31C00] hover:shadow-xl"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 50)"
                    >
                        <!-- Property Image -->
                        <div class="relative aspect-[4/3] bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100 overflow-hidden">
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span
                                    :class="[
                                        'px-3 py-1 rounded-full text-xs font-semibold border backdrop-blur-sm',
                                        getStatusColor(property.status)
                                    ]"
                                >
                                    {{ property.status.charAt(0).toUpperCase() + property.status.slice(1) }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-black/70 text-white backdrop-blur-sm">
                                    {{ property.type === 'site' ? 'Site & Services' : 'Home' }}
                                </span>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="p-6">
                            <div class="mb-3 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <MapPin class="h-4 w-4" />
                                    <span>{{ property.location }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <Maximize class="h-4 w-4" />
                                    <span>{{ property.size }}</span>
                                </div>
                            </div>

                            <h3 class="mb-3 text-xl font-bold text-white line-clamp-2 group-hover:text-[#D31C00] transition">
                                {{ property.title }}
                            </h3>

                            <!-- Additional Details for Homes -->
                            <div v-if="property.type === 'home' && (property.bedrooms || property.bathrooms)" class="mb-4 flex gap-4 text-sm text-gray-400">
                                <div v-if="property.bedrooms" class="flex items-center gap-1">
                                    <Home class="h-4 w-4" />
                                    <span>{{ property.bedrooms }} Bed</span>
                                </div>
                                <div v-if="property.bathrooms" class="flex items-center gap-1">
                                    <span>{{ property.bathrooms }} Bath</span>
                                </div>
                            </div>

                            <div class="mb-4 flex items-center gap-2">
                                <DollarSign class="h-5 w-5 text-[#D31C00]" />
                                <span class="text-2xl font-bold text-white">{{ formatPrice(property.price) }}</span>
                            </div>

                            <Link
                                :href="`/properties/${property.slug}`"
                                class="block w-full rounded-sm bg-black border border-gray-700 py-3 text-center font-semibold text-white transition hover:bg-[#D31C00] hover:border-[#D31C00] group"
                            >
                                <span class="inline-flex items-center gap-2">
                                    View Details
                                    <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                                </span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Our Properties -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Why Choose Our <span class="text-[#D31C00]">Properties</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Every property is carefully selected and verified to meet our highest standards
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="rounded-2xl border border-gray-800 bg-gray-800/50 p-8 text-center" data-aos="fade-up" data-aos-delay="100">
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <svg class="h-8 w-8 text-[#D31C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">100% Verified Titles</h3>
                        <p class="text-gray-400">
                            Every property undergoes rigorous title verification and legal due diligence
                        </p>
                    </div>

                    <div class="rounded-2xl border border-gray-800 bg-gray-800/50 p-8 text-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <svg class="h-8 w-8 text-[#D31C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">Flexible Payment Plans</h3>
                        <p class="text-gray-400">
                            Installment options and financing solutions to make ownership accessible
                        </p>
                    </div>

                    <div class="rounded-2xl border border-gray-800 bg-gray-800/50 p-8 text-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <svg class="h-8 w-8 text-[#D31C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">Post-Purchase Support</h3>
                        <p class="text-gray-400">
                            Ongoing support with documentation, development, and property management
                        </p>
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
                        Can't Find What You're Looking For?
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Let us help you find your perfect property. Our team is ready to assist you.
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Contact Us</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/investment/calculator"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>Calculate ROI</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
/* Reuse smoke effect styles from About page */
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
