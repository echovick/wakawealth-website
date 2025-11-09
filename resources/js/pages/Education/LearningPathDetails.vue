<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import {
    Clock,
    CheckCircle2,
    ArrowRight,
    Book,
    Video,
    FileText,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

interface Module {
    week: string;
    title: string;
    lessons: {
        title: string;
        duration: string;
        type: 'video' | 'reading' | 'quiz';
    }[];
}

interface LearningPath {
    id: number;
    title: string;
    slug: string;
    level: 'beginner' | 'intermediate' | 'advanced';
    description: string;
    duration: string;
    colorGradient: string;
    overview: string[];
    prerequisites: string[];
    outcomes: string[];
    modules: Module[];
}

interface Props {
    learningPath?: LearningPath;
}

const props = withDefaults(defineProps<Props>(), {
    learningPath: () => ({
        id: 1,
        title: 'First-Time Investors',
        slug: 'first-time-investors',
        level: 'beginner',
        description: 'Perfect for those taking their first steps into real estate investment. Build a solid foundation and make your first confident purchase.',
        duration: '4 weeks',
        colorGradient: 'from-blue-500 to-cyan-500',
        overview: [
            'Comprehensive introduction to real estate investment fundamentals',
            'Practical guidance on making your first property purchase',
            'Understanding financing options and legal requirements',
            'Risk mitigation strategies for new investors',
        ],
        prerequisites: [
            'No prior real estate experience required',
            'Basic understanding of personal finance recommended',
            'Commitment to 3-5 hours per week of study',
            'Access to computer and internet',
        ],
        outcomes: [
            'Complete your first property purchase with confidence',
            'Understand market dynamics and property valuation',
            'Navigate legal and financial requirements smoothly',
            'Build a personalized investment strategy',
            'Join a community of successful investors',
        ],
        modules: [
            {
                week: 'Week 1',
                title: 'Foundation & Market Understanding',
                lessons: [
                    { title: 'Introduction to Real Estate Investment', duration: '45 min', type: 'video' },
                    { title: 'Understanding the Nigerian Property Market', duration: '30 min', type: 'reading' },
                    { title: 'Types of Properties and Their Characteristics', duration: '40 min', type: 'video' },
                    { title: 'Week 1 Assessment', duration: '15 min', type: 'quiz' },
                ],
            },
            {
                week: 'Week 2',
                title: 'Financing & Budgeting',
                lessons: [
                    { title: 'Mortgage Options in Nigeria', duration: '50 min', type: 'video' },
                    { title: 'Payment Plans and Structuring', duration: '25 min', type: 'reading' },
                    { title: 'Creating Your Investment Budget', duration: '35 min', type: 'video' },
                    { title: 'Financial Planning Worksheet', duration: '20 min', type: 'quiz' },
                ],
            },
            {
                week: 'Week 3',
                title: 'Legal Framework & Documentation',
                lessons: [
                    { title: 'Title Verification Process', duration: '55 min', type: 'video' },
                    { title: 'Essential Legal Documents', duration: '30 min', type: 'reading' },
                    { title: 'Working with Lawyers and Agents', duration: '40 min', type: 'video' },
                    { title: 'Legal Knowledge Check', duration: '15 min', type: 'quiz' },
                ],
            },
            {
                week: 'Week 4',
                title: 'Making Your First Purchase',
                lessons: [
                    { title: 'Property Inspection Checklist', duration: '35 min', type: 'video' },
                    { title: 'Negotiation Strategies', duration: '45 min', type: 'video' },
                    { title: 'Common Pitfalls and How to Avoid Them', duration: '30 min', type: 'reading' },
                    { title: 'Final Capstone Project', duration: '60 min', type: 'quiz' },
                ],
            },
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

const getIconForType = (type: string) => {
    switch (type) {
        case 'video':
            return Video;
        case 'reading':
            return FileText;
        case 'quiz':
            return Book;
        default:
            return Book;
    }
};
</script>

<template>
    <Head :title="`${learningPath.title} - Learning Path`" />

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
                        href="/education/learning-paths"
                        class="inline-flex items-center text-gray-400 hover:text-white transition-colors"
                    >
                        <span>← Back to Learning Paths</span>
                    </Link>
                </div>

                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="inline-block px-4 py-2 rounded-full mb-4"
                        :class="`bg-gradient-to-r ${learningPath.colorGradient}`"
                    >
                        <span class="text-white font-bold text-sm uppercase">
                            {{ learningPath.level }} Level
                        </span>
                    </div>

                    <h1 class="mb-6 text-4xl font-bold text-white md:text-5xl">
                        {{ learningPath.title }}
                    </h1>

                    <p class="mx-auto max-w-4xl text-xl text-gray-300 mb-8">
                        {{ learningPath.description }}
                    </p>

                    <div class="flex items-center gap-2 mb-8 text-gray-300">
                        <Clock class="h-5 w-5 text-[#D31C00]" />
                        <span class="text-lg">{{ learningPath.duration }} • Self-paced</span>
                    </div>

                    <Link
                        href="/contact?type=learning-path"
                        class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 font-semibold text-white transition-colors hover:bg-[#B01700]"
                    >
                        <span>Enroll Now</span>
                        <ArrowRight class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- Overview -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div data-aos="fade-up">
                        <h2 class="mb-6 text-3xl font-bold text-white md:text-4xl">
                            Program <span class="text-[#D31C00]">Overview</span>
                        </h2>
                        <ul class="space-y-4">
                            <li
                                v-for="(item, index) in learningPath.overview"
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
                            Learning <span class="text-[#D31C00]">Outcomes</span>
                        </h2>
                        <ul class="space-y-4">
                            <li
                                v-for="(outcome, index) in learningPath.outcomes"
                                :key="index"
                                class="flex items-start gap-3"
                            >
                                <CheckCircle2 class="h-6 w-6 text-[#D31C00] flex-shrink-0 mt-0.5" />
                                <span class="text-gray-300 text-lg">{{ outcome }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Curriculum -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-12 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    Full <span class="text-[#D31C00]">Curriculum</span>
                </h2>

                <div class="max-w-4xl mx-auto space-y-6">
                    <div
                        v-for="(module, moduleIndex) in learningPath.modules"
                        :key="moduleIndex"
                        class="rounded-2xl border border-gray-800 bg-gray-900 overflow-hidden"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (moduleIndex * 50)"
                    >
                        <!-- Module Header -->
                        <div :class="`bg-gradient-to-r ${learningPath.colorGradient} p-6`">
                            <div class="text-sm font-semibold text-white/80 mb-1">
                                {{ module.week }}
                            </div>
                            <h3 class="text-2xl font-bold text-white">{{ module.title }}</h3>
                        </div>

                        <!-- Lessons -->
                        <div class="p-6">
                            <div class="space-y-3">
                                <div
                                    v-for="(lesson, lessonIndex) in module.lessons"
                                    :key="lessonIndex"
                                    class="flex items-center justify-between p-4 rounded-lg bg-black border border-gray-800 hover:border-[#D31C00] transition-colors"
                                >
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 rounded-lg bg-[#D31C00]/10 p-3">
                                            <component :is="getIconForType(lesson.type)" class="h-5 w-5 text-[#D31C00]" />
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white mb-1">
                                                {{ lesson.title }}
                                            </h4>
                                            <p class="text-sm text-gray-400 capitalize">
                                                {{ lesson.type }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-400 flex items-center gap-2">
                                        <Clock class="h-4 w-4" />
                                        {{ lesson.duration }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Prerequisites -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    <span class="text-[#D31C00]">Prerequisites</span>
                </h2>

                <div class="rounded-2xl border border-gray-800 bg-black p-8" data-aos="fade-up" data-aos-delay="100">
                    <ul class="space-y-4">
                        <li
                            v-for="(req, index) in learningPath.prerequisites"
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

        <!-- CTA Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-[#D31C00] to-[#B01700] py-20">
            <div class="absolute inset-0 bg-black/20" />
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/5" />
            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-white/5" />

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl" data-aos="fade-up">
                        Ready to Begin?
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Join hundreds of successful investors who started their journey with this path
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact?type=learning-path"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Enroll in This Path</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/education/learning-paths"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>View Other Paths</span>
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
