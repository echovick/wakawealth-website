<script setup lang="ts">
import { Star } from 'lucide-vue-next';

interface Testimonial {
    id: number;
    clientName: string;
    clientLocation: string;
    content: string;
    rating: number;
    photo?: string;
}

interface Props {
    testimonials: Testimonial[];
}

defineProps<Props>();

const mockTestimonials = [
    {
        id: 1,
        clientName: 'John M',
        clientLocation: 'Nigeria',
        content: 'Working with Waka Wealth was an exceptional experience. Their professionalism and dedication made the entire process seamless. The property I acquired has exceeded expectations and proven to be both a comfortable residence and a savvy financial investment.',
        rating: 5,
    },
    {
        id: 2,
        clientName: 'Sarah A',
        clientLocation: 'UK (Diaspora)',
        content: 'As a diaspora investor, I was hesitant about investing back home. Waka Wealth provided virtual tours, regular updates, and local representation that gave me complete peace of mind. Best decision I ever made!',
        rating: 5,
    },
    {
        id: 3,
        clientName: 'David O',
        clientLocation: 'Lagos',
        content: 'The education-first approach is what sets Waka Wealth apart. They took time to explain everything, answered all my questions, and guided me through the entire process. I felt empowered, not pressured.',
        rating: 5,
    },
];
</script>

<template>
    <section class="bg-gray-900 py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-16 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-4 text-4xl font-bold text-white md:text-5xl">
                    Client <span class="text-[#D31C00]">Success Stories</span>
                </h2>
                <p class="mx-auto max-w-2xl text-lg text-gray-400">
                    Don't take our word for it—see what happens when you choose us
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="(testimonial, index) in testimonials.length > 0 ? testimonials : mockTestimonials"
                    :key="testimonial.id"
                    class="rounded-2xl bg-gray-800 p-8 shadow-sm border border-gray-700"
                    data-aos="fade-up"
                    :data-aos-delay="200 + (index * 100)"
                >
                    <!-- Rating -->
                    <div class="mb-4 flex space-x-1">
                        <Star
                            v-for="i in testimonial.rating"
                            :key="i"
                            class="h-5 w-5 fill-yellow-400 text-yellow-400"
                        />
                    </div>

                    <!-- Content -->
                    <p class="mb-6 text-gray-300 leading-relaxed">
                        "{{ testimonial.content }}"
                    </p>

                    <!-- Client Info -->
                    <div class="flex items-center space-x-4 border-t border-gray-200 pt-6">
                        <div class="h-12 w-12 flex-shrink-0 rounded-full bg-gradient-to-br from-red-400 to-orange-400" />
                        <div>
                            <div class="font-bold text-white">{{ testimonial.clientName }}</div>
                            <div class="text-sm text-gray-500">{{ testimonial.clientLocation }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
