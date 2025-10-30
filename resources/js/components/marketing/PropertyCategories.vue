<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Property {
    id: number;
    title: string;
    type: 'site' | 'home';
    location: string;
    price: number;
    size: string;
    image: string;
    slug: string;
}

interface Props {
    properties: Property[];
}

defineProps<Props>();
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
                <Link
                    href="/properties/sites"
                    class="rounded-full bg-[#D31C00] px-8 py-3 font-semibold text-white transition hover:bg-[#B01700]"
                >
                    Sites & Services
                </Link>
                <Link
                    href="/properties/homes"
                    class="rounded-full border-2 border-white px-8 py-3 font-semibold text-white transition hover:bg-white hover:text-black"
                >
                    Homes
                </Link>
            </div>

            <!-- Featured Properties Grid - Mock for now -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="i in 3"
                    :key="i"
                    class="group overflow-hidden rounded-2xl bg-gray-800 shadow-sm transition-shadow hover:shadow-xl border border-gray-700"
                    data-aos="fade-up"
                    :data-aos-delay="300 + (i * 100)"
                >
                    <div class="aspect-[4/3] bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100" />
                    <div class="p-6">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Available</span>
                            <span class="text-xs text-gray-500">Wuye, Abuja</span>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-white">Property Title {{ i }}</h3>
                        <div class="mb-4 flex items-center justify-between text-sm text-gray-400">
                            <span>500 sqm</span>
                            <span class="font-bold text-red-600">₦15,000,000</span>
                        </div>
                        <Link
                            href="/properties/site/property-slug"
                            class="block w-full rounded-sm bg-black py-3 text-center font-semibold text-white transition hover:bg-red-600"
                        >
                            View Details
                        </Link>
                    </div>
                </div>
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
