<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import {
    Clock,
    ArrowRight,
    Calendar,
    User,
    Tag,
    Share2,
    Facebook,
    Twitter,
    Linkedin,
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineOptions({ layout: MarketingLayout });

interface BlogPost {
    id: number;
    title: string;
    slug: string;
    excerpt: string;
    content: string;
    category: string;
    readTime: string;
    author: string;
    authorBio: string;
    publishedAt: string;
    tags: string[];
}

interface RelatedPost {
    id: number;
    title: string;
    slug: string;
    category: string;
    readTime: string;
}

interface Props {
    post?: BlogPost;
    relatedPosts?: RelatedPost[];
}

const props = withDefaults(defineProps<Props>(), {
    post: () => ({
        id: 1,
        title: 'Beyond the Hype: Why the Best Investments Begin with Unshakeable Trust',
        slug: 'beyond-the-hype-trust',
        excerpt: 'The excitement fades, and one question takes its place: "How certain am I?" Discover why trust is the foundation of true wealth in real estate.',
        content: `
            <p>When you first hear about a promising real estate opportunity, excitement takes over. The location is perfect, the price seems right, and everyone's talking about it. But then the excitement fades, and one question takes its place: "How certain am I?"</p>

            <p>That question—<em>How certain am I?</em>—is the foundation of every successful real estate investment. And the answer lies not in the property itself, but in the trust you have in the people guiding you through the process.</p>

            <h2>The Trust Gap in Real Estate</h2>

            <p>In Nigeria's real estate market, trust is the scarcest commodity. Horror stories abound: families losing their life savings to fraudulent land deals, diaspora investors discovering their "prime location" is actually swampland, buyers receiving fake documents that look authentic until it's too late.</p>

            <p>The statistics are sobering. According to recent industry reports, over 40% of land transactions in major Nigerian cities involve some form of documentation irregularity. But here's what the statistics don't capture: the emotional toll, the shattered dreams, and the generational wealth that never materialized.</p>

            <h2>What Trust Actually Means in Real Estate</h2>

            <p>Real trust in real estate isn't about good intentions or friendly conversations. It's built on three concrete pillars:</p>

            <h3>1. Radical Transparency</h3>

            <p>Every document, every process, every potential risk—laid bare. No fine print, no "don't worry about that," no glossing over complications. When a company shows you the full picture, including the challenges, that's when you know they're on your side.</p>

            <h3>2. Proven Track Record</h3>

            <p>Words are easy. History is honest. A trustworthy partner doesn't just talk about success—they show you families who've built wealth, investors who've multiplied their returns, and clients who've referred their own loved ones.</p>

            <h3>3. Post-Purchase Support</h3>

            <p>The real test of trust comes after the sale. Anyone can be attentive when they want your money. The question is: Will they answer your call six months later? Will they help you navigate challenges that arise? Will they treat you like family, even after the commission is paid?</p>

            <h2>The Cost of Misplaced Trust</h2>

            <p>Ibrahim's story is one we hear too often. A successful engineer working in Dubai, he invested ₦15 million in what seemed like a prime property in Abuja. The agent was smooth, the documents looked official, and the price seemed too good to pass up. Six months later, he discovered the land belonged to someone else entirely.</p>

            <p>But here's the twist: Ibrahim's tragedy wasn't the lost money. It was the lost time. At 45, he had planned to retire at 55 with rental income from multiple properties. Now, at 47, he's starting over, more cautious but also more cynical. The trust gap had stolen not just his savings, but his timeline for financial freedom.</p>

            <h2>How to Build Trust Before You Invest</h2>

            <p>Trust isn't given blindly—it's earned through verification. Here's how to evaluate potential partners:</p>

            <ul>
                <li><strong>Request references</strong> from recent clients, especially those who've completed transactions in the last six months</li>
                <li><strong>Verify all documentation</strong> independently—hire your own lawyer, visit the land registry yourself</li>
                <li><strong>Test their knowledge</strong> with specific questions about the area, legal requirements, and potential challenges</li>
                <li><strong>Observe their process</strong>—do they rush you or give you time to think? Do they welcome your questions or deflect them?</li>
                <li><strong>Check their digital footprint</strong>—reviews, social media presence, and how they handle complaints</li>
            </ul>

            <h2>The Waka Wealth Standard</h2>

            <p>At Waka Wealth Realty, we've built our business on a simple principle: We don't just sell properties—we build trust. Every client interaction, every transaction, every workshop we conduct is designed with one question in mind: "Would we recommend this to our own family?"</p>

            <p>Our free monthly workshops aren't marketing tactics—they're educational investments. We teach you to fish, then we fish together. We show you how to verify titles, how to spot red flags, and how to ask the right questions—even if those questions are directed at us.</p>

            <h2>The Bottom Line</h2>

            <p>Real estate investment will always carry risks. Markets fluctuate, regulations change, and perfect certainty is impossible. But when you have unshakeable trust in your partner, those risks become manageable. You're not navigating alone—you're walking alongside people who've made the journey before and who genuinely want you to succeed.</p>

            <p>Before you invest another naira in real estate, ask yourself: Do I trust these people with my family's future? If the answer isn't an immediate "yes," keep looking. Because the best investment you'll ever make isn't in property—it's in finding partners worthy of your trust.</p>
        `,
        category: 'Investment Strategy',
        readTime: '8 min read',
        author: 'Adebayo Okonkwo',
        authorBio: 'Senior Investment Advisor with over 15 years of experience helping clients build wealth through strategic real estate investments.',
        publishedAt: 'November 1, 2025',
        tags: ['trust', 'investment', 'strategy', 'due diligence'],
    }),
    relatedPosts: () => [],
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

const mockRelatedPosts: RelatedPost[] = [
    {
        id: 2,
        title: 'The Complete Guide to Site & Services Investment in Abuja',
        slug: 'complete-guide-sites-services',
        category: 'Beginner Guide',
        readTime: '12 min read',
    },
    {
        id: 3,
        title: 'Diaspora Investment: 5 Common Mistakes to Avoid',
        slug: 'diaspora-mistakes-avoid',
        category: 'Diaspora',
        readTime: '6 min read',
    },
    {
        id: 4,
        title: 'Understanding Property Appreciation in Nigeria\'s Top Cities',
        slug: 'property-appreciation-nigeria',
        category: 'Market Insights',
        readTime: '10 min read',
    },
];

const displayRelatedPosts = props.relatedPosts.length > 0 ? props.relatedPosts : mockRelatedPosts;

const keyTakeaways = [
    'Trust is the foundation of successful real estate investment—more important than the property itself',
    'Real trust requires radical transparency, proven track record, and post-purchase support',
    'Over 40% of land transactions in major Nigerian cities involve documentation irregularities',
    'Verify everything independently—hire your own lawyer and visit land registries yourself',
    'Before investing, ask: "Would I recommend this partner to my own family?"',
];

const nextSteps = [
    {
        title: 'Attend a Free Workshop',
        description: 'Join our "Waka to Wealth" workshop to learn how to verify titles and spot red flags',
        link: '/education/workshops',
        linkText: 'View Workshop Schedule',
    },
    {
        title: 'Book a Consultation',
        description: 'Discuss your investment goals with our experienced advisors in a free 30-minute session',
        link: '/contact',
        linkText: 'Schedule Now',
    },
    {
        title: 'Download Our Guide',
        description: 'Get our comprehensive due diligence checklist for property verification',
        link: '/education',
        linkText: 'Access Resources',
    },
];
</script>

<template>
    <Head :title="`${post.title} - Blog`" />

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

            <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-20">
                <div class="mb-6" data-aos="fade-up">
                    <Link
                        href="/blog"
                        class="inline-flex items-center text-gray-400 hover:text-white transition-colors"
                    >
                        <span>← Back to Blog</span>
                    </Link>
                </div>

                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#D31C00] text-white">
                            {{ post.category }}
                        </span>
                    </div>

                    <h1 class="mb-6 text-4xl font-bold text-white md:text-5xl leading-tight">
                        {{ post.title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 text-gray-300 mb-6">
                        <div class="flex items-center gap-2">
                            <User class="h-5 w-5 text-[#D31C00]" />
                            <span>{{ post.author }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Calendar class="h-5 w-5 text-[#D31C00]" />
                            <span>{{ post.publishedAt }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Clock class="h-5 w-5 text-[#D31C00]" />
                            <span>{{ post.readTime }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Article Content -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <article
                    class="prose prose-lg prose-invert max-w-none"
                    data-aos="fade-up"
                    v-html="post.content"
                ></article>

                <!-- Tags -->
                <div class="mt-12 pt-8 border-t border-gray-800" data-aos="fade-up">
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-2 text-gray-400">
                            <Tag class="h-5 w-5" />
                            <span class="font-semibold">Tags:</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="tag in post.tags"
                                :key="tag"
                                class="px-3 py-1 rounded-full text-sm bg-gray-800 text-gray-300"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Share -->
                <div class="mt-8 pt-8 border-t border-gray-800" data-aos="fade-up">
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-2 text-gray-400">
                            <Share2 class="h-5 w-5" />
                            <span class="font-semibold">Share:</span>
                        </div>
                        <div class="flex gap-3">
                            <a
                                href="#"
                                class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-800 text-gray-300 hover:bg-[#D31C00] hover:text-white transition-colors"
                            >
                                <Facebook class="h-5 w-5" />
                            </a>
                            <a
                                href="#"
                                class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-800 text-gray-300 hover:bg-[#D31C00] hover:text-white transition-colors"
                            >
                                <Twitter class="h-5 w-5" />
                            </a>
                            <a
                                href="#"
                                class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-800 text-gray-300 hover:bg-[#D31C00] hover:text-white transition-colors"
                            >
                                <Linkedin class="h-5 w-5" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Takeaways -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    Key <span class="text-[#D31C00]">Takeaways</span>
                </h2>

                <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8" data-aos="fade-up" data-aos-delay="100">
                    <ul class="space-y-4">
                        <li
                            v-for="(takeaway, index) in keyTakeaways"
                            :key="index"
                            class="flex items-start gap-3"
                        >
                            <CheckCircle2 class="h-6 w-6 text-[#D31C00] flex-shrink-0 mt-0.5" />
                            <span class="text-gray-300 text-lg">{{ takeaway }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Next Steps -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-12 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    Your <span class="text-[#D31C00]">Next Steps</span>
                </h2>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div
                        v-for="(step, index) in nextSteps"
                        :key="index"
                        class="rounded-2xl border border-gray-800 bg-black p-8 transition-all hover:border-[#D31C00]"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <h3 class="mb-4 text-xl font-bold text-white">{{ step.title }}</h3>
                        <p class="text-gray-400 mb-6 leading-relaxed">{{ step.description }}</p>
                        <Link
                            :href="step.link"
                            class="inline-flex items-center text-[#D31C00] font-semibold hover:underline"
                        >
                            <span>{{ step.linkText }}</span>
                            <ArrowRight class="h-4 w-4 ml-2" />
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Author Bio -->
        <section class="bg-black py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    About the <span class="text-[#D31C00]">Author</span>
                </h2>

                <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <div class="flex-shrink-0">
                            <div class="h-24 w-24 rounded-full bg-gradient-to-br from-[#D31C00] to-[#B01700] flex items-center justify-center">
                                <User class="h-12 w-12 text-white" />
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-white mb-2">
                                {{ post.author }}
                            </h3>
                            <p class="text-gray-300 leading-relaxed">
                                {{ post.authorBio }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Articles -->
        <section class="bg-gray-900 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-12 text-center text-3xl font-bold text-white md:text-4xl" data-aos="fade-up">
                    Related <span class="text-[#D31C00]">Articles</span>
                </h2>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <Link
                        v-for="(related, index) in displayRelatedPosts"
                        :key="related.id"
                        :href="`/blog/${related.slug}`"
                        class="group rounded-2xl border border-gray-800 bg-black p-6 transition-all hover:border-[#D31C00] hover:scale-105"
                        data-aos="fade-up"
                        :data-aos-delay="100 + (index * 100)"
                    >
                        <div class="mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400">
                                {{ related.category }}
                            </span>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white group-hover:text-[#D31C00] transition-colors leading-tight">
                            {{ related.title }}
                        </h3>
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <Clock class="h-4 w-4" />
                            <span>{{ related.readTime }}</span>
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
                        Ready to Take Action?
                    </h2>
                    <p class="mx-auto mb-12 max-w-2xl text-xl text-white/90" data-aos="fade-up" data-aos-delay="100">
                        Let's turn knowledge into wealth. Book a consultation or join our next workshop
                    </p>

                    <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                        <Link
                            href="/contact"
                            class="inline-flex items-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100"
                        >
                            <span>Book Consultation</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/education/workshops"
                            class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                        >
                            <span>View Workshops</span>
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

/* Prose styles for blog content */
:deep(.prose) {
    color: #d1d5db;
}

:deep(.prose h2) {
    color: #ffffff;
    font-size: 1.875rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

:deep(.prose h3) {
    color: #ffffff;
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

:deep(.prose p) {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    line-height: 1.75;
}

:deep(.prose ul) {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    list-style-type: disc;
    padding-left: 1.5rem;
}

:deep(.prose li) {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}

:deep(.prose strong) {
    color: #ffffff;
    font-weight: 600;
}

:deep(.prose em) {
    color: #D31C00;
    font-style: italic;
}

:deep(.prose a) {
    color: #D31C00;
    text-decoration: underline;
}

:deep(.prose a:hover) {
    color: #B01700;
}
</style>
