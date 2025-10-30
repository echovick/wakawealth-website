<script setup lang="ts">
import { Handshake, GraduationCap, Shield, CreditCard, Globe, Users } from 'lucide-vue-next';

const features = [
    {
        icon: Handshake,
        title: 'Journey Partnership Model',
        description: 'We remain your partner throughout your entire wealth-building journey—from first inquiry to portfolio optimization.',
        color: 'red',
    },
    {
        icon: GraduationCap,
        title: 'Education-First Approach',
        description: 'Comprehensive education before, during, and after transactions. We empower, not gatekeep.',
        color: 'orange',
    },
    {
        icon: Shield,
        title: 'End-to-End Security',
        description: 'Rigorous due diligence, legal protection, and quality assurance at every step.',
        color: 'yellow',
    },
    {
        icon: CreditCard,
        title: 'Flexible Solutions',
        description: 'Creative financing, co-investment opportunities, and flexible payment structures.',
        color: 'pink',
    },
    {
        icon: Globe,
        title: 'Diaspora Facilitation',
        description: 'Specialized services for Africans abroad with virtual tours and trusted local representatives.',
        color: 'red',
    },
    {
        icon: Users,
        title: 'Community Focus',
        description: 'We build networks, celebrate shared wins, and lift as we climb together.',
        color: 'orange',
    },
];
</script>

<template>
    <section class="bg-black py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-16 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                    Why Choose <span class="text-[#D31C00]">Waka Wealth</span>
                </h2>
                <p class="mx-auto max-w-3xl text-lg text-gray-400">
                    Our unique propositions make wealth-building accessible, transparent, and achievable for everyone
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="(feature, index) in features"
                    :key="index"
                    class="group rounded-2xl border border-gray-800 bg-gray-900 p-8 transition-all hover:border-[#D31C00] hover:shadow-lg"
                    data-aos="fade-up"
                    :data-aos-delay="200 + (index * 100)"
                >
                    <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                        <component :is="feature.icon" class="h-8 w-8 text-[#D31C00]" />
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-white">{{ feature.title }}</h3>
                    <p class="text-gray-400">{{ feature.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
