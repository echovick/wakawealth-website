<script setup lang="ts">
import { onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import HeroSlider from '@/components/marketing/HeroSlider.vue';
import AboutSection from '@/components/marketing/AboutSection.vue';
import FeaturedLocations from '@/components/marketing/FeaturedLocations.vue';
import PropertyCategories from '@/components/marketing/PropertyCategories.vue';
import WhyChooseUs from '@/components/marketing/WhyChooseUs.vue';
import CustomerJourney from '@/components/marketing/CustomerJourney.vue';
import Testimonials from '@/components/marketing/Testimonials.vue';
import CTASection from '@/components/marketing/CTASection.vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

onMounted(() => {
    // Initialize AOS
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
    stats?: {
        yearsExperience: number;
        propertiesSold: number;
        satisfiedClients: number;
        locations: number;
    };
    featuredLocations?: Array<{
        id: number;
        name: string;
        slug: string;
        image: string;
        propertyCount: number;
    }>;
    featuredProperties?: Array<{
        id: number;
        title: string;
        type: 'site' | 'home';
        location: string;
        price: number;
        size: string;
        image: string;
        slug: string;
    }>;
    testimonials?: Array<{
        id: number;
        clientName: string;
        clientLocation: string;
        content: string;
        rating: number;
        photo?: string;
    }>;
}

withDefaults(defineProps<Props>(), {
    stats: () => ({
        yearsExperience: 10,
        propertiesSold: 500,
        satisfiedClients: 1000,
        locations: 12,
    }),
    featuredLocations: () => [],
    featuredProperties: () => [],
    testimonials: () => [],
});
</script>

<template>
    <Head title="Home - Start the Journey. Own the Destination" />

    <div class="overflow-hidden">
        <!-- Hero Section -->
        <HeroSlider />

        <!-- Trust Bar -->
        <!-- <TrustBar :stats="stats" /> -->

        <!-- About Section -->
        <AboutSection />

        <!-- Featured Locations -->
        <FeaturedLocations :locations="featuredLocations" />

        <!-- Property Categories -->
        <PropertyCategories :properties="featuredProperties" />

        <!-- Why Choose Us -->
        <WhyChooseUs />

        <!-- Customer Journey -->
        <CustomerJourney />

        <!-- Testimonials -->
        <Testimonials :testimonials="testimonials" />

        <!-- CTA Section -->
        <CTASection />
    </div>
</template>

