<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Phone, MessageCircle } from 'lucide-vue-next';

const email = ref('');
const isSubmitting = ref(false);

const handleSubmit = () => {
    isSubmitting.value = true;
    // Handle newsletter subscription
    setTimeout(() => {
        isSubmitting.value = false;
        email.value = '';
        // Show success message
    }, 1000);
};
</script>

<template>
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
                    Let's waka to wealth together. Your trusted companion on the journey to financial freedom.
                </p>

                <!-- Newsletter Form -->
                <div class="mb-12" data-aos="fade-up" data-aos-delay="300">
                    <form @submit.prevent="handleSubmit" class="mx-auto max-w-md">
                        <div class="flex flex-col gap-4 sm:flex-row">
                            <input
                                v-model="email"
                                type="email"
                                required
                                placeholder="Enter your email"
                                class="flex-1 rounded-sm px-6 py-4 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white"
                            />
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="inline-flex items-center justify-center space-x-2 rounded-sm bg-white px-8 py-4 font-semibold text-[#D31C00] transition-colors hover:bg-gray-100 disabled:opacity-50"
                            >
                                <span>{{ isSubmitting ? 'Subscribing...' : 'Subscribe' }}</span>
                                <ArrowRight class="h-5 w-5" />
                            </button>
                        </div>
                        <p class="mt-3 text-sm text-white/80">
                            Join our newsletter for investment tips and exclusive property listings
                        </p>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="400">
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
                        <Phone class="h-5 w-5" />
                        <span>Schedule Consultation</span>
                    </Link>
                    <a
                        href="https://wa.me/234XXXXXXXXX"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center space-x-2 rounded-sm border-2 border-white bg-transparent px-8 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-[#D31C00]"
                    >
                        <MessageCircle class="h-5 w-5" />
                        <span>WhatsApp Us</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
