<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import {
    Home,
    Calendar,
    BookOpen,
    TrendingUp,
    DollarSign,
    Clock,
    MapPin,
    ArrowRight,
    Plus,
    CheckCircle2,
} from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

// Mock data - will be replaced with real data from backend
const stats = [
    {
        icon: Home,
        label: 'Properties Owned',
        value: '3',
        change: '+1 this month',
        color: 'text-blue-400',
        bgColor: 'bg-blue-500/10',
    },
    {
        icon: Calendar,
        label: 'Appointments',
        value: '2',
        change: 'Upcoming',
        color: 'text-green-400',
        bgColor: 'bg-green-500/10',
    },
    {
        icon: BookOpen,
        label: 'Workshops Attended',
        value: '5',
        change: '1 this month',
        color: 'text-purple-400',
        bgColor: 'bg-purple-500/10',
    },
    {
        icon: TrendingUp,
        label: 'Portfolio Value',
        value: '₦45M',
        change: '+12% growth',
        color: 'text-[#D31C00]',
        bgColor: 'bg-[#D31C00]/10',
    },
];

const properties = [
    {
        id: 1,
        name: '3 Bedroom Apartment',
        location: 'Wuye, Abuja',
        purchaseDate: '2024-03-15',
        purchasePrice: '₦25,000,000',
        currentValue: '₦28,000,000',
        appreciation: '+12%',
        status: 'Owned',
        type: 'home',
    },
    {
        id: 2,
        name: '600sqm Land Plot',
        location: 'Lifecamp, Abuja',
        purchaseDate: '2024-06-20',
        purchasePrice: '₦12,000,000',
        currentValue: '₦13,500,000',
        appreciation: '+12.5%',
        status: 'Owned',
        type: 'site',
    },
    {
        id: 3,
        name: '4 Bedroom Duplex',
        location: 'Guzape, Abuja',
        purchaseDate: '2023-11-10',
        purchasePrice: '₦35,000,000',
        currentValue: '₦40,000,000',
        appreciation: '+14.3%',
        status: 'Owned',
        type: 'home',
    },
];

const appointments = [
    {
        id: 1,
        title: 'Property Inspection',
        date: '2025-11-05',
        time: '10:00 AM',
        location: 'Wuye District Office',
        type: 'inspection',
        status: 'upcoming',
    },
    {
        id: 2,
        title: 'Investment Consultation',
        date: '2025-11-08',
        time: '2:00 PM',
        location: 'Virtual (Zoom)',
        type: 'consultation',
        status: 'upcoming',
    },
    {
        id: 3,
        title: 'Property Viewing',
        date: '2025-10-28',
        time: '11:00 AM',
        location: 'Lifecamp, Abuja',
        type: 'viewing',
        status: 'completed',
    },
];

const workshops = [
    {
        id: 1,
        title: 'Real Estate Investment 101',
        date: '2025-10-15',
        status: 'completed',
        certificate: true,
    },
    {
        id: 2,
        title: 'Portfolio Diversification Strategies',
        date: '2025-09-22',
        status: 'completed',
        certificate: true,
    },
    {
        id: 3,
        title: 'Tax Optimization for Property Investors',
        date: '2025-11-12',
        status: 'registered',
        certificate: false,
    },
];

const recentActivity = [
    {
        id: 1,
        action: 'Property purchased',
        description: '600sqm Land Plot in Lifecamp',
        date: '2024-06-20',
        icon: Home,
    },
    {
        id: 2,
        action: 'Workshop completed',
        description: 'Real Estate Investment 101',
        date: '2025-10-15',
        icon: BookOpen,
    },
    {
        id: 3,
        action: 'Appointment scheduled',
        description: 'Property Inspection at Wuye',
        date: '2025-11-01',
        icon: Calendar,
    },
];

const activeTab = ref<'properties' | 'appointments' | 'workshops'>('properties');
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Welcome Section -->
            <div class="rounded-xl bg-gradient-to-r from-[#D31C00] to-[#B01700] p-8 text-white">
                <h1 class="mb-2 text-3xl font-bold">Welcome back!</h1>
                <p class="text-white/90">Here's an overview of your wealth-building journey</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="stat in stats"
                    :key="stat.label"
                    class="rounded-xl border border-gray-800 bg-gray-900 p-6 transition-all hover:border-[#D31C00]"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400">{{ stat.label }}</p>
                            <p class="mt-2 text-3xl font-bold text-white">{{ stat.value }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ stat.change }}</p>
                        </div>
                        <div :class="[stat.bgColor, 'rounded-full p-3']">
                            <component :is="stat.icon" :class="[stat.color, 'h-6 w-6']" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid gap-4 md:grid-cols-3">
                <Link
                    href="/properties"
                    class="group flex items-center justify-between rounded-xl border border-gray-800 bg-gray-900 p-4 transition-all hover:border-[#D31C00]"
                >
                    <div class="flex items-center gap-3">
                        <div class="rounded-full bg-blue-500/10 p-2">
                            <Home class="h-5 w-5 text-blue-400" />
                        </div>
                        <span class="font-semibold text-white">Browse Properties</span>
                    </div>
                    <ArrowRight class="h-5 w-5 text-gray-400 transition-transform group-hover:translate-x-1" />
                </Link>

                <Link
                    href="/contact?type=consultation"
                    class="group flex items-center justify-between rounded-xl border border-gray-800 bg-gray-900 p-4 transition-all hover:border-[#D31C00]"
                >
                    <div class="flex items-center gap-3">
                        <div class="rounded-full bg-green-500/10 p-2">
                            <Calendar class="h-5 w-5 text-green-400" />
                        </div>
                        <span class="font-semibold text-white">Book Consultation</span>
                    </div>
                    <ArrowRight class="h-5 w-5 text-gray-400 transition-transform group-hover:translate-x-1" />
                </Link>

                <Link
                    href="/education"
                    class="group flex items-center justify-between rounded-xl border border-gray-800 bg-gray-900 p-4 transition-all hover:border-[#D31C00]"
                >
                    <div class="flex items-center gap-3">
                        <div class="rounded-full bg-purple-500/10 p-2">
                            <BookOpen class="h-5 w-5 text-purple-400" />
                        </div>
                        <span class="font-semibold text-white">Join Workshop</span>
                    </div>
                    <ArrowRight class="h-5 w-5 text-gray-400 transition-transform group-hover:translate-x-1" />
                </Link>
            </div>

            <!-- Main Content Tabs -->
            <div class="rounded-xl border border-gray-800 bg-gray-900">
                <!-- Tab Headers -->
                <div class="border-b border-gray-800 p-4">
                    <div class="flex gap-4">
                        <button
                            @click="activeTab = 'properties'"
                            :class="[
                                'px-4 py-2 rounded-lg font-semibold transition-all',
                                activeTab === 'properties'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'text-gray-400 hover:text-white'
                            ]"
                        >
                            My Properties ({{ properties.length }})
                        </button>
                        <button
                            @click="activeTab = 'appointments'"
                            :class="[
                                'px-4 py-2 rounded-lg font-semibold transition-all',
                                activeTab === 'appointments'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'text-gray-400 hover:text-white'
                            ]"
                        >
                            Appointments ({{ appointments.filter(a => a.status === 'upcoming').length }})
                        </button>
                        <button
                            @click="activeTab = 'workshops'"
                            :class="[
                                'px-4 py-2 rounded-lg font-semibold transition-all',
                                activeTab === 'workshops'
                                    ? 'bg-[#D31C00] text-white'
                                    : 'text-gray-400 hover:text-white'
                            ]"
                        >
                            Workshops ({{ workshops.length }})
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Properties Tab -->
                    <div v-if="activeTab === 'properties'" class="space-y-4">
                        <div
                            v-for="property in properties"
                            :key="property.id"
                            class="rounded-lg border border-gray-800 bg-black p-6 transition-all hover:border-[#D31C00]"
                        >
                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-white">{{ property.name }}</h3>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400">
                                            {{ property.status }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-400 mb-3">
                                        <MapPin class="h-4 w-4" />
                                        <span>{{ property.location }}</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-400">Purchase Price:</span>
                                            <span class="ml-2 font-semibold text-white">{{ property.purchasePrice }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-400">Current Value:</span>
                                            <span class="ml-2 font-semibold text-white">{{ property.currentValue }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-400">Purchase Date:</span>
                                            <span class="ml-2 font-semibold text-white">{{ property.purchaseDate }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-400">Appreciation:</span>
                                            <span class="ml-2 font-semibold text-green-400">{{ property.appreciation }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <button class="rounded-lg bg-[#D31C00] px-6 py-2 font-semibold text-white transition-colors hover:bg-[#B01700]">
                                        View Details
                                    </button>
                                    <button class="rounded-lg border border-gray-700 px-6 py-2 font-semibold text-gray-300 transition-colors hover:border-[#D31C00] hover:text-white">
                                        Get Valuation
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-if="properties.length === 0" class="text-center py-12">
                            <Home class="h-16 w-16 text-gray-700 mx-auto mb-4" />
                            <p class="text-gray-400 mb-4">You don't own any properties yet</p>
                            <Link href="/properties" class="inline-flex items-center gap-2 rounded-lg bg-[#D31C00] px-6 py-3 font-semibold text-white transition-colors hover:bg-[#B01700]">
                                <Plus class="h-5 w-5" />
                                Browse Properties
                            </Link>
                        </div>
                    </div>

                    <!-- Appointments Tab -->
                    <div v-if="activeTab === 'appointments'" class="space-y-4">
                        <div
                            v-for="appointment in appointments"
                            :key="appointment.id"
                            class="rounded-lg border border-gray-800 bg-black p-6 transition-all hover:border-[#D31C00]"
                        >
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <h3 class="text-lg font-bold text-white">{{ appointment.title }}</h3>
                                        <span
                                            :class="[
                                                'px-3 py-1 rounded-full text-xs font-semibold',
                                                appointment.status === 'upcoming'
                                                    ? 'bg-blue-500/20 text-blue-400'
                                                    : 'bg-gray-700 text-gray-400'
                                            ]"
                                        >
                                            {{ appointment.status }}
                                        </span>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2 text-gray-400">
                                            <Calendar class="h-4 w-4" />
                                            <span>{{ appointment.date }} at {{ appointment.time }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-400">
                                            <MapPin class="h-4 w-4" />
                                            <span>{{ appointment.location }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button v-if="appointment.status === 'upcoming'" class="rounded-lg bg-[#D31C00] px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#B01700]">
                                        Reschedule
                                    </button>
                                    <button class="rounded-lg border border-gray-700 px-4 py-2 text-sm font-semibold text-gray-300 transition-colors hover:border-[#D31C00] hover:text-white">
                                        Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-if="appointments.filter(a => a.status === 'upcoming').length === 0" class="text-center py-12">
                            <Calendar class="h-16 w-16 text-gray-700 mx-auto mb-4" />
                            <p class="text-gray-400 mb-4">No upcoming appointments</p>
                            <Link href="/contact?type=consultation" class="inline-flex items-center gap-2 rounded-lg bg-[#D31C00] px-6 py-3 font-semibold text-white transition-colors hover:bg-[#B01700]">
                                <Plus class="h-5 w-5" />
                                Book Consultation
                            </Link>
                        </div>
                    </div>

                    <!-- Workshops Tab -->
                    <div v-if="activeTab === 'workshops'" class="space-y-4">
                        <div
                            v-for="workshop in workshops"
                            :key="workshop.id"
                            class="rounded-lg border border-gray-800 bg-black p-6 transition-all hover:border-[#D31C00]"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <h3 class="text-lg font-bold text-white">{{ workshop.title }}</h3>
                                        <span
                                            :class="[
                                                'px-3 py-1 rounded-full text-xs font-semibold',
                                                workshop.status === 'completed'
                                                    ? 'bg-green-500/20 text-green-400'
                                                    : 'bg-blue-500/20 text-blue-400'
                                            ]"
                                        >
                                            {{ workshop.status }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-400">
                                        <Clock class="h-4 w-4" />
                                        <span>{{ workshop.date }}</span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button v-if="workshop.certificate" class="flex items-center gap-2 rounded-lg border border-gray-700 px-4 py-2 text-sm font-semibold text-gray-300 transition-colors hover:border-[#D31C00] hover:text-white">
                                        <CheckCircle2 class="h-4 w-4" />
                                        Download Certificate
                                    </button>
                                    <button v-else class="rounded-lg bg-[#D31C00] px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#B01700]">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-if="workshops.length === 0" class="text-center py-12">
                            <BookOpen class="h-16 w-16 text-gray-700 mx-auto mb-4" />
                            <p class="text-gray-400 mb-4">You haven't attended any workshops yet</p>
                            <Link href="/education" class="inline-flex items-center gap-2 rounded-lg bg-[#D31C00] px-6 py-3 font-semibold text-white transition-colors hover:bg-[#B01700]">
                                <Plus class="h-5 w-5" />
                                Browse Workshops
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="rounded-xl border border-gray-800 bg-gray-900 p-6">
                <h2 class="mb-6 text-xl font-bold text-white">Recent Activity</h2>
                <div class="space-y-4">
                    <div
                        v-for="activity in recentActivity"
                        :key="activity.id"
                        class="flex items-start gap-4 rounded-lg border border-gray-800 bg-black p-4"
                    >
                        <div class="rounded-full bg-[#D31C00]/10 p-2">
                            <component :is="activity.icon" class="h-5 w-5 text-[#D31C00]" />
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-white">{{ activity.action }}</p>
                            <p class="text-sm text-gray-400">{{ activity.description }}</p>
                        </div>
                        <span class="text-sm text-gray-500">{{ activity.date }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
