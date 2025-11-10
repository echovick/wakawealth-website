<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { MapPin, Home, Tag, Calendar, User, ChevronLeft, ChevronRight } from 'lucide-vue-next';

defineOptions({ layout: MarketingLayout });

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface PostType {
    id: number;
    title: string;
}

interface Author {
    id: number;
    name: string;
}

interface Property {
    id: number;
    title: string;
    slug: string;
    content: Record<string, any>;
    post_type_id: number;
    published_at: string | null;
    created_at: string;
    post_type: PostType;
    categories: Category[];
    user: Author;
}

interface Props {
    property: Property;
}

const props = defineProps<Props>();

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: 'NGN',
        minimumFractionDigits: 0,
    }).format(price);
};

const primaryLocation = props.property.categories[0];

// Dummy data - will be replaced with CMS content
const dummyGallery = [
    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800',
    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800',
    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=800',
    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800',
];

const dummyPrice = 45000000;

const dummyPaymentPlan = {
    available: true,
    plans: [
        {
            name: 'Outright Payment',
            description: 'Full payment at once with 10% discount',
            price: 40500000,
            discount: '10%',
        },
        {
            name: '6 Months Plan',
            description: 'Pay in 6 monthly installments',
            initialDeposit: 15000000,
            monthly: 5000000,
            total: 45000000,
        },
        {
            name: '12 Months Plan',
            description: 'Pay in 12 monthly installments',
            initialDeposit: 12000000,
            monthly: 2916667,
            total: 47000000,
        },
    ],
};

const dummyFloorPlans = [
    'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800',
    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800',
];

const currentImageIndex = ref(0);

const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % dummyGallery.length;
};

const prevImage = () => {
    currentImageIndex.value = (currentImageIndex.value - 1 + dummyGallery.length) % dummyGallery.length;
};

const selectImage = (index: number) => {
    currentImageIndex.value = index;
};
</script>

<template>
    <Head :title="`${property.title} - Waka Wealth`" />

    <div class="min-h-screen bg-black">
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-gray-900 to-black py-20">
            <div class="absolute inset-0 bg-grid-white/[0.02]" />
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="mb-8 flex items-center space-x-2 text-sm text-gray-400">
                    <Link href="/" class="hover:text-white transition-colors">Home</Link>
                    <span>/</span>
                    <Link href="/properties" class="hover:text-white transition-colors">Properties</Link>
                    <span>/</span>
                    <span class="text-white">{{ property.title }}</span>
                </nav>

                <!-- Property Header -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="rounded-full bg-[#D31C00]/20 px-4 py-2 text-sm font-semibold text-[#D31C00]">
                            {{ property.post_type.title }}
                        </span>
                        <span
                            v-if="property.published_at"
                            class="rounded-full bg-green-500/20 px-4 py-2 text-sm font-semibold text-green-400"
                        >
                            Available
                        </span>
                        <span
                            v-else
                            class="rounded-full bg-gray-500/20 px-4 py-2 text-sm font-semibold text-gray-400"
                        >
                            Coming Soon
                        </span>
                    </div>

                    <h1 class="text-4xl font-bold text-white md:text-5xl lg:text-6xl">
                        {{ property.title }}
                    </h1>

                    <div class="mb-4">
                        <div class="text-3xl font-bold text-[#D31C00]">
                            {{ formatPrice(dummyPrice) }}
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 text-gray-400">
                        <div v-if="primaryLocation" class="flex items-center gap-2">
                            <MapPin class="h-5 w-5" />
                            <Link
                                :href="`/locations/${primaryLocation.slug}`"
                                class="hover:text-white transition-colors"
                            >
                                {{ primaryLocation.name }}
                            </Link>
                        </div>
                        <div class="flex items-center gap-2">
                            <Calendar class="h-5 w-5" />
                            <span>{{ formatDate(property.created_at) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <User class="h-5 w-5" />
                            <span>{{ property.user.name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Property Content -->
        <section class="py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Image Gallery -->
                        <div class="space-y-4">
                            <!-- Main Image -->
                            <div class="relative aspect-[16/9] rounded-2xl bg-gradient-to-br from-gray-800 to-gray-700 overflow-hidden">
                                <img
                                    :src="dummyGallery[currentImageIndex]"
                                    :alt="`${property.title} - Image ${currentImageIndex + 1}`"
                                    class="h-full w-full object-cover"
                                />
                                <!-- Navigation Arrows -->
                                <button
                                    @click="prevImage"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white transition-colors hover:bg-black/75"
                                >
                                    <ChevronLeft class="h-6 w-6" />
                                </button>
                                <button
                                    @click="nextImage"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white transition-colors hover:bg-black/75"
                                >
                                    <ChevronRight class="h-6 w-6" />
                                </button>
                                <!-- Image Counter -->
                                <div class="absolute bottom-4 right-4 rounded-full bg-black/50 px-3 py-1 text-sm text-white">
                                    {{ currentImageIndex + 1 }} / {{ dummyGallery.length }}
                                </div>
                            </div>

                            <!-- Thumbnail Gallery -->
                            <div class="grid grid-cols-4 gap-4">
                                <button
                                    v-for="(image, index) in dummyGallery"
                                    :key="index"
                                    @click="selectImage(index)"
                                    :class="[
                                        'aspect-[4/3] rounded-lg overflow-hidden transition-all',
                                        currentImageIndex === index
                                            ? 'ring-2 ring-[#D31C00]'
                                            : 'opacity-60 hover:opacity-100'
                                    ]"
                                >
                                    <img
                                        :src="image"
                                        :alt="`${property.title} - Thumbnail ${index + 1}`"
                                        class="h-full w-full object-cover"
                                    />
                                </button>
                            </div>
                        </div>

                        <!-- Property Description -->
                        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8">
                            <h2 class="mb-6 text-2xl font-bold text-white">Property Overview</h2>
                            <div class="prose prose-invert max-w-none text-gray-300">
                                <!-- Property content will be rendered here -->
                                <div v-if="Object.keys(property.content).length > 0">
                                    <!-- Dynamic content rendering based on field groups -->
                                    <div v-for="(value, key) in property.content" :key="key" class="mb-6">
                                        <div v-if="typeof value === 'string'" v-html="value"></div>
                                        <div v-else-if="Array.isArray(value)" class="space-y-2">
                                            <div v-for="(item, index) in value" :key="index">
                                                {{ item }}
                                            </div>
                                        </div>
                                        <div v-else>
                                            {{ value }}
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <p class="mb-4">
                                        This exceptional property represents a prime investment opportunity in one of Nigeria's most sought-after locations. Designed with modern living in mind, it combines luxury, comfort, and strategic positioning to deliver outstanding value.
                                    </p>
                                    <p class="mb-4">
                                        Whether you're looking for your dream home or a lucrative investment, this property offers the perfect blend of quality construction, premium amenities, and future appreciation potential.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Key Features -->
                        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8">
                            <h2 class="mb-6 text-2xl font-bold text-white">Key Features</h2>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div class="flex items-start gap-3">
                                    <div class="rounded-full bg-[#D31C00]/20 p-2">
                                        <Home class="h-5 w-5 text-[#D31C00]" />
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-white">Premium Location</h3>
                                        <p class="text-sm text-gray-400">Strategically positioned in a high-growth area</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="rounded-full bg-[#D31C00]/20 p-2">
                                        <Home class="h-5 w-5 text-[#D31C00]" />
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-white">Quality Construction</h3>
                                        <p class="text-sm text-gray-400">Built with premium materials and finishes</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="rounded-full bg-[#D31C00]/20 p-2">
                                        <Home class="h-5 w-5 text-[#D31C00]" />
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-white">Great Accessibility</h3>
                                        <p class="text-sm text-gray-400">Easy access to major roads and amenities</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="rounded-full bg-[#D31C00]/20 p-2">
                                        <Home class="h-5 w-5 text-[#D31C00]" />
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-white">High ROI Potential</h3>
                                        <p class="text-sm text-gray-400">Excellent investment returns and appreciation</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amenities -->
                        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8">
                            <h2 class="mb-6 text-2xl font-bold text-white">Amenities & Facilities</h2>
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                <div class="flex items-center gap-2 text-gray-300">
                                    <div class="h-2 w-2 rounded-full bg-[#D31C00]"></div>
                                    <span>24/7 Security</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <div class="h-2 w-2 rounded-full bg-[#D31C00]"></div>
                                    <span>Paved Roads</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <div class="h-2 w-2 rounded-full bg-[#D31C00]"></div>
                                    <span>Electricity</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <div class="h-2 w-2 rounded-full bg-[#D31C00]"></div>
                                    <span>Water Supply</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <div class="h-2 w-2 rounded-full bg-[#D31C00]"></div>
                                    <span>Drainage System</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <div class="h-2 w-2 rounded-full bg-[#D31C00]"></div>
                                    <span>Green Spaces</span>
                                </div>
                            </div>
                        </div>

                        <!-- Floor Plans -->
                        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8">
                            <h2 class="mb-6 text-2xl font-bold text-white">Floor Plans</h2>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div
                                    v-for="(plan, index) in dummyFloorPlans"
                                    :key="index"
                                    class="aspect-square rounded-lg overflow-hidden border border-gray-800 hover:border-[#D31C00] transition-colors cursor-pointer"
                                >
                                    <img
                                        :src="plan"
                                        :alt="`Floor Plan ${index + 1}`"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Payment Plans -->
                        <div v-if="dummyPaymentPlan.available" class="rounded-2xl border border-gray-800 bg-gray-900 p-8">
                            <h2 class="mb-6 text-2xl font-bold text-white">Flexible Payment Plans</h2>
                            <div class="space-y-4">
                                <div
                                    v-for="(plan, index) in dummyPaymentPlan.plans"
                                    :key="index"
                                    class="rounded-lg border border-gray-800 bg-black p-6 transition-colors hover:border-[#D31C00]"
                                >
                                    <div class="mb-2 flex items-start justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-white">{{ plan.name }}</h3>
                                            <p class="text-sm text-gray-400">{{ plan.description }}</p>
                                        </div>
                                        <span v-if="plan.discount" class="rounded-full bg-green-500/20 px-3 py-1 text-xs font-semibold text-green-400">
                                            {{ plan.discount }} OFF
                                        </span>
                                    </div>
                                    <div class="mt-4 space-y-2">
                                        <div v-if="plan.price" class="flex items-center justify-between">
                                            <span class="text-gray-400">Total Price:</span>
                                            <span class="text-xl font-bold text-[#D31C00]">{{ formatPrice(plan.price) }}</span>
                                        </div>
                                        <div v-else>
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-400">Initial Deposit:</span>
                                                <span class="font-semibold text-white">{{ formatPrice(plan.initialDeposit) }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-400">Monthly Payment:</span>
                                                <span class="font-semibold text-white">{{ formatPrice(plan.monthly) }}</span>
                                            </div>
                                            <div class="mt-2 flex items-center justify-between border-t border-gray-800 pt-2">
                                                <span class="text-gray-400">Total:</span>
                                                <span class="text-xl font-bold text-[#D31C00]">{{ formatPrice(plan.total) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Price Card -->
                        <div class="rounded-2xl border border-[#D31C00] bg-gradient-to-br from-gray-900 to-black p-6">
                            <div class="mb-2 text-sm font-semibold uppercase tracking-wide text-gray-400">
                                Starting From
                            </div>
                            <div class="mb-4 text-4xl font-bold text-[#D31C00]">
                                {{ formatPrice(dummyPrice) }}
                            </div>
                            <Link
                                href="/contact"
                                class="block w-full rounded-sm bg-[#D31C00] px-6 py-3 text-center font-semibold text-white transition-colors hover:bg-[#B01700]"
                            >
                                Inquire Now
                            </Link>
                        </div>

                        <!-- Contact Card -->
                        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6">
                            <h3 class="mb-4 text-xl font-bold text-white">Need More Information?</h3>
                            <p class="mb-6 text-gray-400">
                                Our team is ready to answer all your questions about this property.
                            </p>
                            <Link
                                href="/contact"
                                class="block w-full rounded-sm border border-[#D31C00] px-6 py-3 text-center font-semibold text-[#D31C00] transition-colors hover:bg-[#D31C00] hover:text-white"
                            >
                                Contact Us
                            </Link>
                        </div>

                        <!-- Categories -->
                        <div v-if="property.categories.length > 0" class="rounded-2xl border border-gray-800 bg-gray-900 p-6">
                            <h3 class="mb-4 text-lg font-bold text-white">Categories</h3>
                            <div class="flex flex-wrap gap-2">
                                <Link
                                    v-for="category in property.categories"
                                    :key="category.id"
                                    :href="`/locations/${category.slug}`"
                                    class="inline-flex items-center gap-1 rounded-full bg-gray-800 px-3 py-1.5 text-sm text-gray-300 transition-colors hover:bg-gray-700 hover:text-white"
                                >
                                    <Tag class="h-3 w-3" />
                                    {{ category.name }}
                                </Link>
                            </div>
                        </div>

                        <!-- Share Card -->
                        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6">
                            <h3 class="mb-4 text-lg font-bold text-white">Share Property</h3>
                            <p class="text-sm text-gray-400">
                                Share this property with your friends and family.
                            </p>
                        </div>
                    </div>
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
