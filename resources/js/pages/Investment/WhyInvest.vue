<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import RoiCalculatorModal from '@/components/RoiCalculatorModal.vue';
import {
    Shield,
    TrendingUp,
    Users,
    BookOpen,
    CheckCircle2,
    Home,
    Building2,
    Clock,
    Award,
    Target,
    Heart,
    ArrowRight,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

const showCalculatorModal = ref(false);

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

const whyRealEstate = [
    {
        icon: TrendingUp,
        title: 'Consistent Appreciation',
        description: 'Real estate in prime locations consistently appreciates over time, with average annual returns of 30-75% in Abuja\'s growing market.',
    },
    {
        icon: Shield,
        title: 'Tangible Asset',
        description: 'Unlike stocks or crypto, real estate is a physical asset you can see, touch, and develop—providing security and peace of mind.',
    },
    {
        icon: Home,
        title: 'Generational Wealth',
        description: 'Property ownership creates lasting legacies that can be passed down to your children and grandchildren.',
    },
    {
        icon: Target,
        title: 'Inflation Hedge',
        description: 'Real estate values typically rise with inflation, protecting your wealth from currency devaluation.',
    },
];

const whyWakaWealth = [
    {
        icon: BookOpen,
        title: 'Education-First Approach',
        description: 'We don\'t just give you fish—we teach you to fish, then we fish together. Free workshops, detailed guides, and transparent consultations empower you to make informed decisions.',
    },
    {
        icon: Shield,
        title: 'End-to-End Security',
        description: '100% verified listings, in-house legal team, forensic title verification, and post-purchase support. We catch hidden flaws that basic agents miss.',
    },
    {
        icon: Users,
        title: 'Journey Partnership',
        description: 'We don\'t disappear after closing. Complimentary annual portfolio reviews, ongoing market updates, and lifetime access to investment resources.',
    },
    {
        icon: Heart,
        title: 'Flexible Solutions',
        description: 'Installment payment plans, co-investment opportunities, mortgage partnerships, and diaspora facilitation make investment accessible at various income levels.',
    },
];

const investmentBenefits = [
    {
        stat: '30-75%',
        label: 'Average Annual ROI',
        description: 'Properties in our locations show consistent appreciation',
    },
    {
        stat: '100%',
        label: 'Verified Listings',
        description: 'Every property undergoes forensic title verification',
    },
    {
        stat: '100+',
        label: 'Successful Investments',
        description: 'Families building wealth through our partnership',
    },
    {
        stat: '24/7',
        label: 'Support Access',
        description: 'Ongoing guidance throughout your investment journey',
    },
];

const investmentTypes = [
    {
        type: 'Sites & Services',
        icon: Building2,
        description: 'Secure land parcels with verified titles in high-growth areas. Build at your own pace or hold for appreciation.',
        benefits: [
            'Lower initial capital required',
            'Flexibility to build when ready',
            'Higher appreciation potential',
            'Ideal for long-term wealth building',
        ],
        priceRange: '₦5M - ₦100M',
    },
    {
        type: 'Completed Homes',
        icon: Home,
        description: 'Move-in ready properties in established neighborhoods. Immediate occupancy or rental income.',
        benefits: [
            'Instant asset ownership',
            'Immediate rental income potential',
            'No construction stress',
            'Perfect for diaspora investors',
        ],
        priceRange: '₦150M - ₦700M',
    },
];

const securityFeatures = [
    {
        icon: CheckCircle2,
        title: 'Forensic Due Diligence',
        description: 'Legal and analytical teams audit the root history of every title, catching hidden flaws, zoning conflicts, and procedural errors.',
    },
    {
        icon: Award,
        title: 'Legacy Structuring',
        description: 'Expert advice on structuring ownership through trusts and legal frameworks for seamless wealth transfer to heirs.',
    },
    {
        icon: Clock,
        title: 'Lifetime Partnership',
        description: 'Annual portfolio reviews, market updates, priority access to new listings, and ongoing investment education.',
    },
    {
        icon: Shield,
        title: 'Transaction Protection',
        description: 'End-to-end transaction management with legal protection, quality assurance, and post-purchase documentation support.',
    },
];

const testimonial = {
    quote: 'Working with Waka Wealth was an exceptional experience. Their professionalism, dedication, and expertise made the entire process seamless and enjoyable. The property I acquired not only met but exceeded my expectations, and has significantly appreciated since purchase. It has proven to be both a comfortable residence and a savvy financial investment.',
    author: 'John M',
    location: 'Nigeria',
};
</script>

<template>
    <Head title="Why Invest - Waka Wealth Realty" />

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
                        Why Invest in <span class="text-[#D31C00]">Real Estate?</span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300 mb-8">
                        Build generational wealth through tangible assets with proven appreciation and lasting security
                    </p>
                    <button
                        @click="showCalculatorModal = true"
                        class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 font-semibold text-white transition-colors hover:bg-[#B01700]"
                    >
                        <span>Calculate Your ROI</span>
                        <ArrowRight class="h-5 w-5" />
                    </button>
                </div>
            </div>
        </section>

        <!-- Why Real Estate Section -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        The Power of <span class="text-[#D31C00]">Real Estate</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        In a world of volatile markets and uncertain investments, real estate stands as a time-tested path to lasting wealth
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(reason, index) in whyRealEstate"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black p-8 transition-all hover:border-[#D31C00]"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <component :is="reason.icon" class="h-8 w-8 text-[#D31C00]" />
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">{{ reason.title }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ reason.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="bg-black py-16 border-y border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(benefit, index) in investmentBenefits"
                        :key="index"
                        class="text-center"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="text-5xl font-bold text-[#D31C00] mb-2">{{ benefit.stat }}</div>
                        <div class="text-xl font-semibold text-white mb-1">{{ benefit.label }}</div>
                        <div class="text-sm text-gray-400">{{ benefit.description }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Waka Wealth Section -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Why Invest with <span class="text-[#D31C00]">Waka Wealth?</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        We're not just another real estate agency—we're your specialized diligence partner on the journey to wealth
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div
                        v-for="(reason, index) in whyWakaWealth"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black p-8 transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="inline-flex rounded-full bg-[#D31C00]/10 p-4">
                                    <component :is="reason.icon" class="h-8 w-8 text-[#D31C00]" />
                                </div>
                            </div>
                            <div>
                                <h3 class="mb-3 text-2xl font-bold text-white">{{ reason.title }}</h3>
                                <p class="text-gray-400 leading-relaxed">{{ reason.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Investment Types Section -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Choose Your <span class="text-[#D31C00]">Investment Path</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Whether you're starting small or investing big, we have the perfect property type for your goals
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div
                        v-for="(type, index) in investmentTypes"
                        :key="index"
                        class="rounded-2xl border-2 border-gray-800 bg-gray-900 overflow-hidden transition-all hover:border-[#D31C00]"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 150)"
                    >
                        <!-- Header -->
                        <div class="bg-gradient-to-br from-[#D31C00] to-[#B01700] p-8">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="inline-flex rounded-full bg-white/20 p-3">
                                    <component :is="type.icon" class="h-8 w-8 text-white" />
                                </div>
                                <h3 class="text-3xl font-bold text-white">{{ type.type }}</h3>
                            </div>
                            <p class="text-lg text-white/90">{{ type.description }}</p>
                        </div>

                        <!-- Benefits -->
                        <div class="p-8">
                            <div class="mb-6">
                                <div class="text-sm font-semibold text-gray-400 mb-2">TYPICAL PRICE RANGE</div>
                                <div class="text-2xl font-bold text-white">{{ type.priceRange }}</div>
                            </div>

                            <div class="space-y-3">
                                <div
                                    v-for="(benefit, idx) in type.benefits"
                                    :key="idx"
                                    class="flex items-start gap-3"
                                >
                                    <CheckCircle2 class="h-5 w-5 text-[#D31C00] flex-shrink-0 mt-0.5" />
                                    <span class="text-gray-300">{{ benefit }}</span>
                                </div>
                            </div>

                            <Link
                                :href="`/properties?type=${type.type === 'Sites & Services' ? 'site' : 'home'}`"
                                class="mt-8 flex items-center justify-center space-x-2 rounded-sm bg-[#D31C00] px-6 py-3 font-semibold text-white transition-colors hover:bg-[#B01700]"
                            >
                                <span>View {{ type.type }}</span>
                                <ArrowRight class="h-5 w-5" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Security & Protection Section -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        The <span class="text-[#D31C00]">Waka Wealth Standard</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        We replace the anxiety of real estate investment with the absolute certainty of a vetted, compliant, and legally perfect asset
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div
                        v-for="(feature, index) in securityFeatures"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black p-8"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4 inline-flex rounded-full bg-[#D31C00]/10 p-4">
                            <component :is="feature.icon" class="h-8 w-8 text-[#D31C00]" />
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">{{ feature.title }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ feature.description }}</p>
                    </div>
                </div>

                <!-- Trust Quote -->
                <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="rounded-2xl border-2 border-[#D31C00] bg-[#D31C00]/5 p-12">
                        <p class="text-2xl font-semibold text-white mb-4 italic leading-relaxed">
                            "The true luxury we deliver is the complete, quiet confidence that comes from knowing your investment has passed the Waka Wealth Standard."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial Section -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center" data-aos="fade-up">
                    <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                        Success <span class="text-[#D31C00]">Stories</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-lg text-gray-400">
                        Don't take our word for it—see what happens when you choose us
                    </p>
                </div>

                <div class="mx-auto max-w-4xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="rounded-2xl border border-gray-800 bg-gray-900 p-12">
                        <div class="mb-8 text-6xl text-[#D31C00]">"</div>
                        <p class="text-xl text-gray-300 leading-relaxed mb-8 italic">
                            {{ testimonial.quote }}
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-[#D31C00] flex items-center justify-center text-white font-bold text-xl">
                                {{ testimonial.author.charAt(0) }}
                            </div>
                            <div>
                                <div class="font-semibold text-white">{{ testimonial.author }}</div>
                                <div class="text-sm text-gray-400">{{ testimonial.location }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- The True Luxury Quote Section -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center" data-aos="fade-up">
                    <p class="text-3xl md:text-4xl font-bold text-white mb-6 leading-relaxed">
                        The houses we showcase are architecturally magnificent.<br/>
                        The land we present holds incredible potential.
                    </p>
                    <p class="text-4xl md:text-5xl font-bold text-[#D31C00] mb-8">
                        But the true luxury is certainty.
                    </p>
                    <p class="mx-auto max-w-3xl text-xl text-gray-300 leading-relaxed">
                        Your success was built on hard work and smart decisions. Your investments should be too.
                    </p>
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
                        Ready to Build Your Wealth?
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Stop chasing opportunities. Start investing in certainty. It's time to build the legacy your success deserves.
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Schedule Consultation</span>
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

    <RoiCalculatorModal v-model:isOpen="showCalculatorModal" />
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
