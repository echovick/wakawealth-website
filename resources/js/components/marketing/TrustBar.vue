<script setup lang="ts">
import { Building2, Users, MapPin, Award } from 'lucide-vue-next';

interface Props {
    stats: {
        yearsExperience: number;
        propertiesSold: number;
        satisfiedClients: number;
        locations: number;
    };
}

defineProps<Props>();
</script>

<template>
    <section class="border-b border-gray-800 bg-black py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                <!-- Years of Experience -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="mb-3 rounded-full bg-[#D31C00]/10 p-3">
                        <Award class="h-8 w-8 text-[#D31C00]" />
                    </div>
                    <div class="text-4xl font-bold text-white">
                        {{ stats.yearsExperience }}+
                    </div>
                    <div class="mt-1 text-sm font-medium text-gray-400">
                        Years Experience
                    </div>
                </div>

                <!-- Properties Sold -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="mb-3 rounded-full bg-[#D31C00]/10 p-3">
                        <Building2 class="h-8 w-8 text-[#D31C00]" />
                    </div>
                    <div class="text-4xl font-bold text-white">
                        {{ stats.propertiesSold }}+
                    </div>
                    <div class="mt-1 text-sm font-medium text-gray-400">
                        Properties Sold
                    </div>
                </div>

                <!-- Satisfied Clients -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="mb-3 rounded-full bg-[#D31C00]/10 p-3">
                        <Users class="h-8 w-8 text-[#D31C00]" />
                    </div>
                    <div class="text-4xl font-bold text-white">
                        {{ stats.satisfiedClients }}+
                    </div>
                    <div class="mt-1 text-sm font-medium text-gray-400">
                        Satisfied Clients
                    </div>
                </div>

                <!-- Locations -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="mb-3 rounded-full bg-[#D31C00]/10 p-3">
                        <MapPin class="h-8 w-8 text-[#D31C00]" />
                    </div>
                    <div class="text-4xl font-bold text-white">
                        {{ stats.locations }}+
                    </div>
                    <div class="mt-1 text-sm font-medium text-gray-400">
                        Locations Served
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
