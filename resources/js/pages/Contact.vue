<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import BookConsultationModal from '@/components/BookConsultationModal.vue';
import JoinCommunityModal from '@/components/JoinCommunityModal.vue';
import {
    MapPin,
    Phone,
    Mail,
    Clock,
    MessageSquare,
    Calendar,
    User,
    Building2,
    Send,
    CheckCircle2,
    ArrowRight,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

const showConsultationModal = ref(false);
const showCommunityModal = ref(false);

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

const form = useForm({
    name: '',
    email: '',
    phone: '',
    inquiry_type: 'general',
    subject: '',
    message: '',
});

const submitForm = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const contactInfo = [
    {
        icon: MapPin,
        title: 'Office Address',
        details: ['123 Waka Street, Wuye District', 'Abuja, FCT, Nigeria'],
        link: null,
    },
    {
        icon: Phone,
        title: 'Phone Numbers',
        details: ['+234 803 418 0012', '+234 911 704 2900'],
        link: 'tel:+2348034180012',
    },
    {
        icon: Mail,
        title: 'Email Address',
        details: ['info@wakawealth.com', 'support@wakawealth.com'],
        link: 'mailto:info@wakawealth.com',
    },
    {
        icon: Clock,
        title: 'Business Hours',
        details: ['Monday - Friday: 9:00 AM - 6:00 PM', 'Saturday: 10:00 AM - 4:00 PM', 'Sunday: Closed'],
        link: null,
    },
];

const inquiryTypes = [
    { value: 'general', label: 'General Inquiry' },
    { value: 'property', label: 'Property Investment' },
    { value: 'workshop', label: 'Workshop Registration' },
    { value: 'consultation', label: 'Book Consultation' },
    { value: 'diaspora', label: 'Diaspora Investment' },
    { value: 'partnership', label: 'Partnership Opportunity' },
];

const quickActions = [
    {
        icon: Calendar,
        title: 'Book Free Consultation',
        description: '30-minute one-on-one session with our investment advisors',
        cta: 'Schedule Now',
        action: 'consultation',
    },
    {
        icon: Building2,
        title: 'Visit Our Office',
        description: 'Tour our office and view property portfolios in person',
        cta: 'Get Directions',
        action: 'map',
    },
    {
        icon: MessageSquare,
        title: 'Join Our Community',
        description: 'Connect with other investors and get exclusive updates',
        cta: 'Join Now',
        action: 'community',
    },
];

const handleQuickAction = (action: string) => {
    if (action === 'consultation') {
        showConsultationModal.value = true;
    } else if (action === 'community') {
        showCommunityModal.value = true;
    } else if (action === 'map') {
        document.getElementById('map')?.scrollIntoView({ behavior: 'smooth' });
    }
};

const faqs = [
    {
        question: 'How quickly will I receive a response?',
        answer: 'We typically respond to all inquiries within 24 hours during business days. Urgent matters are prioritized and often receive same-day responses.',
    },
    {
        question: 'Can I visit the office without an appointment?',
        answer: 'While walk-ins are welcome, we recommend scheduling an appointment to ensure our team is available to give you dedicated attention and access to property portfolios.',
    },
    {
        question: 'Do you offer virtual consultations?',
        answer: 'Yes! We offer virtual consultations via Zoom, Google Meet, or phone for clients who cannot visit in person, especially our diaspora investors.',
    },
    {
        question: 'Is the consultation really free?',
        answer: 'Absolutely. Our 30-minute consultation is completely free with no obligation. We believe in education-first approach and want to help you make informed decisions.',
    },
];
</script>

<template>
    <Head title="Contact Us - Waka Wealth Realty" />

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
                        Let's <span class="text-[#D31C00]">Connect</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300">
                        Ready to start your wealth-building journey? We're here to guide you every step of the way
                    </p>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="bg-gray-900 py-12 border-b border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <button
                        v-for="(action, index) in quickActions"
                        :key="index"
                        @click="handleQuickAction(action.action)"
                        class="group rounded-2xl border border-gray-800 bg-black p-6 transition-all hover:border-[#D31C00] hover:scale-105 text-left cursor-pointer"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="inline-flex rounded-full bg-[#D31C00]/10 p-3">
                                    <component :is="action.icon" class="h-6 w-6 text-[#D31C00]" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="mb-2 text-lg font-bold text-white">{{ action.title }}</h3>
                                <p class="text-sm text-gray-400 mb-3">{{ action.description }}</p>
                                <span class="inline-flex items-center text-[#D31C00] font-semibold text-sm group-hover:underline">
                                    {{ action.cta }}
                                    <ArrowRight class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-2" />
                                </span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </section>

        <!-- Main Contact Section -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                    <!-- Contact Form -->
                    <div data-aos="fade-right">
                        <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">
                            Send Us a <span class="text-[#D31C00]">Message</span>
                        </h2>
                        <p class="mb-8 text-lg text-gray-400">
                            Fill out the form below and we'll get back to you within 24 hours
                        </p>

                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">
                                    Full Name *
                                </label>
                                <div class="relative">
                                    <User class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500" />
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        required
                                        class="w-full rounded-sm border border-gray-700 bg-gray-900 py-3 pl-12 pr-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                        placeholder="Enter your full name"
                                    />
                                </div>
                                <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">
                                    Email Address *
                                </label>
                                <div class="relative">
                                    <Mail class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500" />
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        required
                                        class="w-full rounded-sm border border-gray-700 bg-gray-900 py-3 pl-12 pr-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                        placeholder="Enter your email"
                                    />
                                </div>
                                <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">{{ form.errors.email }}</p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-300 mb-2">
                                    Phone Number
                                </label>
                                <div class="relative">
                                    <Phone class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500" />
                                    <input
                                        id="phone"
                                        v-model="form.phone"
                                        type="tel"
                                        class="w-full rounded-sm border border-gray-700 bg-gray-900 py-3 pl-12 pr-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                        placeholder="+234 800 000 0000"
                                    />
                                </div>
                                <p v-if="form.errors.phone" class="mt-1 text-sm text-red-500">{{ form.errors.phone }}</p>
                            </div>

                            <!-- Inquiry Type -->
                            <div>
                                <label for="inquiry_type" class="block text-sm font-semibold text-gray-300 mb-2">
                                    Inquiry Type *
                                </label>
                                <select
                                    id="inquiry_type"
                                    v-model="form.inquiry_type"
                                    required
                                    class="w-full rounded-sm border border-gray-700 bg-gray-900 py-3 px-4 text-white focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                >
                                    <option v-for="type in inquiryTypes" :key="type.value" :value="type.value">
                                        {{ type.label }}
                                    </option>
                                </select>
                                <p v-if="form.errors.inquiry_type" class="mt-1 text-sm text-red-500">{{ form.errors.inquiry_type }}</p>
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-300 mb-2">
                                    Subject *
                                </label>
                                <input
                                    id="subject"
                                    v-model="form.subject"
                                    type="text"
                                    required
                                    class="w-full rounded-sm border border-gray-700 bg-gray-900 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                    placeholder="What's this about?"
                                />
                                <p v-if="form.errors.subject" class="mt-1 text-sm text-red-500">{{ form.errors.subject }}</p>
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-300 mb-2">
                                    Message *
                                </label>
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    required
                                    rows="6"
                                    class="w-full rounded-sm border border-gray-700 bg-gray-900 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                    placeholder="Tell us more about your inquiry..."
                                ></textarea>
                                <p v-if="form.errors.message" class="mt-1 text-sm text-red-500">{{ form.errors.message }}</p>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full flex items-center justify-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 font-semibold text-white transition-colors hover:bg-[#B01700] disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span>{{ form.processing ? 'Sending...' : 'Send Message' }}</span>
                                <Send class="h-5 w-5" />
                            </button>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div data-aos="fade-left">
                        <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">
                            Get in <span class="text-[#D31C00]">Touch</span>
                        </h2>
                        <p class="mb-8 text-lg text-gray-400">
                            Reach out through any of these channels. We're always happy to help.
                        </p>

                        <div class="space-y-6">
                            <div
                                v-for="(info, index) in contactInfo"
                                :key="index"
                                class="rounded-2xl border border-gray-800 bg-gray-900 p-6 transition-all hover:border-[#D31C00]"
                                data-aos="fade-up"
                                :data-aos-delay="100 + (index * 100)"
                            >
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="inline-flex rounded-full bg-[#D31C00]/10 p-3">
                                            <component :is="info.icon" class="h-6 w-6 text-[#D31C00]" />
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="mb-2 text-lg font-bold text-white">{{ info.title }}</h3>
                                        <div class="space-y-1">
                                            <p
                                                v-for="(detail, idx) in info.details"
                                                :key="idx"
                                                class="text-gray-400"
                                            >
                                                <a
                                                    v-if="info.link && idx === 0"
                                                    :href="info.link"
                                                    class="hover:text-[#D31C00] transition-colors"
                                                >
                                                    {{ detail }}
                                                </a>
                                                <span v-else>{{ detail }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mt-8 rounded-2xl border border-gray-800 bg-gray-900 p-6" data-aos="fade-up" data-aos-delay="500">
                            <h3 class="mb-4 text-lg font-bold text-white">Follow Us</h3>
                            <div class="flex gap-4">
                                <a
                                    href="#"
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-800 text-gray-400 transition-all hover:bg-[#D31C00] hover:text-white"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a
                                    href="#"
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-800 text-gray-400 transition-all hover:bg-[#D31C00] hover:text-white"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                <a
                                    href="#"
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-800 text-gray-400 transition-all hover:bg-[#D31C00] hover:text-white"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                                <a
                                    href="#"
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-800 text-gray-400 transition-all hover:bg-[#D31C00] hover:text-white"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section id="map" class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Visit Our <span class="text-[#D31C00]">Office</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Located in the heart of Wuye, Abuja. Easy to find and always open to welcome you.
                    </p>
                </div>

                <div class="rounded-2xl overflow-hidden border border-gray-800" data-aos="fade-up" data-aos-delay="200">
                    <!-- Map Placeholder -->
                    <div class="relative h-[500px] bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                        <div class="text-center">
                            <MapPin class="h-16 w-16 text-[#D31C00] mx-auto mb-4" />
                            <p class="text-xl font-semibold text-white mb-2">123 Waka Street, Wuye District</p>
                            <p class="text-gray-400 mb-6">Abuja, FCT, Nigeria</p>
                            <a
                                href="https://maps.google.com"
                                target="_blank"
                                class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-6 py-3 font-semibold text-white transition-colors hover:bg-[#B01700]"
                            >
                                <span>Get Directions</span>
                                <ArrowRight class="h-5 w-5" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Common <span class="text-[#D31C00]">Questions</span>
                    </h2>
                </div>

                <div class="space-y-6">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-gray-900 p-8"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 50)"
                    >
                        <h3 class="mb-3 text-lg font-bold text-white">{{ faq.question }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ faq.answer }}</p>
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
                        We Walk With You to Wealth
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Your journey to financial freedom starts with a conversation. Let's talk about your goals.
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/properties"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>View Properties</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/education"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>Explore Resources</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <BookConsultationModal v-model:isOpen="showConsultationModal" />
    <JoinCommunityModal v-model:isOpen="showCommunityModal" />
</template>

<style scoped>
/* Reuse smoke effect styles */
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
