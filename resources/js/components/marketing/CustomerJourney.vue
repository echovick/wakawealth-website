<script setup lang="ts">
import { Compass, Map, Building, TrendingUp, Award } from 'lucide-vue-next';

const steps = [
    {
        number: '01',
        icon: Compass,
        title: 'Awareness',
        subtitle: 'The First Step',
        description: 'Your journey begins with a dream. We meet you with resources, inspiration, and proof that it\'s possible.',
    },
    {
        number: '02',
        icon: Map,
        title: 'Exploration',
        subtitle: 'The Path Forward',
        description: 'Explore options and get educated on market trends, financing, and ROI potential.',
    },
    {
        number: '03',
        icon: Building,
        title: 'Transaction',
        subtitle: 'The Milestone',
        description: 'Make your move with our support handling legal, financial, and logistical complexities.',
    },
    {
        number: '04',
        icon: TrendingUp,
        title: 'Growth',
        subtitle: 'The Continued Journey',
        description: 'Portfolio management, reinvestment opportunities, and ongoing wealth-building strategies.',
    },
    {
        number: '05',
        icon: Award,
        title: 'Legacy',
        subtitle: 'Own the Destination',
        description: 'Build generational wealth and secure your family\'s future.',
    },
];
</script>

<template>
    <section class="bg-gradient-to-br from-black to-gray-900 py-20 text-white">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-16 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-4 text-4xl font-bold md:text-5xl">
                    Your <span class="text-red-500">Customer Journey</span>
                </h2>
                <p class="mx-auto max-w-3xl text-lg text-gray-300">
                    From awareness to legacy—we walk with you every step of the way
                </p>
            </div>

            <div class="relative">
                <!-- Connection Line -->
                <div class="absolute left-8 top-0 hidden h-full w-0.5 bg-red-500/30 md:block lg:left-1/2" />

                <!-- Steps -->
                <div class="space-y-12">
                    <div
                        v-for="(step, index) in steps"
                        :key="index"
                        :class="[
                            'relative flex flex-col md:flex-row md:items-center',
                            index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse',
                        ]"
                        data-aos="fade-up"
                        :data-aos-delay="200 + (index * 100)"
                    >
                        <div :class="['w-full md:w-5/12', index % 2 === 0 ? 'md:pr-12' : 'md:pl-12']">
                            <div class="rounded-2xl bg-gray-800 p-8">
                                <div class="mb-4 flex items-center space-x-4">
                                    <div class="rounded-full bg-red-600 p-3">
                                        <component :is="step.icon" class="h-6 w-6" />
                                    </div>
                                    <span class="text-3xl font-bold text-red-500">{{ step.number }}</span>
                                </div>
                                <h3 class="mb-2 text-2xl font-bold">{{ step.title }}</h3>
                                <p class="mb-3 text-sm font-semibold text-red-400">{{ step.subtitle }}</p>
                                <p class="text-gray-300">{{ step.description }}</p>
                            </div>
                        </div>
                        <div class="hidden w-2/12 justify-center md:flex">
                            <div class="h-4 w-4 rounded-full border-4 border-red-500 bg-white" />
                        </div>
                        <div class="hidden w-5/12 md:block" />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
