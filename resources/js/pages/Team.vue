<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Award, Briefcase, Heart, Users, ArrowRight } from 'lucide-vue-next';
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

const highlights = [
    {
        icon: Award,
        title: 'Harvard Business School Alumni',
        description: 'Global business intelligence and executive-level strategy',
    },
    {
        icon: Briefcase,
        title: 'Real Estate Strategist',
        description: 'Years of hands-on experience in property advisory and investment management',
    },
    {
        icon: Heart,
        title: 'Mentor & Builder',
        description: 'Dedicated to empowering entrepreneurs and supporting women in business',
    },
    {
        icon: Users,
        title: 'Visionary Leader',
        description: 'Building a movement that champions progress and African ambition',
    },
];
</script>

<template>
    <Head title="Our Team - Waka Wealth Realty" />

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
                        Meet Our <span class="text-[#D31C00]">Leadership</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300">
                        Guided by vision, driven by excellence, committed to your success
                    </p>
                </div>
            </div>
        </section>

        <!-- CEO Profile Section -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
                    <!-- Image -->
                    <div class="relative" data-aos="fade-right" data-aos-delay="100">
                        <div class="relative overflow-hidden rounded-2xl">
                            <img
                                src="/assets/20251029_195245.jpg"
                                alt="Comfort Amos-Kwari, CEO of Waka Wealth"
                                class="w-full h-auto object-cover"
                            />
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute -bottom-6 -left-6 rounded-2xl bg-black border border-gray-800 p-6 shadow-xl">
                            <div class="text-center">
                                <div class="text-xl font-bold text-white mb-1">Comfort Amos-Kwari</div>
                                <div class="text-sm font-medium text-[#D31C00]">
                                    CEO & Founder
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bio Content -->
                    <div data-aos="fade-left" data-aos-delay="200">
                        <div class="mb-4 inline-block">
                            <span class="rounded-full bg-[#D31C00]/20 px-4 py-1.5 text-sm font-semibold text-[#D31C00]">
                                Leadership
                            </span>
                        </div>
                        <h2 class="mb-6 text-4xl font-bold text-white md:text-5xl">
                            Comfort <span class="text-[#D31C00]">Amos-Kwari</span>
                        </h2>
                        <div class="space-y-4 text-lg leading-relaxed text-gray-300">
                            <p>
                                Comfort Amos-Kwari is an accomplished business leader, real estate strategist, and the pioneering CEO of Waka Wealth. With years of hands-on experience across property advisory, investment management, and organizational leadership, she brings a rare combination of insight, competence, and unwavering excellence to the real estate and wealth-building space.
                            </p>
                            <p>
                                A proud alumna of <span class="font-semibold text-white">Harvard Business School</span>, Comfort embodies global business intelligence, analytical depth, and executive-level strategy. Her HBS training strengthened her ability to scale organizations, structure profitable deals, create systems that drive growth, and lead teams with clarity and discipline.
                            </p>
                            <p>
                                Throughout her career, Comfort has consistently demonstrated mastery in identifying high-value opportunities, managing complex transactions, and providing advisory that transforms financial outcomes. She is known for her ability to blend data, intuition, and cultural intelligence, ensuring that every client she works with is empowered to make informed and sustainable wealth decisions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Philosophy Section -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-4xl text-center" data-aos="fade-up">
                    <div class="mb-8 rounded-2xl border-2 border-[#D31C00] bg-[#D31C00]/5 p-8 md:p-12">
                        <p class="text-2xl md:text-3xl font-bold text-white leading-relaxed italic mb-4">
                            "Wealth is a journey and no one should walk it alone."
                        </p>
                        <p class="text-lg text-gray-300 leading-relaxed">
                            At the heart of Waka Wealth is her belief that wealth is a journey and no one should walk it alone. Comfort's leadership reflects this philosophy: intentional, collaborative, and deeply committed to guiding clients from their first step into property ownership to the building of multi-generational legacies.
                        </p>
                    </div>

                    <div class="space-y-4 text-lg leading-relaxed text-gray-300" data-aos="fade-up" data-aos-delay="200">
                        <p>
                            Her approach is rooted in <span class="font-semibold text-white">integrity, innovation, and a genuine passion</span> for elevating lives through strategic real estate and investment solutions.
                        </p>
                        <p>
                            Under her vision, Waka Wealth stands as a movement, one that champions progress, opportunity, and the boldness of African ambition.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Highlights -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Leadership <span class="text-[#D31C00]">Excellence</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(highlight, index) in highlights"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black p-8 text-center transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <component :is="highlight.icon" class="h-8 w-8 text-[#D31C00]" />
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">{{ highlight.title }}</h3>
                        <p class="text-gray-400">{{ highlight.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Impact & Mission -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-4xl">
                    <div class="space-y-6 text-lg leading-relaxed text-gray-300" data-aos="fade-up">
                        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8">
                            <h3 class="mb-4 text-2xl font-bold text-white">Beyond Business</h3>
                            <p class="mb-4">
                                Beyond her corporate achievements, Comfort is a mentor, a builder of people, and a voice of inspiration. She is dedicated to empowering young entrepreneurs, supporting women in business, and reshaping the narrative around wealth creation across Africa.
                            </p>
                            <p class="font-semibold text-white">
                                In every sense, Comfort is not just leading Waka Wealth—she is walking the journey with everyone who chooses to step into a wealthier future.
                            </p>
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
                        Ready to Walk into Wealth?
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Join us on the journey to financial freedom. Let's build your legacy together.
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Get Started</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/properties"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>View Properties</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
/* Smoke Layers */
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
    0%,
    100% {
        transform: translate(0, 0) rotate(0deg) scale(1) skewX(0deg);
        opacity: 0.6;
    }
    25% {
        transform: translate(-12%, 8%) rotate(25deg) scale(1.2) skewX(5deg);
        opacity: 0.75;
    }
    50% {
        transform: translate(5%, -10%) rotate(-15deg) scale(1.1) skewX(-8deg);
        opacity: 0.65;
    }
    75% {
        transform: translate(13%, 6%) rotate(30deg) scale(1.15) skewX(12deg);
        opacity: 0.7;
    }
}

@keyframes smokeFloat2 {
    0%,
    100% {
        transform: translate(0, 0) rotate(0deg) scale(1) skewY(0deg);
        opacity: 0.6;
    }
    30% {
        transform: translate(10%, -12%) rotate(-20deg) scale(1.25) skewY(-10deg);
        opacity: 0.8;
    }
    60% {
        transform: translate(-8%, 10%) rotate(28deg) scale(1.05) skewY(15deg);
        opacity: 0.7;
    }
    90% {
        transform: translate(6%, -5%) rotate(-12deg) scale(1.2) skewY(-5deg);
        opacity: 0.75;
    }
}

@keyframes smokeFloat3 {
    0%,
    100% {
        transform: translate(0, 0) rotate(0deg) scale(1) skewX(0deg) skewY(0deg);
        opacity: 0.6;
    }
    20% {
        transform: translate(-15%, 12%) rotate(38deg) scale(1.3) skewX(18deg) skewY(8deg);
        opacity: 0.85;
    }
    40% {
        transform: translate(8%, -15%) rotate(-25deg) scale(0.95) skewX(-12deg)
            skewY(-10deg);
        opacity: 0.65;
    }
    70% {
        transform: translate(12%, 8%) rotate(32deg) scale(1.15) skewX(15deg) skewY(12deg);
        opacity: 0.75;
    }
}

/* Cursor Spotlight */
.cursor-spotlight {
    position: absolute;
    width: 600px;
    height: 600px;
    margin-left: -300px;
    margin-top: -300px;
    pointer-events: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: radial-gradient(
            circle,
            rgba(255, 255, 255, 0.15) 0%,
            rgba(255, 255, 255, 0.08) 20%,
            transparent 50%
        ),
        radial-gradient(
            circle,
            rgba(211, 28, 0, 0.2) 0%,
            rgba(211, 28, 0, 0.1) 30%,
            transparent 60%
        );
    filter: blur(40px);
}

/* Smoke Particle Trail */
.smoke-particle {
    position: fixed;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(200, 210, 220, 0.9) 0%,
        rgba(210, 220, 230, 0.7) 30%,
        transparent 70%
    );
    pointer-events: none;
    animation: smokeParticleFade 2s ease-out forwards;
    filter: blur(35px);
    transform: translate(-50%, -50%);
    z-index: 1;
}

@keyframes smokeParticleFade {
    0% {
        opacity: 0.9;
        transform: translate(-50%, -50%) scale(0.5);
    }
    50% {
        opacity: 0.6;
        transform: translate(-50%, -50%) scale(1);
    }
    100% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(1.2);
    }
}

/* Snow Particles */
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

.snow-particle:nth-child(odd) {
    width: 4px;
    height: 4px;
}

.snow-particle:nth-child(even) {
    width: 6px;
    height: 6px;
}

.snow-particle:nth-child(3n) {
    width: 2px;
    height: 2px;
}

@keyframes snowFall {
    0% {
        opacity: 0;
        transform: translateY(0) translateX(0) rotate(0deg);
    }
    10% {
        opacity: 0.5;
    }
    90% {
        opacity: 0.5;
    }
    100% {
        opacity: 0;
        transform: translateY(100vh) translateX(50px) rotate(360deg);
    }
}

.snow-particle:nth-child(1) {
    left: 5%;
    animation-duration: 12s;
    animation-delay: 0s;
}
.snow-particle:nth-child(2) {
    left: 15%;
    animation-duration: 10s;
    animation-delay: 2s;
}
.snow-particle:nth-child(3) {
    left: 25%;
    animation-duration: 14s;
    animation-delay: 4s;
}
.snow-particle:nth-child(4) {
    left: 35%;
    animation-duration: 11s;
    animation-delay: 1s;
}
.snow-particle:nth-child(5) {
    left: 45%;
    animation-duration: 13s;
    animation-delay: 3s;
}
.snow-particle:nth-child(6) {
    left: 55%;
    animation-duration: 9s;
    animation-delay: 5s;
}
.snow-particle:nth-child(7) {
    left: 65%;
    animation-duration: 15s;
    animation-delay: 2s;
}
.snow-particle:nth-child(8) {
    left: 75%;
    animation-duration: 12s;
    animation-delay: 4s;
}
.snow-particle:nth-child(9) {
    left: 85%;
    animation-duration: 10s;
    animation-delay: 1s;
}
.snow-particle:nth-child(10) {
    left: 95%;
    animation-duration: 13s;
    animation-delay: 3s;
}
</style>
