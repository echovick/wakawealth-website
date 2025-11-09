<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import {
    Clock,
    CheckCircle2,
    ArrowRight,
    Award,
    TrendingUp,
    Users,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

interface LearningPath {
    id: number;
    title: string;
    slug: string;
    level: 'beginner' | 'intermediate' | 'advanced';
    description: string;
    duration: string;
    topics: string[];
    colorGradient: string;
    outcomes: string[];
}

interface Props {
    learningPaths?: LearningPath[];
}

const props = withDefaults(defineProps<Props>(), {
    learningPaths: () => [],
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

const mockLearningPaths: LearningPath[] = [
    {
        id: 1,
        title: 'First-Time Investors',
        slug: 'first-time-investors',
        level: 'beginner',
        description: 'Perfect for those taking their first steps into real estate investment. Build a solid foundation and make your first confident purchase.',
        duration: '4 weeks',
        topics: [
            'Understanding Real Estate Investment',
            'Types of Properties & Their Returns',
            'Financing Options & Budgeting',
            'Legal Requirements & Documentation',
            'Avoiding Common Pitfalls',
        ],
        colorGradient: 'from-blue-500 to-cyan-500',
        outcomes: [
            'Complete your first property purchase with confidence',
            'Understand market dynamics and property valuation',
            'Navigate legal and financial requirements smoothly',
        ],
    },
    {
        id: 2,
        title: 'Growing Your Portfolio',
        slug: 'growing-your-portfolio',
        level: 'intermediate',
        description: 'For investors ready to expand. Learn strategic diversification, market analysis, and portfolio management techniques.',
        duration: '6 weeks',
        topics: [
            'Portfolio Diversification Strategies',
            'Market Analysis & Timing',
            'Property Valuation Techniques',
            'Tax Optimization & Benefits',
            'Risk Management',
        ],
        colorGradient: 'from-purple-500 to-pink-500',
        outcomes: [
            'Build a diversified property portfolio',
            'Master market analysis and timing strategies',
            'Optimize tax benefits and maximize returns',
        ],
    },
    {
        id: 3,
        title: 'Wealth Maximization',
        slug: 'wealth-maximization',
        level: 'advanced',
        description: 'Advanced strategies for experienced investors focused on wealth creation, estate planning, and legacy building.',
        duration: '8 weeks',
        topics: [
            'Commercial Property Investment',
            'Joint Ventures & Co-Investment',
            'Estate Planning & Legacy Building',
            'International Investment Strategies',
            'Advanced Portfolio Management',
        ],
        colorGradient: 'from-orange-500 to-red-500',
        outcomes: [
            'Master advanced investment strategies',
            'Build generational wealth through real estate',
            'Develop expertise in commercial properties',
        ],
    },
];

const displayPaths = props.learningPaths.length > 0 ? props.learningPaths : mockLearningPaths;

const benefits = [
    {
        icon: Award,
        title: 'Structured Curriculum',
        description: 'Step-by-step progression designed by industry experts with over 15 years of experience',
    },
    {
        icon: Users,
        title: 'Community Support',
        description: 'Join a network of like-minded investors, share experiences, and learn together',
    },
    {
        icon: TrendingUp,
        title: 'Proven Results',
        description: 'Our students have collectively invested over ₦2 billion in real estate',
    },
];

const testimonials = [
    {
        name: 'Chioma Adeleke',
        path: 'First-Time Investors',
        quote: 'The structured approach gave me the confidence to make my first investment. Within 3 months, I purchased my first property!',
    },
    {
        name: 'Ibrahim Yusuf',
        path: 'Growing Your Portfolio',
        quote: 'The portfolio optimization strategies helped me increase my ROI by 40%. Best investment in my education.',
    },
];
</script>

<template>
    <Head title="Learning Paths - Waka Wealth Realty" />

    <div class="overflow-hidden bg-black">
        <!-- Hero Section -->
        <section
            class="relative min-h-[60vh] flex items-center justify-center bg-black overflow-hidden"
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

            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 text-center">
                <div data-aos="fade-up" data-aos-delay="200">
                    <h1 class="mb-6 text-5xl font-bold text-white md:text-6xl">
                        Structured <span class="text-[#D31C00]">Learning Paths</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300 mb-8">
                        Guided curriculum designed for every stage of your investment journey—from first purchase to wealth mastery
                    </p>
                </div>
            </div>
        </section>

        <!-- Learning Paths Grid -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Choose Your <span class="text-[#D31C00]">Path</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Select the learning path that matches your current experience level
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <div
                        v-for="(path, index) in displayPaths"
                        :key="path.id"
                        class="rounded-2xl border-2 border-gray-800 bg-black overflow-hidden transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 150)"
                    >
                        <!-- Header -->
                        <div :class="`bg-gradient-to-br ${path.colorGradient} p-6`">
                            <div class="text-sm font-semibold text-white/80 mb-2 uppercase">
                                {{ path.level }}
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-2">{{ path.title }}</h3>
                            <div class="flex items-center gap-2 text-white/90">
                                <Clock class="h-4 w-4" />
                                <span class="text-sm">{{ path.duration }}</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <p class="text-gray-400 mb-6 leading-relaxed">
                                {{ path.description }}
                            </p>

                            <!-- Topics -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-400 mb-4 uppercase">
                                    Topics Covered
                                </h4>
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

                            <!-- Outcomes -->
                            <div class="mb-6 rounded-xl bg-gray-900 p-4">
                                <h4 class="text-sm font-semibold text-gray-400 mb-3 uppercase">
                                    What You'll Achieve
                                </h4>
                                <ul class="space-y-2">
                                    <li
                                        v-for="(outcome, idx) in path.outcomes"
                                        :key="idx"
                                        class="text-sm text-gray-300"
                                    >
                                        • {{ outcome }}
                                    </li>
                                </ul>
                            </div>

                            <!-- CTA -->
                            <Link
                                :href="`/education/learning-paths/${path.slug}`"
                                class="w-full flex items-center justify-center space-x-2 rounded-sm bg-[#D31C00] px-6 py-3 font-semibold text-white transition-colors hover:bg-[#B01700]"
                            >
                                <span>View Full Curriculum</span>
                                <ArrowRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Why Choose <span class="text-[#D31C00]">Structured Learning</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Our learning paths are designed to take you from knowledge to action
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div
                        v-for="(benefit, index) in benefits"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-gray-900 p-8 text-center transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <component :is="benefit.icon" class="h-8 w-8 text-[#D31C00]" />
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">{{ benefit.title }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ benefit.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Student <span class="text-[#D31C00]">Success Stories</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div
                        v-for="(testimonial, index) in testimonials"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black p-8"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4 text-4xl text-[#D31C00]">"</div>
                        <p class="text-gray-300 text-lg mb-6 leading-relaxed italic">
                            {{ testimonial.quote }}
                        </p>
                        <div>
                            <div class="font-bold text-white">{{ testimonial.name }}</div>
                            <div class="text-sm text-gray-400">{{ testimonial.path }} Graduate</div>
                        </div>
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
                        Start Your Journey Today
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Choose your path and begin building the wealth you deserve
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact?type=learning-path"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Enroll Now</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/education/workshops"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>Try a Free Workshop First</span>
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
