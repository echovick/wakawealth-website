<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import {
    BookOpen,
    Video,
    FileText,
    Users,
    Calendar,
    Download,
    Calculator,
    Award,
    TrendingUp,
    Shield,
    Building2,
    Clock,
    CheckCircle2,
    ArrowRight,
    Play,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

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

const educationPillars = [
    {
        icon: BookOpen,
        title: 'Knowledge is Wealth',
        description: 'We believe informed clients make better decisions. Education isn\'t optional—it\'s central to everything we do.',
    },
    {
        icon: Users,
        title: 'We Fish Together',
        description: 'We don\'t just give you fish—we teach you to fish, then we fish together. Partnership through education.',
    },
    {
        icon: Award,
        title: 'No Gatekeeping',
        description: 'No jargon, no confusion, total clarity. We empower, not gatekeep. Your success is our mission.',
    },
];

const resourceCategories = [
    {
        icon: Video,
        title: 'Free Monthly Workshops',
        description: 'Join our "Waka to Wealth" educational workshops covering everything from first-time buying to portfolio optimization.',
        features: ['Live Q&A Sessions', 'Expert Speakers', 'Recorded Access', 'Certificate of Attendance'],
        cta: 'View Schedule',
        link: '/education/workshops',
    },
    {
        icon: FileText,
        title: 'Investment Guides',
        description: 'Comprehensive downloadable guides covering every aspect of real estate investment, property acquisition, and wealth building.',
        features: ['Step-by-Step Guides', 'Checklists & Templates', 'Market Insights', 'Legal Frameworks'],
        cta: 'Browse Guides',
        link: '/education/guides',
    },
    {
        icon: Calculator,
        title: 'ROI Calculators',
        description: 'Interactive tools to calculate returns, compare investments, and plan your financial future with confidence.',
        features: ['Investment Calculator', 'Mortgage Estimator', 'Appreciation Projector', 'Portfolio Analyzer'],
        cta: 'Try Calculators',
        link: '/investment/calculator',
    },
    {
        icon: Users,
        title: 'One-on-One Consultations',
        description: 'Personalized sessions with our investment advisors to discuss your specific goals, challenges, and opportunities.',
        features: ['30-Min Free Consultation', 'Personalized Advice', 'Portfolio Review', 'Investment Strategy'],
        cta: 'Book Session',
        link: '/contact',
    },
];

const learningPaths = [
    {
        level: 'Beginner',
        title: 'First-Time Investors',
        topics: [
            'Understanding Real Estate Investment',
            'Types of Properties & Their Returns',
            'Financing Options & Budgeting',
            'Legal Requirements & Documentation',
            'Avoiding Common Pitfalls',
        ],
        duration: '4 weeks',
        color: 'from-blue-500 to-cyan-500',
    },
    {
        level: 'Intermediate',
        title: 'Growing Your Portfolio',
        topics: [
            'Portfolio Diversification Strategies',
            'Market Analysis & Timing',
            'Property Valuation Techniques',
            'Tax Optimization & Benefits',
            'Risk Management',
        ],
        duration: '6 weeks',
        color: 'from-purple-500 to-pink-500',
    },
    {
        level: 'Advanced',
        title: 'Wealth Maximization',
        topics: [
            'Commercial Property Investment',
            'Joint Ventures & Co-Investment',
            'Estate Planning & Legacy Building',
            'International Investment Strategies',
            'Advanced Portfolio Management',
        ],
        duration: '8 weeks',
        color: 'from-orange-500 to-red-500',
    },
];

const upcomingWorkshops = [
    {
        title: 'Real Estate Investment 101: Getting Started',
        date: 'November 15, 2025',
        time: '6:00 PM - 8:00 PM WAT',
        format: 'Virtual (Zoom)',
        topics: ['Understanding the market', 'Financing basics', 'First steps to ownership'],
        seats: '45 spots left',
        isFree: true,
    },
    {
        title: 'Diaspora Investment: Building Back Home',
        date: 'November 22, 2025',
        time: '3:00 PM - 5:00 PM GMT',
        format: 'Virtual (Zoom)',
        topics: ['Remote investment strategies', 'Legal considerations', 'Managing from abroad'],
        seats: '32 spots left',
        isFree: true,
    },
    {
        title: 'Portfolio Optimization Masterclass',
        date: 'December 1, 2025',
        time: '10:00 AM - 1:00 PM WAT',
        format: 'In-Person (Abuja Office)',
        topics: ['Advanced strategies', 'Tax optimization', 'Wealth transfer planning'],
        seats: '15 spots left',
        isFree: false,
    },
];

const blogPosts = [
    {
        title: 'Beyond the Hype: Why the Best Investments Begin with Unshakeable Trust',
        excerpt: 'The excitement fades, and one question takes its place: "How certain am I?" Discover why trust is the foundation of true wealth in real estate.',
        category: 'Investment Strategy',
        readTime: '8 min read',
        slug: 'beyond-the-hype-trust',
    },
    {
        title: 'The Complete Guide to Site & Services Investment in Abuja',
        excerpt: 'Everything you need to know about purchasing land in Abuja, from verification to construction. A comprehensive walkthrough.',
        category: 'Beginner Guide',
        readTime: '12 min read',
        slug: 'complete-guide-sites-services',
    },
    {
        title: 'Diaspora Investment: 5 Common Mistakes to Avoid',
        excerpt: 'Investing from abroad comes with unique challenges. Learn the pitfalls to avoid and strategies that actually work.',
        category: 'Diaspora',
        readTime: '6 min read',
        slug: 'diaspora-mistakes-avoid',
    },
];

const faqs = [
    {
        question: 'Are the workshops really free?',
        answer: 'Yes! Our monthly "Waka to Wealth" workshops are completely free. We believe education should be accessible to everyone. Some specialized masterclasses may have a nominal fee to cover materials.',
    },
    {
        question: 'Do I need to be a client to access educational resources?',
        answer: 'No. Our educational resources are available to everyone, whether you\'re a current client, potential investor, or just learning about real estate. Knowledge is for all.',
    },
    {
        question: 'How do I register for workshops?',
        answer: 'Simply click "Register Now" on any workshop, fill out the short form with your details, and you\'ll receive a confirmation email with the access link.',
    },
    {
        question: 'Are sessions recorded if I can\'t attend live?',
        answer: 'Yes! All workshops are recorded and sent to registered participants within 24 hours. You\'ll have lifetime access to watch at your convenience.',
    },
    {
        question: 'Can I request a specific topic for a workshop?',
        answer: 'Absolutely! We design our curriculum based on community needs. Contact us with topic suggestions and we\'ll consider them for upcoming sessions.',
    },
];

const stats = [
    { number: '50+', label: 'Workshops Conducted' },
    { number: '2,000+', label: 'Students Educated' },
    { number: '25+', label: 'Free Resources' },
    { number: '4.9/5', label: 'Average Rating' },
];
</script>

<template>
    <Head title="Education - Waka Wealth Realty" />

    <div class="overflow-hidden bg-black">
        <!-- Hero Section with Smoke Effect -->
        <section
            class="relative min-h-[60vh] flex items-center justify-center bg-black overflow-hidden"
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
                        Learn, Grow, <span class="text-[#D31C00]">Prosper</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300 mb-8">
                        Empowering you with the knowledge and tools to make confident, informed investment decisions
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <Link
                            href="#workshops"
                            class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 font-semibold text-white transition-colors hover:bg-[#B01700]"
                        >
                            <span>View Workshops</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/contact"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-[#D31C00] bg-transparent px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-[#D31C00] hover:text-white"
                        >
                            <span>Book Consultation</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="bg-gray-900 py-12 border-b border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                    <div
                        v-for="(stat, index) in stats"
                        :key="index"
                        class="text-center"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="text-4xl font-bold text-[#D31C00]">{{ stat.number }}</div>
                        <div class="mt-1 text-sm font-medium text-gray-400">{{ stat.label }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Education Philosophy -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Our <span class="text-[#D31C00]">Philosophy</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Education isn't optional—it's central to everything we do. We believe informed clients make better decisions.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div
                        v-for="(pillar, index) in educationPillars"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-gray-900 p-8 text-center transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <component :is="pillar.icon" class="h-8 w-8 text-[#D31C00]" />
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">{{ pillar.title }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ pillar.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Resource Categories -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Learning <span class="text-[#D31C00]">Resources</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        From live workshops to downloadable guides, we provide everything you need to succeed
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div
                        v-for="(category, index) in resourceCategories"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black p-8 transition-all hover:border-[#D31C00]"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="inline-flex rounded-full bg-[#D31C00]/10 p-4">
                                    <component :is="category.icon" class="h-8 w-8 text-[#D31C00]" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="mb-3 text-2xl font-bold text-white">{{ category.title }}</h3>
                                <p class="text-gray-400 leading-relaxed mb-4">{{ category.description }}</p>

                                <ul class="space-y-2 mb-6">
                                    <li
                                        v-for="(feature, idx) in category.features"
                                        :key="idx"
                                        class="flex items-center gap-2 text-gray-300"
                                    >
                                        <CheckCircle2 class="h-4 w-4 text-[#D31C00] flex-shrink-0" />
                                        <span>{{ feature }}</span>
                                    </li>
                                </ul>

                                <Link
                                    :href="category.link"
                                    class="inline-flex items-center space-x-2 text-[#D31C00] font-semibold hover:underline"
                                >
                                    <span>{{ category.cta }}</span>
                                    <ArrowRight class="h-5 w-5" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Learning Paths -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Learning <span class="text-[#D31C00]">Paths</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Structured curriculum designed for every stage of your investment journey
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <div
                        v-for="(path, index) in learningPaths"
                        :key="index"
                        class="rounded-2xl border-2 border-gray-800 bg-gray-900 overflow-hidden transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 150)"
                    >
                        <!-- Header -->
                        <div :class="`bg-gradient-to-br ${path.color} p-6`">
                            <div class="text-sm font-semibold text-white/80 mb-2">{{ path.level }}</div>
                            <h3 class="text-2xl font-bold text-white mb-2">{{ path.title }}</h3>
                            <div class="flex items-center gap-2 text-white/90">
                                <Clock class="h-4 w-4" />
                                <span class="text-sm">{{ path.duration }}</span>
                            </div>
                        </div>

                        <!-- Topics -->
                        <div class="p-6">
                            <h4 class="text-sm font-semibold text-gray-400 mb-4">TOPICS COVERED</h4>
                            <ul class="space-y-3">
                                <li
                                    v-for="(topic, idx) in path.topics"
                                    :key="idx"
                                    class="flex items-start gap-2 text-gray-300"
                                >
                                    <CheckCircle2 class="h-4 w-4 text-[#D31C00] flex-shrink-0 mt-0.5" />
                                    <span class="text-sm">{{ topic }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Upcoming Workshops -->
        <section id="workshops" class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Upcoming <span class="text-[#D31C00]">Workshops</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Join our free monthly "Waka to Wealth" workshops and learn from industry experts
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <div
                        v-for="(workshop, index) in upcomingWorkshops"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black overflow-hidden transition-all hover:border-[#D31C00]"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    v-if="workshop.isFree"
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400"
                                >
                                    FREE
                                </div>
                                <div
                                    v-else
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-[#D31C00]/20 text-[#D31C00]"
                                >
                                    PREMIUM
                                </div>
                                <div class="text-xs font-medium text-gray-400">{{ workshop.seats }}</div>
                            </div>

                            <h3 class="mb-4 text-xl font-bold text-white leading-tight">{{ workshop.title }}</h3>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <Calendar class="h-4 w-4 text-[#D31C00]" />
                                    <span>{{ workshop.date }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <Clock class="h-4 w-4 text-[#D31C00]" />
                                    <span>{{ workshop.time }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <Video class="h-4 w-4 text-[#D31C00]" />
                                    <span>{{ workshop.format }}</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-xs font-semibold text-gray-400 mb-2">TOPICS:</h4>
                                <ul class="space-y-1">
                                    <li
                                        v-for="(topic, idx) in workshop.topics"
                                        :key="idx"
                                        class="text-sm text-gray-300 flex items-start gap-2"
                                    >
                                        <span class="text-[#D31C00] mt-1">•</span>
                                        <span>{{ topic }}</span>
                                    </li>
                                </ul>
                            </div>

                            <Link
                                href="/contact?type=workshop"
                                class="w-full flex items-center justify-center space-x-2 rounded-sm bg-[#D31C00] px-6 py-3 font-semibold text-white transition-colors hover:bg-[#B01700]"
                            >
                                <span>Register Now</span>
                                <ArrowRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="400">
                    <Link
                        href="/education/workshops"
                        class="inline-flex items-center space-x-2 text-[#D31C00] font-semibold hover:underline"
                    >
                        <span>View All Workshops</span>
                        <ArrowRight class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- Blog Posts -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Latest <span class="text-[#D31C00]">Insights</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Expert articles on real estate investment, market trends, and wealth-building strategies
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <Link
                        v-for="(post, index) in blogPosts"
                        :key="index"
                        :href="`/education/blog/${post.slug}`"
                        class="group rounded-2xl border border-gray-800 bg-gray-900 overflow-hidden transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="relative h-48 bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#D31C00] text-white">
                                    {{ post.category }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-2 flex items-center gap-2 text-xs text-gray-400">
                                <Clock class="h-3 w-3" />
                                <span>{{ post.readTime }}</span>
                            </div>
                            <h3 class="mb-3 text-xl font-bold text-white group-hover:text-[#D31C00] transition-colors leading-tight">
                                {{ post.title }}
                            </h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                                {{ post.excerpt }}
                            </p>
                            <div class="flex items-center text-[#D31C00] font-semibold text-sm">
                                <span>Read More</span>
                                <ArrowRight class="h-4 w-4 ml-2 transition-transform group-hover:translate-x-2" />
                            </div>
                        </div>
                    </Link>
                </div>

                <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="400">
                    <Link
                        href="/education/blog"
                        class="inline-flex items-center space-x-2 rounded-sm border-2 border-[#D31C00] bg-transparent px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-[#D31C00] hover:text-white"
                    >
                        <span>View All Articles</span>
                        <ArrowRight class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Common <span class="text-[#D31C00]">Questions</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Everything you need to know about our educational programs
                    </p>
                </div>

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

        <!-- CTA Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-[#D31C00] to-[#B01700] py-20">
            <div class="absolute inset-0 bg-black/20" />
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/5" />
            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-white/5" />

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl" data-aos="fade-up">
                        Start Your Learning Journey Today
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        We don't just give you fish—we teach you to fish, then we fish together
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact?type=workshop"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Join Next Workshop</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/contact"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>Book Free Consultation</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </div>
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
