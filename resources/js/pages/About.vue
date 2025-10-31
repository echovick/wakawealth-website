<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { ArrowRight, Target, Eye, Heart, Users, Award, Handshake, TrendingUp } from 'lucide-vue-next';
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

const values = [
    {
        icon: Heart,
        title: 'Integrity (We Keep Our Word)',
        description: 'Every promise is sacred. Every commitment is honored. No hidden agendas, no surprise fees, no deceptive practices. If we say it, we mean it. If we commit, we deliver.',
    },
    {
        icon: TrendingUp,
        title: 'Empowerment (Knowledge is Wealth)',
        description: 'We believe informed clients make better decisions. Education isn\'t optional—it\'s central to everything we do. We don\'t just give you fish—we teach you to fish, then we fish together.',
    },
    {
        icon: Award,
        title: 'Excellence',
        description: 'We hold ourselves to the highest professional standards in every transaction, interaction, and outcome. Your investment deserves the best—we deliver nothing less.',
    },
    {
        icon: Handshake,
        title: 'Partnership (Your Success is Our Mission)',
        description: 'We\'re not just service providers—we\'re your partners, advisors, and advocates throughout your entire wealth-building journey. We don\'t walk ahead or behind you—we walk beside you.',
    },
    {
        icon: Users,
        title: 'Community (We Rise Together)',
        description: 'Individual success contributes to collective prosperity. We build networks, celebrate shared wins, and lift as we climb. Your neighbor\'s success doesn\'t diminish yours—it multiplies opportunities for all.',
    },
];

const services = [
    {
        category: 'Real Estate Services',
        items: [
            'Residential property sales and acquisitions',
            'Commercial property investment',
            'Land banking and development opportunities',
            'Real estate portfolio diversification',
            'Due diligence and legal documentation support',
        ],
    },
    {
        category: 'Investment Advisory',
        items: [
            'Real estate investment education and workshops',
            'ROI analysis and market trend insights',
            'Joint venture and co-investment opportunities',
            'Wealth-building strategy consultation',
            'Diaspora investment facilitation',
            'Legacy and estate planning guidance',
        ],
    },
    {
        category: 'Client Support',
        items: [
            'End-to-end transaction management',
            'Financing and mortgage advisory',
            'Property inspection and valuation',
            'Legal and regulatory navigation',
            'Post-purchase support and community',
            'Ongoing portfolio optimization',
        ],
    },
];
</script>

<template>
    <Head title="About Us - Waka Wealth Realty" />

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

            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-32 text-center">
                <div data-aos="fade-up" data-aos-delay="200">
                    <h1 class="mb-6 text-5xl font-bold text-white md:text-6xl lg:text-7xl">
                        About <span class="text-[#D31C00]">Waka Wealth</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300 md:text-2xl">
                        Your trusted companion on the journey to financial freedom and generational prosperity
                    </p>
                </div>
            </div>
        </section>

        <!-- Our Story Section -->
        <section class="relative bg-gray-900 py-20">
            <div class="absolute inset-0 bg-gray-900"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
                    <div data-aos="fade-right" data-aos-delay="100">
                        <div class="mb-4 inline-block">
                            <span class="rounded-full bg-[#D31C00]/20 px-4 py-1.5 text-sm font-semibold text-[#D31C00]">
                                Our Story
                            </span>
                        </div>
                        <h2 class="mb-6 text-4xl font-bold text-white md:text-5xl">
                            Who <span class="text-[#D31C00]">We Are</span>
                        </h2>
                        <div class="space-y-4 text-lg leading-relaxed text-gray-300">
                            <p>
                                Waka Wealth is more than a real estate and investment brokerage, we are your trusted companion on the journey to financial freedom and generational prosperity.
                            </p>
                            <p>
                                Founded on the principle that wealth-building should be accessible to everyone, not just the privileged few, we specialize in guiding individuals, families, and diaspora investors through every step of property acquisition, investment, and portfolio growth.
                            </p>
                            <p>
                                Our name tells our story: "Waka" (to walk, to journey) + "Wealth" (prosperity, legacy). We believe that building lasting wealth isn't about shortcuts or luck; it's about taking consistent, informed steps forward with the right partner by your side.
                            </p>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-left" data-aos-delay="200">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-4">
                                <div class="aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800 to-gray-700"></div>
                                <div class="aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800"></div>
                            </div>
                            <div class="mt-8 space-y-4">
                                <div class="aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800 to-gray-700"></div>
                                <div class="aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800"></div>
                            </div>
                        </div>

                        <!-- Stats Badge -->
                        <div class="absolute -bottom-6 -left-6 rounded-2xl bg-black border border-gray-800 p-6 shadow-xl">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-[#D31C00]">500+</div>
                                <div class="text-sm font-medium text-gray-400">
                                    Properties<br />Delivered
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision Section -->
        <section class="relative bg-black py-20">
            <div class="absolute inset-0 bg-black"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 md:grid-cols-2">
                    <!-- Vision -->
                    <div class="rounded-2xl border border-gray-800 bg-gray-900/50 p-8" data-aos="fade-up" data-aos-delay="100">
                        <div class="mb-6 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <Eye class="h-10 w-10 text-[#D31C00]" />
                        </div>
                        <h3 class="mb-4 text-3xl font-bold text-white">Our Vision</h3>
                        <p class="text-lg text-gray-300 leading-relaxed">
                            To become Africa's most trusted partner in democratizing wealth creation through real estate, empowering families to own property and build generational prosperity.
                        </p>
                    </div>

                    <!-- Mission -->
                    <div class="rounded-2xl border border-gray-800 bg-gray-900/50 p-8" data-aos="fade-up" data-aos-delay="200">
                        <div class="mb-6 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <Target class="h-10 w-10 text-[#D31C00]" />
                        </div>
                        <h3 class="mb-4 text-3xl font-bold text-white">Our Mission</h3>
                        <p class="text-lg text-gray-300 leading-relaxed">
                            To guide our clients on their journey to financial freedom by providing transparent, culturally intelligent, and comprehensive real estate and investment services that build wealth, create legacies, and transform communities—one property, one family, one step at a time.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="relative bg-gray-900 py-20">
            <div class="absolute inset-0 bg-gray-900"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Our <span class="text-[#D31C00]">Core Values</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        The principles that guide everything we do
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="(value, index) in values"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-gray-800/50 p-8 text-center transition-all hover:border-[#D31C00] hover:shadow-lg"
                        data-aos="fade-up"
                        :data-aos-delay="200 + (index * 100)"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <component :is="value.icon" class="h-8 w-8 text-[#D31C00]" />
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">{{ value.title }}</h3>
                        <p class="text-gray-400">{{ value.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- What We Do Section -->
        <section class="relative bg-black py-20">
            <div class="absolute inset-0 bg-black"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        What <span class="text-[#D31C00]">We Do</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Comprehensive services designed to support your entire wealth-building journey
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div
                        v-for="(service, index) in services"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-gray-900/50 p-8"
                        data-aos="fade-up"
                        :data-aos-delay="200 + (index * 100)"
                    >
                        <h3 class="mb-6 text-2xl font-bold text-white">{{ service.category }}</h3>
                        <ul class="space-y-3">
                            <li v-for="(item, idx) in service.items" :key="idx" class="flex items-start">
                                <span class="mr-3 mt-1 h-2 w-2 flex-shrink-0 rounded-full bg-[#D31C00]"></span>
                                <span class="text-gray-300">{{ item }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Brand Promise Section -->
        <section class="relative bg-gray-900 py-20">
            <div class="absolute inset-0 bg-gray-900"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="mb-6 inline-block rounded-full border-2 border-[#D31C00] px-8 py-3">
                        <p class="text-2xl font-bold text-[#D31C00] md:text-3xl">
                            "We walk with you to wealth."
                        </p>
                    </div>

                    <div class="mx-auto max-w-4xl space-y-6 text-lg leading-relaxed text-gray-300">
                        <p>
                            At Waka Wealth, you're never alone on your journey. Whether you're a first-time buyer navigating property ownership, a diaspora investor looking to build back home, an entrepreneur diversifying into real estate, or a family securing land for future generations—we are your trusted companion, guide, and advocate.
                        </p>
                        <p class="text-xl font-semibold text-white">
                            We don't just sell properties—we build relationships, educate clients, and create pathways to financial independence.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why We're Different Section -->
        <section class="relative bg-black py-20">
            <div class="absolute inset-0 bg-black"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Why We're <span class="text-[#D31C00]">Different</span>
                    </h2>
                </div>

                <div class="mx-auto max-w-4xl space-y-8 text-lg leading-relaxed text-gray-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="rounded-2xl border border-gray-800 bg-gray-900/50 p-8">
                        <p class="mb-4">
                            <span class="font-bold text-white">We don't just facilitate transactions, we transform lives.</span> Every client interaction is an opportunity to educate, empower, and elevate.
                        </p>
                        <p class="mb-4">
                            We measure success not just in deals closed, but in <span class="font-bold text-white">families secured, legacies built, and dreams realized.</span>
                        </p>
                        <p>
                            We are <span class="font-bold text-white">culturally rooted, professionally excellent, and personally invested</span> in your success. When you win, we win. When you grow, we grow. That's the Waka Wealth way.
                        </p>
                    </div>

                    <div class="rounded-2xl border-2 border-[#D31C00] bg-[#D31C00]/5 p-8 text-center">
                        <p class="text-xl italic text-white">
                            "Waka Wealth is more than a real estate agency—it's a movement toward your financial freedom, a bridge between dreams and ownership, and a testament to what happens when cultural intelligence meets professional excellence."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-[#D31C00] to-[#B01700] py-20">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 bg-black/20" />
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/5" />
            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-white/5" />

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl" data-aos="fade-up" data-aos-delay="100">
                        Ready to Start Your Journey?
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="200">
                        Join hundreds of satisfied clients who have built wealth through real estate with Waka Wealth
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="300">
                        <Link
                            href="/properties"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>View Properties</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/contact"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>Contact Us</span>
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
