<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { MapPin, ArrowRight } from 'lucide-vue-next';

interface Location {
    id: number;
    name: string;
    slug: string;
    image: string;
    propertyCount: number;
}

interface Props {
    locations: Location[];
}

defineProps<Props>();

// Mock data if none provided
const mockLocations = [
    { id: 1, name: 'Wuye', slug: 'wuye', image: '', propertyCount: 45 },
    { id: 2, name: 'Lifecamp', slug: 'lifecamp', image: '', propertyCount: 32 },
    { id: 3, name: 'Guzape', slug: 'guzape', image: '', propertyCount: 28 },
    { id: 4, name: 'Gaduwa', slug: 'gaduwa', image: '', propertyCount: 24 },
    { id: 5, name: 'Katampe', slug: 'katampe', image: '', propertyCount: 38 },
    { id: 6, name: 'Karsana', slug: 'karsana', image: '', propertyCount: 30 },
];
</script>

<template>
    <section class="bg-gray-900 py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="mb-12 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                    Explore Our <span class="text-[#D31C00]">Locations</span>
                </h2>
                <p class="mx-auto max-w-2xl text-lg text-gray-400">
                    Prime locations across Abuja with verified titles and excellent
                    infrastructure
                </p>
            </div>

            <!-- Locations Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="(location, index) in locations.length > 0 ? locations : mockLocations"
                    :key="location.id"
                    :href="`/locations/${location.slug}`"
                    class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 transition-transform hover:scale-105"
                    data-aos="fade-up"
                    :data-aos-delay="200 + (index * 100)"
                >
                    <div class="aspect-[4/3] bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100">
                        <!-- Image would go here -->
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent" />
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <div class="mb-2 flex items-center space-x-2">
                            <MapPin class="h-5 w-5" />
                            <span class="text-lg font-bold">{{ location.name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm">{{ location.propertyCount }} Properties</span>
                            <ArrowRight class="h-5 w-5 transition-transform group-hover:translate-x-1" />
                        </div>
                    </div>
                </Link>
            </div>

            <!-- View All Button -->
            <div class="mt-12 text-center">
                <Link
                    href="/locations"
                    class="inline-flex items-center space-x-2 rounded-sm border-2 border-black px-8 py-4 text-base font-semibold text-black transition-colors hover:bg-black hover:text-white"
                >
                    <span>View All Locations</span>
                    <ArrowRight class="h-5 w-5" />
                </Link>
            </div>
        </div>
    </section>
</template>