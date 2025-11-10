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
    heroSlider?: Array<{
        label: string;
        title: string;
        subtitle: string;
        description: string;
        image: string;
        cta1: Array<{ text: string; href: string }>;
    }>;
    aboutSection?: {
        label: string;
        title: string;
        content: string;
        featured_images: Array<{ images: string }>;
        core_value_items: Array<{ value_item: string }>;
        core_values_snippet: string;
        stats: {
            count: string;
            metric: string;
        };
        cta_text?: string;
        cta_url?: string;
    };
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
    featuredProperties?: Record<string, {
        id: number;
        name: string;
        slug: string;
        properties: Array<{
            id: number;
            title: string;
            slug: string;
            price: number;
            image: string | null;
            location: string;
        }>;
    }>;
    propertyTypes?: Array<{
        id: number;
        name: string;
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

const props = withDefaults(defineProps<Props>(), {
    heroSlider: () => [],
    aboutSection: () => undefined,
    stats: () => ({
        yearsExperience: 10,
        propertiesSold: 500,
        satisfiedClients: 1000,
        locations: 12,
    }),
    featuredLocations: () => [],
    featuredProperties: () => ({}),
    propertyTypes: () => [],
    testimonials: () => [],
});
</script>

<template>
    <Head title="Home - Start the Journey. Own the Destination" />

    <div class="overflow-hidden">
        <!-- Hero Section -->
        <HeroSlider :slides="heroSlider" />

        <!-- Trust Bar -->
        <!-- <TrustBar :stats="stats" /> -->

        <!-- About Section -->
        <AboutSection :about="aboutSection" />

        <!-- Featured Locations -->
        <FeaturedLocations :locations="featuredLocations" />

        <!-- Property Categories -->
        <PropertyCategories :featured-properties="featuredProperties" :property-types="propertyTypes" />

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

