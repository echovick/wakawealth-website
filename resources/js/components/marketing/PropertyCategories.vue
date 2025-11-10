<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

interface Property {
    id: number;
    title: string;
    slug: string;
    price: number;
    image: string | null;
    location: string;
}

interface PropertyType {
    id: number;
    name: string;
    slug: string;
    properties: Property[];
}

interface Props {
    featuredProperties: Record<string, PropertyType>;
    propertyTypes: Array<{ id: number; name: string; slug: string }>;
}

const props = defineProps<Props>();

// Set initial active tab to first property type (or 'homes' if available)
const activeTab = ref(props.propertyTypes[0]?.slug || 'homes');

const currentProperties = () => {
    return props.featuredProperties[activeTab.value]?.properties || [];
};

const formatPrice = (price: number): string => {
    return new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: 'NGN',
        minimumFractionDigits: 0,
    }).format(price);
};
</script>

<template>
    <section class="bg-black py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                    Featured <span class="text-[#D31C00]">Properties</span>
                </h2>
                <p class="mx-auto max-w-2xl text-lg text-gray-400">
                    Explore our selection of sites and homes across prime locations
                </p>
            </div>

            <!-- Property Categories Tabs -->
            <div class="mb-8 flex justify-center space-x-4" data-aos="fade-up" data-aos-delay="200">
                <button
                    v-for="propertyType in propertyTypes"
                    :key="propertyType.slug"
                    @click="activeTab = propertyType.slug"
                    :class="[
                        'rounded-full px-8 py-3 font-semibold transition',
                        activeTab === propertyType.slug
                            ? 'bg-[#D31C00] text-white hover:bg-[#B01700]'
                            : 'border-2 border-white text-white hover:bg-white hover:text-black'
                    ]"
                >
                    {{ propertyType.name }}
                </button>
            </div>

            <!-- Featured Properties Grid -->
            <div v-if="currentProperties().length > 0" class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="(property, index) in currentProperties()"
                    :key="property.id"
                    :href="`/properties/${property.slug}`"
                    class="group overflow-hidden rounded-2xl bg-gray-800 shadow-sm transition-shadow hover:shadow-xl border border-gray-700"
                    data-aos="fade-up"
                    :data-aos-delay="300 + (index * 100)"
                >
                    <div class="aspect-[4/3] overflow-hidden bg-gradient-to-br from-gray-700 to-gray-800">
                        <img
                            v-if="property.image"
                            :src="property.image"
                            :alt="property.title"
                            class="h-full w-full object-cover transition-transform group-hover:scale-110"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100"
                        />
                    </div>
                    <div class="p-6">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Available</span>
                            <span v-if="property.location" class="text-xs text-gray-400">{{ property.location }}</span>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-white line-clamp-2">{{ property.title }}</h3>
                        <div class="mb-4 flex items-center justify-between text-sm">
                            <span class="font-bold text-[#D31C00]">{{ formatPrice(property.price) }}</span>
                        </div>
                        <div class="block w-full rounded-sm bg-black py-3 text-center font-semibold text-white transition group-hover:bg-[#D31C00]">
                            View Details
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Empty State -->
            <div v-else class="py-16 text-center">
                <p class="text-lg text-gray-400">No featured properties available in this category.</p>
            </div>

            <div class="mt-12 text-center">
                <Link
                    href="/properties"
                    class="inline-flex items-center space-x-2 rounded-sm bg-red-600 px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-red-700"
                >
                    <span>View All Properties</span>
                </Link>
            </div>
        </div>
    </section>
</template>
