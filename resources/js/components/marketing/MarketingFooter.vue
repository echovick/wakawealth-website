<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Facebook, Instagram, Twitter, Linkedin, Mail, Phone, MapPin } from 'lucide-vue-next';

const footerLinks = {
    company: [
        { name: 'About Us', href: '/about' },
        { name: 'Our Team', href: '/team' },
        { name: 'Careers', href: '/about/careers' },
        { name: 'Contact', href: '/contact' },
    ],
    properties: [
        { name: 'All Properties', href: '/properties' },
        { name: 'Sites & Services', href: '/properties/sites' },
        { name: 'Homes', href: '/properties/homes' },
        { name: 'Locations', href: '/locations' },
    ],
    resources: [
        { name: 'Blog', href: '/education/blog' },
        { name: 'Investment Guides', href: '/education/guides' },
        { name: 'Workshops', href: '/education/workshops' },
        { name: 'FAQ', href: '/faq' },
    ],
    legal: [
        { name: 'Privacy Policy', href: '/privacy' },
        { name: 'Terms of Service', href: '/terms' },
        { name: 'Cookie Policy', href: '/cookies' },
    ],
};

const socialLinks = [
    { name: 'Facebook', icon: Facebook, href: '#' },
    { name: 'Instagram', icon: Instagram, href: '#' },
    { name: 'Twitter', icon: Twitter, href: '#' },
    { name: 'LinkedIn', icon: Linkedin, href: '#' },
];
</script>

<template>
    <footer class="bg-black text-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                <!-- Brand Section -->
                <div class="lg:col-span-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center">
                            <svg
                                viewBox="0 0 100 100"
                                class="h-full w-full text-white"
                                fill="currentColor"
                            >
                                <path
                                    d="M20 20 L35 70 L50 40 L65 70 L80 20 L70 20 L60 55 L50 30 L40 55 L30 20 Z"
                                />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold tracking-wider"
                                >WAKA WEALTH</span
                            >
                            <span class="text-[10px] tracking-[0.2em] text-gray-400"
                                >REALTY</span
                            >
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-400">
                        We walk with you to wealth. Your trusted companion on the
                        journey to financial freedom and generational prosperity.
                    </p>
                    <div class="mt-6 space-y-3 text-sm text-gray-400">
                        <div class="flex items-start space-x-3">
                            <MapPin class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-500" />
                            <span>Abuja, Nigeria</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <Phone class="h-5 w-5 flex-shrink-0 text-red-500" />
                            <span>+234 XXX XXX XXXX</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <Mail class="h-5 w-5 flex-shrink-0 text-red-500" />
                            <span>info@wakawealth.com</span>
                        </div>
                    </div>
                </div>

                <!-- Links Sections -->
                <div class="lg:col-span-8">
                    <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                        <!-- Company -->
                        <div>
                            <h3
                                class="text-sm font-semibold uppercase tracking-wider text-white"
                            >
                                Company
                            </h3>
                            <ul class="mt-4 space-y-3">
                                <li v-for="link in footerLinks.company" :key="link.name">
                                    <Link
                                        :href="link.href"
                                        class="text-sm text-gray-400 transition-colors hover:text-white"
                                    >
                                        {{ link.name }}
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        <!-- Properties -->
                        <div>
                            <h3
                                class="text-sm font-semibold uppercase tracking-wider text-white"
                            >
                                Properties
                            </h3>
                            <ul class="mt-4 space-y-3">
                                <li
                                    v-for="link in footerLinks.properties"
                                    :key="link.name"
                                >
                                    <Link
                                        :href="link.href"
                                        class="text-sm text-gray-400 transition-colors hover:text-white"
                                    >
                                        {{ link.name }}
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        <!-- Resources -->
                        <div>
                            <h3
                                class="text-sm font-semibold uppercase tracking-wider text-white"
                            >
                                Resources
                            </h3>
                            <ul class="mt-4 space-y-3">
                                <li
                                    v-for="link in footerLinks.resources"
                                    :key="link.name"
                                >
                                    <Link
                                        :href="link.href"
                                        class="text-sm text-gray-400 transition-colors hover:text-white"
                                    >
                                        {{ link.name }}
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        <!-- Legal -->
                        <div>
                            <h3
                                class="text-sm font-semibold uppercase tracking-wider text-white"
                            >
                                Legal
                            </h3>
                            <ul class="mt-4 space-y-3">
                                <li v-for="link in footerLinks.legal" :key="link.name">
                                    <Link
                                        :href="link.href"
                                        class="text-sm text-gray-400 transition-colors hover:text-white"
                                    >
                                        {{ link.name }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Links & Copyright -->
            <div
                class="mt-12 border-t border-gray-800 pt-8 md:flex md:items-center md:justify-between"
            >
                <div class="flex space-x-6">
                    <a
                        v-for="social in socialLinks"
                        :key="social.name"
                        :href="social.href"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-gray-400 transition-colors hover:text-white"
                    >
                        <span class="sr-only">{{ social.name }}</span>
                        <component :is="social.icon" class="h-6 w-6" />
                    </a>
                </div>
                <p class="mt-8 text-sm text-gray-400 md:mt-0">
                    &copy; {{ new Date().getFullYear() }} Waka Wealth Realty. All
                    rights reserved.
                </p>
            </div>

            <!-- Tagline -->
            <div class="mt-8 text-center">
                <p class="text-sm italic text-gray-500">
                    "Let's waka. Wealth is waiting."
                </p>
            </div>
        </div>
    </footer>
</template>
