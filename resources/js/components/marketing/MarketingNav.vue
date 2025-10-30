<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Menu, X } from 'lucide-vue-next';

const mobileMenuOpen = ref(false);
const isScrolled = ref(false);
const isNavVisible = ref(false);

const navigation = [
    { name: 'About', href: '/about' },
    { name: 'Properties', href: '/properties' },
    { name: 'Locations', href: '/locations' },
    { name: 'Investment', href: '/investment/why-invest' },
    { name: 'Education', href: '/education/blog' },
    { name: 'Contact', href: '/contact' },
];

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);

    // Fade in navigation after a brief delay
    setTimeout(() => {
        isNavVisible.value = true;
    }, 300);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <nav
        class="absolute top-0 z-50 w-full bg-transparent transition-opacity duration-700"
        :class="{ 'opacity-100': isNavVisible, 'opacity-0': !isNavVisible }"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="flex items-center">
                        <img
                            src="/assets/logo-dark-1.png"
                            alt="Waka Wealth Realty"
                            class="h-35 w-auto"
                        />
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden items-center space-x-8 lg:flex">
                    <Link
                        v-for="item in navigation"
                        :key="item.name"
                        :href="item.href"
                        class="text-sm font-medium text-white transition-colors hover:text-[#D31C00]"
                    >
                        {{ item.name }}
                    </Link>

                    <!-- CTA Button -->
                    <Link
                        href="/dashboard"
                        class="rounded-sm bg-[#D31C00] px-6 py-2.5 text-sm font-medium text-white transition-colors hover:bg-[#B01700]"
                    >
                        Get Started
                    </Link>
                </div>

                <!-- Mobile menu button -->
                <div class="flex lg:hidden">
                    <button
                        type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center rounded-md p-2 text-white hover:bg-white/10"
                    >
                        <span class="sr-only">Open main menu</span>
                        <Menu v-if="!mobileMenuOpen" class="h-6 w-6" />
                        <X v-else class="h-6 w-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div v-show="mobileMenuOpen" class="border-t border-white/10 bg-transparent lg:hidden">
            <div class="space-y-1 px-4 pb-3 pt-2">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-white/10"
                    @click="mobileMenuOpen = false"
                >
                    {{ item.name }}
                </Link>
                <Link
                    href="/dashboard"
                    class="mt-4 block w-full rounded-sm bg-[#D31C00] px-6 py-3 text-center text-base font-medium text-white hover:bg-[#B01700]"
                    @click="mobileMenuOpen = false"
                >
                    Get Started
                </Link>
            </div>
        </div>
    </nav>
</template>
