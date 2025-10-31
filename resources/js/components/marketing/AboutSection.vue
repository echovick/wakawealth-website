<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';
</script>

<template>
    <section class="bg-gray-900 py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
                <!-- Text Content -->
                <div data-aos="fade-right" data-aos-delay="100">
                    <div class="mb-4 inline-block">
                        <span
                            class="rounded-full bg-[#D31C00]/20 px-4 py-1.5 text-sm font-semibold text-[#D31C00]"
                        >
                            Origin & Philosophy
                        </span>
                    </div>
                    <h2 class="mb-6 text-4xl font-bold text-white md:text-5xl">
                        What does
                        <span class="text-[#D31C00]">Waka</span>
                        mean?
                    </h2>
                    <div class="space-y-4 text-lg leading-relaxed text-gray-300">
                        <p>
                            <span class="font-semibold text-white">"Waka"</span> means to walk, to move, to journey forward in West African pidgin English, while <span class="font-semibold text-white">"Wealth"</span> represents the prosperity, security, and generational legacy that every family deserves.
                        </p>
                        <p>
                            The word "waka" resonates with millions across Nigeria, Ghana, and the broader West African diaspora—it's a word that feels like home. It's <span class="font-semibold text-white">informal, approachable, and warm</span>, yet carries the weight of determination and hustle.
                        </p>
                        <p>
                            We believe that building wealth through real estate and smart investments isn't about sudden windfalls or shortcuts. It's about taking <span class="font-semibold text-white">intentional steps</span>, making <span class="font-semibold text-white">informed decisions</span>, and moving forward with purpose—one property, one investment, one milestone at a time.
                        </p>
                    </div>

                    <!-- Cultural Values -->
                    <div class="mt-8 rounded-2xl bg-gray-800 p-6 shadow-sm border border-gray-700">
                        <h3 class="mb-4 text-lg font-semibold text-white">
                            In African communities, real estate represents more than just property—it's a symbol of:
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span
                                    class="mr-3 mt-1 h-5 w-5 flex-shrink-0 rounded-full bg-[#D31C00]/20 p-1"
                                >
                                    <svg
                                        class="h-full w-full text-[#D31C00]"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                                <span class="text-gray-300"
                                    ><span class="font-semibold">Stability</span> for your
                                    family</span
                                >
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="mr-3 mt-1 h-5 w-5 flex-shrink-0 rounded-full bg-[#D31C00]/20 p-1"
                                >
                                    <svg
                                        class="h-full w-full text-[#D31C00]"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                                <span class="text-gray-300"
                                    ><span class="font-semibold">Legacy</span> for your
                                    children</span
                                >
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="mr-3 mt-1 h-5 w-5 flex-shrink-0 rounded-full bg-[#D31C00]/20 p-1"
                                >
                                    <svg
                                        class="h-full w-full text-[#D31C00]"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                                <span class="text-gray-300"
                                    ><span class="font-semibold">Status</span> in your
                                    community</span
                                >
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="mr-3 mt-1 h-5 w-5 flex-shrink-0 rounded-full bg-[#D31C00]/20 p-1"
                                >
                                    <svg
                                        class="h-full w-full text-[#D31C00]"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                                <span class="text-gray-300"
                                    ><span class="font-semibold">Freedom</span> from
                                    financial uncertainty</span
                                >
                            </li>
                        </ul>
                    </div>

                    <div class="mt-8">
                        <Link
                            href="/about"
                            class="inline-flex items-center space-x-2 rounded-sm bg-[#D31C00] px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-[#B01700]"
                        >
                            <span>Learn Our Story</span>
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                    </div>
                </div>

                <!-- Image Grid -->
                <div class="relative" data-aos="fade-left" data-aos-delay="200">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div
                                class="aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800 to-gray-700"
                            >
                                <!-- Image placeholder -->
                            </div>
                            <div
                                class="aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800"
                            >
                                <!-- Image placeholder -->
                            </div>
                        </div>
                        <div class="mt-8 space-y-4">
                            <div
                                class="aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800 to-gray-700"
                            >
                                <!-- Image placeholder -->
                            </div>
                            <div
                                class="aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800"
                            >
                                <!-- Image placeholder -->
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div
                        class="absolute -bottom-4 -left-4 rounded-2xl bg-black border border-gray-800 p-6 shadow-xl"
                    >
                        <div class="text-center">
                            <div class="text-4xl font-bold text-[#D31C00]">10+</div>
                            <div class="text-sm font-medium text-gray-400">
                                Years Building<br />Legacies
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
