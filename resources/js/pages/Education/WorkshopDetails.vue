<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import {
    Calendar,
    Clock,
    Video,
    MapPin,
    Users,
    CheckCircle2,
    ArrowRight,
    User,
    Award,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

interface Workshop {
    id: number;
    title: string;
    slug: string;
    description: string;
    date: string;
    time: string;
    duration: string;
    format: string;
    seatsAvailable: number;
    isFree: boolean;
    status: 'upcoming' | 'past';
    category: 'beginner' | 'intermediate' | 'advanced';
    topics: string[];
    instructor: {
        name: string;
        title: string;
        bio: string;
    };
    whatYouWillLearn: string[];
    agenda: { time: string; topic: string; description: string }[];
    requirements: string[];
}

interface Props {
    workshop?: Workshop;
}

const props = withDefaults(defineProps<Props>(), {
    workshop: () => ({
        id: 1,
        title: 'Real Estate Investment 101: Getting Started',
        slug: 'real-estate-investment-101',
        description: 'Learn the fundamentals of real estate investment, from understanding market dynamics to making your first purchase. This comprehensive workshop is designed for beginners who want to build wealth through property investment.',
        date: 'November 15, 2025',
        time: '6:00 PM - 8:00 PM WAT',
        duration: '2 hours',
        format: 'Virtual (Zoom)',
        seatsAvailable: 45,
        isFree: true,
        status: 'upcoming',
        category: 'beginner',
        topics: ['Understanding the market', 'Financing basics', 'First steps to ownership', 'Legal requirements'],
        instructor: {
            name: 'Adebayo Okonkwo',
            title: 'Senior Investment Advisor',
            bio: 'With over 15 years of experience in real estate investment and property development, Adebayo has helped over 500 clients successfully navigate their property investment journey.',
        },
        whatYouWillLearn: [
            'How to identify profitable investment opportunities',
            'Understanding different property types and their ROI',
            'Financing options and mortgage basics',
            'Legal requirements and documentation process',
            'Common pitfalls and how to avoid them',
            'Building your investment strategy',
        ],
        agenda: [
            {
                time: '6:00 PM - 6:15 PM',
                topic: 'Introduction & Overview',
                description: 'Welcome and overview of real estate investment landscape in Nigeria',
            },
            {
                time: '6:15 PM - 6:45 PM',
                topic: 'Understanding the Market',
                description: 'Market dynamics, property types, and location analysis',
            },
            {
                time: '6:45 PM - 7:15 PM',
                topic: 'Financing Your Investment',
                description: 'Mortgage options, payment plans, and budgeting strategies',
            },
            {
                time: '7:15 PM - 7:45 PM',
                topic: 'Legal Framework',
                description: 'Documentation, title verification, and legal requirements',
            },
            {
                time: '7:45 PM - 8:00 PM',
                topic: 'Q&A Session',
                description: 'Open floor for questions and personalized advice',
            },
        ],
        requirements: [
            'No prior real estate knowledge required',
            'Stable internet connection for virtual attendance',
            'Note-taking materials recommended',
        ],
    }),
});

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

const relatedWorkshops = [
    {
        id: 2,
        title: 'Diaspora Investment: Building Back Home',
        slug: 'diaspora-investment-building-back-home',
        category: 'intermediate',
        date: 'November 22, 2025',
    },
    {
        id: 3,
        title: 'Portfolio Optimization Masterclass',
        slug: 'portfolio-optimization-masterclass',
        category: 'advanced',
        date: 'December 1, 2025',
    },
];

const faqs = [
    {
        question: 'Will I receive a certificate after completing the workshop?',
        answer: 'Yes! All participants who attend the full workshop will receive a digital certificate of attendance that you can add to your professional portfolio.',
    },
    {
        question: 'Is this workshop recorded?',
        answer: 'Absolutely. All workshops are recorded and made available to registered participants within 24 hours. You\'ll have lifetime access to the recording.',
    },
    {
        question: 'What if I can\'t attend the live session?',
        answer: 'No problem! Register anyway and you\'ll receive the recording. However, we highly recommend attending live to participate in Q&A and network with other investors.',
    },
    {
        question: 'Do I need any prior knowledge?',
        answer: 'This is a beginner-friendly workshop. No prior real estate investment knowledge is required. We\'ll start from the fundamentals and build up.',
    },
    {
        question: 'Can I ask questions during the workshop?',
        answer: 'Yes! We have dedicated Q&A segments, and our instructors encourage questions throughout the session to ensure everyone understands the concepts.',
    },
];

const testimonials = [
    {
        name: 'Chioma Adeleke',
        role: 'First-Time Investor',
        quote: 'This workshop gave me the confidence I needed to make my first purchase. Three months later, I own my first property!',
    },
    {
        name: 'Ibrahim Yusuf',
        role: 'Diaspora Investor',
        quote: 'As someone investing from abroad, the practical advice on remote management and title verification was invaluable.',
    },
];
</script>

<template>
    <Head :title="`${workshop.title} - Waka Wealth Realty`" />

    <div class="overflow-hidden bg-black">
        <!-- Hero Section -->
        <section
            class="relative min-h-[50vh] flex items-center justify-center bg-black overflow-hidden"
            @mousemove="handleMouseMove"
        >
            <div class="smoke-layer-1"></div>
            <div class="smoke-layer-2"></div>
            <div class="smoke-layer-3"></div>

            <div class="snow-container">
                <div v-for="i in 40" :key="i" class="snow-particle"></div>
            </div>

            <div
                class="cursor-spotlight"
                :style="{
                    left: `${spotlightPosition.x}%`,
                    top: `${spotlightPosition.y}%`,
                }"
            ></div>

            <div
                v-for="particle in smokeParticles"
                :key="particle.id"
                class="smoke-particle"
                :style="{
                    left: `${particle.x}px`,
                    top: `${particle.y}px`,
                }"
            ></div>

            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
                <div class="mb-6" data-aos="fade-up">
                    <Link
                        href="/education/workshops"
                        class="inline-flex items-center text-gray-400 hover:text-white transition-colors"
                    >
                        <span>← Back to Workshops</span>
                    </Link>
                </div>

                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <div
                            v-if="workshop.isFree"
                            class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400"
                        >
                            FREE
                        </div>
                        <div
                            class="px-3 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400 capitalize"
                        >
                            {{ workshop.category }}
                        </div>
                        <div
                            v-if="workshop.status === 'upcoming'"
                            class="px-3 py-1 rounded-full text-xs font-bold bg-[#D31C00]/20 text-[#D31C00]"
                        >
                            {{ workshop.seatsAvailable }} seats left
                        </div>
                    </div>

                    <h1 class="mb-6 text-4xl font-bold text-white md:text-5xl">
                        {{ workshop.title }}
                    </h1>

                    <p class="mx-auto max-w-4xl text-xl text-gray-300 mb-8">
                        {{ workshop.description }}
                    </p>

                    <div class="flex flex-wrap gap-6 mb-8 text-gray-300">
                        <div class="flex items-center gap-2">
                            <Calendar class="h-5 w-5 text-[#D31C00]" />
                            <span>{{ workshop.date }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Clock class="h-5 w-5 text-[#D31C00]" />
                            <span>{{ workshop.time }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Video class="h-5 w-5 text-[#D31C00]" />
                            <span>{{ workshop.format }}</span>
                        </div>
                    </div>

                    <Link
                        v-if="workshop.status === 'upcoming'"
                        href="/contact?type=workshop"
                        class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 font-semibold text-white transition-colors hover:bg-[#B01700]"
                    >
                        <span>Register Now</span>
                        <ArrowRight class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- What You'll Learn -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div data-aos="fade-up">
                        <h2 class="mb-6 text-3xl font-bold text-white md:text-4xl">
                            What You'll <span class="text-[#D31C00]">Learn</span>
                        </h2>
                        <ul class="space-y-4">
                            <li
                                v-for="(item, index) in workshop.whatYouWillLearn"
                                :key="index"
                                class="flex items-start gap-3"
                            >
                                <CheckCircle2 class="h-6 w-6 text-[#D31C00] flex-shrink-0 mt-0.5" />
                                <span class="text-gray-300 text-lg">{{ item }}</span>
                            </li>
                        </ul>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="100">
                        <h2 class="mb-6 text-3xl font-bold text-white md:text-4xl">
                            Workshop <span class="text-[#D31C00]">Agenda</span>
                        </h2>
                        <div class="space-y-4">
                            <div
                                v-for="(item, index) in workshop.agenda"
                                :key="index"
                                class="rounded-xl border border-gray-800 bg-black p-4"
                            >
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 rounded-lg bg-[#D31C00]/10 px-3 py-2">
                                        <Clock class="h-5 w-5 text-[#D31C00]" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-400 mb-1">
                                            {{ item.time }}
                                        </div>
                                        <h3 class="text-lg font-bold text-white mb-1">
                                            {{ item.topic }}
                                        </h3>
                                        <p class="text-sm text-gray-400">{{ item.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Instructor -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-12 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    Your <span class="text-[#D31C00]">Instructor</span>
                </h2>

                <div class="mx-auto max-w-3xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8">
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-shrink-0">
                                <div class="h-24 w-24 rounded-full bg-gradient-to-br from-[#D31C00] to-[#B01700] flex items-center justify-center">
                                    <User class="h-12 w-12 text-white" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-white mb-2">
                                    {{ workshop.instructor.name }}
                                </h3>
                                <p class="text-[#D31C00] font-semibold mb-4">
                                    {{ workshop.instructor.title }}
                                </p>
                                <p class="text-gray-300 leading-relaxed">
                                    {{ workshop.instructor.bio }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Requirements -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    <span class="text-[#D31C00]">Requirements</span>
                </h2>

                <div class="rounded-2xl border border-gray-800 bg-black p-8" data-aos="fade-up" data-aos-delay="100">
                    <ul class="space-y-4">
                        <li
                            v-for="(req, index) in workshop.requirements"
                            :key="index"
                            class="flex items-start gap-3"
                        >
                            <CheckCircle2 class="h-6 w-6 text-[#D31C00] flex-shrink-0 mt-0.5" />
                            <span class="text-gray-300 text-lg">{{ req }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-12 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    What Past <span class="text-[#D31C00]">Participants Say</span>
                </h2>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 max-w-5xl mx-auto">
                    <div
                        v-for="(testimonial, index) in testimonials"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-gray-900 p-8"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4 text-4xl text-[#D31C00]">"</div>
                        <p class="text-gray-300 text-lg mb-6 leading-relaxed italic">
                            {{ testimonial.quote }}
                        </p>
                        <div>
                            <div class="font-bold text-white">{{ testimonial.name }}</div>
                            <div class="text-sm text-gray-400">{{ testimonial.role }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-12 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    Frequently Asked <span class="text-[#D31C00]">Questions</span>
                </h2>

                <div class="space-y-6">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black p-8"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 50)"
                    >
                        <h3 class="mb-3 text-lg font-bold text-white">{{ faq.question }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ faq.answer }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Workshops -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-12 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    Related <span class="text-[#D31C00]">Workshops</span>
                </h2>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <Link
                        v-for="(related, index) in relatedWorkshops"
                        :key="related.id"
                        :href="`/education/workshops/${related.slug}`"
                        class="group rounded-2xl border border-gray-800 bg-gray-900 p-6 transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400 capitalize">
                                {{ related.category }}
                            </span>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white group-hover:text-[#D31C00] transition-colors">
                            {{ related.title }}
                        </h3>
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <Calendar class="h-4 w-4 text-[#D31C00]" />
                            <span>{{ related.date }}</span>
                        </div>
                    </Link>
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
                        {{ workshop.status === 'upcoming' ? 'Secure Your Spot Today' : 'View All Workshops' }}
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        {{ workshop.status === 'upcoming' ? 'Limited seats available. Register now to start your investment journey.' : 'Explore other workshops to continue your learning journey.' }}
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            v-if="workshop.status === 'upcoming'"
                            href="/contact?type=workshop"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Register Now</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/education/workshops"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>View All Workshops</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.smoke-layer-1,
.smoke-layer-2,
.smoke-layer-3 {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.smoke-layer-1 {
    background: radial-gradient(circle at 20% 30%, rgba(200, 210, 220, 0.6) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(210, 220, 230, 0.6) 0%, transparent 50%);
    animation: smokeFloat1 28s ease-in-out infinite;
}

.smoke-layer-2 {
    background: radial-gradient(circle at 60% 20%, rgba(190, 200, 210, 0.6) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(200, 210, 220, 0.6) 0%, transparent 50%);
    animation: smokeFloat2 32s ease-in-out infinite;
    animation-delay: -8s;
}

.smoke-layer-3 {
    background: radial-gradient(circle at 50% 50%, rgba(180, 190, 200, 0.6) 0%, transparent 50%),
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
