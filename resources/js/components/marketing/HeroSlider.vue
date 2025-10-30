<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

const slides = [
    {
        id: 1,
        title: 'Start the Journey',
        subtitle: 'Own the Destination',
        description:
            'Building wealth through real estate isn\'t about shortcuts—it\'s about taking intentional steps forward.',
        image: '/images/hero/hero-1.jpg',
        cta: { text: 'View Properties', href: '/properties' },
        cta2: { text: 'Learn More', href: '/about' },
    },
    {
        id: 2,
        title: 'Your Trusted Partner',
        subtitle: 'In Wealth Building',
        description:
            'We walk beside you every step of the way—from first inquiry to portfolio optimization.',
        image: '/images/hero/hero-2.jpg',
        cta: { text: 'Explore Locations', href: '/locations' },
        cta2: { text: 'Calculate ROI', href: '/investment/calculator' },
    },
    {
        id: 3,
        title: 'Diaspora Investment',
        subtitle: 'Made Simple',
        description:
            'Invest back home with confidence. Virtual tours, trusted local representatives, and regular updates.',
        image: '/images/hero/hero-3.jpg',
        cta: { text: 'Diaspora Investment', href: '/investment/diaspora' },
        cta2: { text: 'Get Started', href: '/contact' },
    },
    {
        id: 4,
        title: 'Education First',
        subtitle: 'Investment Always',
        description:
            'Learn before you invest. Join our Waka to Wealth workshops and build lasting prosperity.',
        image: '/images/hero/hero-4.jpg',
        cta: { text: 'View Workshops', href: '/education/workshops' },
        cta2: { text: 'Read Blog', href: '/education/blog' },
    },
];

const currentSlide = ref(0);
let intervalId: number | null = null;

// Smoke effect variables
const smokeParticles = ref<Array<{ id: number; x: number; y: number }>>([]);
let particleId = 0;

// Spotlight effect
const spotlightPosition = ref({ x: 50, y: 50 });
const isSpotlightReady = ref(false);

// Snow particles
const snowParticles = ref<Array<{ id: number; x: number; delay: number; duration: number; size: number }>>([]);
let snowId = 0;

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.length;
};

const prevSlide = () => {
    currentSlide.value =
        currentSlide.value === 0 ? slides.length - 1 : currentSlide.value - 1;
};

const goToSlide = (index: number) => {
    currentSlide.value = index;
};

const startAutoplay = () => {
    intervalId = window.setInterval(nextSlide, 6000);
};

const stopAutoplay = () => {
    if (intervalId) {
        clearInterval(intervalId);
        intervalId = null;
    }
};

const handleMouseMove = (event: MouseEvent) => {
    const target = event.currentTarget as HTMLElement;
    const rect = target.getBoundingClientRect();

    // Update spotlight position as percentage
    spotlightPosition.value = {
        x: ((event.clientX - rect.left) / rect.width) * 100,
        y: ((event.clientY - rect.top) / rect.height) * 100,
    };

    // Create smoke particles more frequently for continuous trail
    const particle = {
        id: particleId++,
        x: event.clientX,
        y: event.clientY,
    };
    smokeParticles.value.push(particle);

    // Limit the number of particles to prevent memory issues
    if (smokeParticles.value.length > 30) {
        smokeParticles.value.shift();
    }

    // Remove particle after animation
    setTimeout(() => {
        smokeParticles.value = smokeParticles.value.filter(p => p.id !== particle.id);
    }, 2500);
};

const createSnowParticles = () => {
    // Create 40 snow particles
    for (let i = 0; i < 40; i++) {
        snowParticles.value.push({
            id: snowId++,
            x: Math.random() * 100,
            delay: Math.random() * 5,
            duration: 8 + Math.random() * 7, // 8-15 seconds
            size: 2 + Math.random() * 4, // 2-6px
        });
    }
};

onMounted(() => {
    startAutoplay();
    createSnowParticles();

    // Animate spotlight on load
    setTimeout(() => {
        isSpotlightReady.value = true;
    }, 100);
});

onUnmounted(() => {
    stopAutoplay();
});
</script>

<template>
    <section class="relative h-screen w-full overflow-hidden bg-black" @mousemove="handleMouseMove">
        <!-- Ambient flowing smoke background -->
        <div class="smoke-background pointer-events-none absolute inset-0">
            <div class="smoke-layer smoke-layer-1"></div>
            <div class="smoke-layer smoke-layer-2"></div>
            <div class="smoke-layer smoke-layer-3"></div>
        </div>

        <!-- Snow/dust particles falling -->
        <div class="snow-container pointer-events-none absolute inset-0">
            <div
                v-for="particle in snowParticles"
                :key="particle.id"
                class="snow-particle"
                :style="{
                    left: particle.x + '%',
                    animationDelay: particle.delay + 's',
                    animationDuration: particle.duration + 's',
                    width: particle.size + 'px',
                    height: particle.size + 'px',
                }"
            />
        </div>

        <!-- Dynamic spotlight overlay with glow -->
        <div
            class="spotlight-overlay pointer-events-none absolute inset-0 transition-opacity duration-1000"
            :class="{ 'opacity-100': isSpotlightReady, 'opacity-0': !isSpotlightReady }"
            :style="{
                background: `
                    radial-gradient(circle 300px at ${spotlightPosition.x}% ${spotlightPosition.y}%, rgba(80, 180, 200, 0.3) 0%, rgba(60, 160, 180, 0.15) 30%, rgba(50, 140, 160, 0.08) 50%, transparent 70%),
                    radial-gradient(circle 550px at ${spotlightPosition.x}% ${spotlightPosition.y}%, rgba(60, 150, 170, 0.15) 0%, rgba(45, 130, 150, 0.08) 40%, transparent 75%)
                `,
            }"
        />

        <!-- Cursor smoke particles -->
        <div
            v-for="particle in smokeParticles"
            :key="particle.id"
            class="smoke-particle pointer-events-none absolute"
            :style="{
                left: particle.x + 'px',
                top: particle.y + 'px',
            }"
        />

        <!-- Slides -->
        <div class="relative h-full w-full">
            <div
                v-for="(slide, index) in slides"
                :key="slide.id"
                :class="[
                    'absolute inset-0 h-full w-full transition-opacity duration-1000',
                    currentSlide === index ? 'opacity-100' : 'opacity-0',
                ]"
            >
                <!-- Dark Background -->
                <div class="absolute inset-0">
                    <div class="h-full w-full bg-black" />
                </div>

                <!-- Content -->
                <div
                    class="relative mx-auto flex h-full max-w-7xl items-center px-4 sm:px-6 lg:px-8"
                >
                    <div class="max-w-2xl">
                        <h2
                            class="mb-3 text-xs font-medium uppercase tracking-widest text-[#D31C00]"
                            data-aos="fade-right"
                            data-aos-delay="200"
                            data-aos-duration="800"
                        >
                            Waka Wealth Realty
                        </h2>
                        <h1
                            class="mb-4 text-4xl font-bold leading-tight text-white md:text-5xl lg:text-6xl"
                            data-aos="fade-right"
                            data-aos-delay="400"
                            data-aos-duration="800"
                        >
                            {{ slide.title }}<br />
                            <span class="text-[#D31C00]">{{ slide.subtitle }}</span>
                        </h1>
                        <p
                            class="mb-8 max-w-xl text-base text-gray-400 md:text-lg"
                            data-aos="fade-right"
                            data-aos-delay="600"
                            data-aos-duration="800"
                        >
                            {{ slide.description }}
                        </p>
                        <div
                            class="flex flex-wrap gap-4"
                            data-aos="fade-up"
                            data-aos-delay="800"
                            data-aos-duration="800"
                        >
                            <Link
                                :href="slide.cta.href"
                                class="inline-flex items-center rounded-sm bg-[#D31C00] px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-[#B01700]"
                            >
                                {{ slide.cta.text }}
                            </Link>
                            <Link
                                :href="slide.cta2.href"
                                class="inline-flex items-center rounded-sm border-2 border-white bg-transparent px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-white hover:text-gray-900"
                            >
                                {{ slide.cta2.text }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <button
            @click="prevSlide"
            class="absolute left-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition-all hover:bg-white/20 lg:left-8"
            aria-label="Previous slide"
        >
            <ChevronLeft class="h-6 w-6" />
        </button>
        <button
            @click="nextSlide"
            class="absolute right-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition-all hover:bg-white/20 lg:right-8"
            aria-label="Next slide"
        >
            <ChevronRight class="h-6 w-6" />
        </button>

        <!-- Dots Indicator -->
        <div class="absolute bottom-8 left-1/2 z-10 flex -translate-x-1/2 space-x-3">
            <button
                v-for="(slide, index) in slides"
                :key="slide.id"
                @click="goToSlide(index)"
                :class="[
                    'h-2 rounded-full transition-all',
                    currentSlide === index
                        ? 'w-8 bg-[#D31C00]'
                        : 'w-2 bg-white/50 hover:bg-white/80',
                ]"
                :aria-label="`Go to slide ${index + 1}`"
            />
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-24 left-1/2 z-10 -translate-x-1/2 animate-bounce">
            <div class="flex flex-col items-center text-white">
                <span class="mb-2 text-xs uppercase tracking-wider">Scroll</span>
                <div class="h-6 w-4 rounded-full border-2 border-white">
                    <div class="mx-auto mt-1 h-1 w-1 rounded-full bg-white" />
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Snow particles */
.snow-container {
    z-index: 3;
}

.snow-particle {
    position: absolute;
    top: -10px;
    background: rgba(200, 220, 230, 0.6);
    border-radius: 50%;
    animation: snowfall linear infinite;
    opacity: 0;
}

@keyframes snowfall {
    0% {
        transform: translateY(0) translateX(0) rotate(0deg);
        opacity: 0;
    }
    10% {
        opacity: 0.8;
    }
    90% {
        opacity: 0.6;
    }
    100% {
        transform: translateY(100vh) translateX(50px) rotate(360deg);
        opacity: 0;
    }
}

/* Ambient smoke background */
.smoke-background {
    z-index: 0;
}

.smoke-layer {
    position: absolute;
    width: 200%;
    height: 200%;
    top: -50%;
    left: -50%;
    opacity: 0.6;
    mix-blend-mode: screen;
    filter: blur(60px);
}

.smoke-layer-1 {
    background:
        radial-gradient(ellipse 1400px 500px at 10% 20%, rgba(190, 210, 220, 0.85) 0%, rgba(130, 150, 160, 0.5) 25%, transparent 55%),
        radial-gradient(ellipse 1100px 800px at 90% 80%, rgba(160, 180, 190, 0.75) 0%, rgba(110, 130, 140, 0.4) 30%, transparent 60%),
        radial-gradient(ellipse 800px 400px at 35% 55%, rgba(170, 190, 200, 0.6) 0%, rgba(120, 140, 150, 0.35) 35%, transparent 65%),
        radial-gradient(circle 600px at 60% 30%, rgba(165, 185, 195, 0.55) 0%, transparent 50%);
    animation: smokeFloat1 22s ease-in-out infinite;
}

.smoke-layer-2 {
    background:
        radial-gradient(ellipse 1300px 900px at 70% 30%, rgba(180, 200, 210, 0.8) 0%, rgba(120, 140, 150, 0.45) 28%, transparent 58%),
        radial-gradient(ellipse 900px 1000px at 20% 90%, rgba(150, 170, 180, 0.7) 0%, rgba(100, 120, 130, 0.38) 32%, transparent 64%),
        radial-gradient(ellipse 700px 500px at 80% 45%, rgba(165, 185, 195, 0.65) 0%, rgba(115, 135, 145, 0.4) 36%, transparent 68%),
        radial-gradient(circle 650px at 45% 65%, rgba(160, 180, 190, 0.6) 0%, transparent 52%);
    animation: smokeFloat2 27s ease-in-out infinite reverse;
}

.smoke-layer-3 {
    background:
        radial-gradient(ellipse 1250px 850px at 55% 40%, rgba(175, 195, 205, 0.75) 0%, rgba(115, 135, 145, 0.42) 30%, transparent 60%),
        radial-gradient(ellipse 950px 700px at 80% 10%, rgba(155, 175, 185, 0.72) 0%, rgba(105, 125, 135, 0.39) 33%, transparent 63%),
        radial-gradient(ellipse 750px 550px at 25% 75%, rgba(170, 190, 200, 0.68) 0%, rgba(120, 140, 150, 0.37) 35%, transparent 67%),
        radial-gradient(circle 600px at 50% 50%, rgba(168, 188, 198, 0.62) 0%, transparent 50%);
    animation: smokeFloat3 32s ease-in-out infinite;
}

@keyframes smokeFloat1 {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg) scale(1) skewX(0deg);
        opacity: 0.6;
    }
    25% {
        transform: translate(-12%, 8%) rotate(25deg) scale(1.2) skewX(5deg);
        opacity: 0.75;
    }
    50% {
        transform: translate(-8%, -12%) rotate(-15deg) scale(0.85) skewX(-8deg);
        opacity: 0.68;
    }
    75% {
        transform: translate(10%, -5%) rotate(35deg) scale(1.15) skewX(12deg);
        opacity: 0.72;
    }
}

@keyframes smokeFloat2 {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg) scale(1) skewY(0deg);
        opacity: 0.6;
    }
    30% {
        transform: translate(11%, -11%) rotate(-28deg) scale(1.18) skewY(-10deg);
        opacity: 0.78;
    }
    60% {
        transform: translate(-13%, 7%) rotate(18deg) scale(0.82) skewY(15deg);
        opacity: 0.66;
    }
    85% {
        transform: translate(8%, 13%) rotate(-22deg) scale(1.12) skewY(-6deg);
        opacity: 0.74;
    }
}

@keyframes smokeFloat3 {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg) scale(1) skew(0deg, 0deg);
        opacity: 0.6;
    }
    20% {
        transform: translate(-11%, 12%) rotate(32deg) scale(1.14) skew(8deg, -5deg);
        opacity: 0.72;
    }
    55% {
        transform: translate(13%, -9%) rotate(-38deg) scale(0.88) skew(-12deg, 10deg);
        opacity: 0.69;
    }
    80% {
        transform: translate(-6%, 10%) rotate(28deg) scale(1.08) skew(6deg, -8deg);
        opacity: 0.76;
    }
}

/* Spotlight */
.spotlight-overlay {
    z-index: 1;
    transition: background 0.2s ease-out;
    will-change: background;
    filter: blur(30px);
}

/* Cursor smoke particles */
.smoke-particle {
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, rgba(100, 200, 220, 0.5) 0%, rgba(80, 180, 200, 0.3) 25%, rgba(60, 160, 180, 0.15) 50%, transparent 70%);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: smokeTrail 2.5s ease-out forwards;
    filter: blur(35px);
    z-index: 2;
}

@keyframes smokeTrail {
    0% {
        opacity: 0.7;
        transform: translate(-50%, -50%) scale(0.5);
    }
    20% {
        opacity: 0.9;
        transform: translate(-50%, -55%) scale(0.9);
    }
    60% {
        opacity: 0.5;
        transform: translate(-50%, -75%) scale(1.2);
    }
    100% {
        opacity: 0;
        transform: translate(-50%, -100%) scale(1.6);
    }
}

/* Hero content animations */
.hero-subtitle,
.hero-title,
.hero-description,
.hero-buttons {
    opacity: 0;
    transform: translateY(30px);
}

.hero-subtitle.animate-slide-in {
    animation: slideInUp 0.8s ease-out 0.2s forwards;
}

.hero-title.animate-slide-in {
    animation: slideInUp 0.8s ease-out 0.4s forwards;
}

.hero-description.animate-slide-in {
    animation: slideInUp 0.8s ease-out 0.6s forwards;
}

.hero-buttons.animate-slide-in {
    animation: slideInUp 0.8s ease-out 0.8s forwards;
}

@keyframes slideInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@layer utilities {
    .bg-gradient-radial {
        background-image: radial-gradient(var(--tw-gradient-stops));
    }
}
</style>
