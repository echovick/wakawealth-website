<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Calendar, User, Mail, Phone, MessageSquare, CheckCircle2 } from 'lucide-vue-next';

const isOpen = defineModel<boolean>('isOpen');
const showSuccess = ref(false);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    preferred_date: '',
    preferred_time: '',
    consultation_type: 'property',
    message: '',
});

const consultationTypes = [
    { value: 'property', label: 'Property Investment' },
    { value: 'portfolio', label: 'Portfolio Review' },
    { value: 'market', label: 'Market Analysis' },
    { value: 'diaspora', label: 'Diaspora Investment' },
    { value: 'general', label: 'General Consultation' },
];

const submitForm = () => {
    form.post('/consultation/book', {
        preserveScroll: true,
        onSuccess: () => {
            showSuccess.value = true;
            setTimeout(() => {
                showSuccess.value = false;
                isOpen.value = false;
                form.reset();
            }, 3000);
        },
    });
};

const handleClose = () => {
    if (!form.processing) {
        isOpen.value = false;
        form.reset();
        showSuccess.value = false;
    }
};
</script>

<template>
    <Dialog :open="isOpen" @update:open="handleClose">
        <DialogContent class="!max-w-2xl sm:!max-w-2xl !duration-700 p-0 overflow-hidden">
            <!-- Success State -->
            <div v-if="showSuccess" class="p-10 text-center">
                <div class="mb-6 flex justify-center">
                    <div class="rounded-full bg-green-100 p-4 dark:bg-green-900/20">
                        <CheckCircle2 class="h-16 w-16 text-green-600 dark:text-green-500" />
                    </div>
                </div>
                <h3 class="mb-3 text-2xl font-bold text-foreground">Consultation Booked!</h3>
                <p class="text-muted-foreground">
                    Thank you for booking a consultation with us. We'll contact you shortly to confirm your appointment.
                </p>
            </div>

            <!-- Form State -->
            <div v-else class="p-8 md:p-10">
                <DialogHeader class="space-y-4 text-left mb-6">
                    <div class="flex items-center gap-3">
                        <div class="rounded-full bg-[#D31C00]/10 p-3">
                            <Calendar class="h-6 w-6 text-[#D31C00]" />
                        </div>
                        <DialogTitle class="text-2xl md:text-3xl font-semibold">
                            Book Free Consultation
                        </DialogTitle>
                    </div>
                    <DialogDescription class="text-base">
                        Schedule a 30-minute one-on-one session with our investment advisors. No obligation, completely free.
                    </DialogDescription>
                </DialogHeader>

                <form @submit.prevent="submitForm" class="space-y-5">
                    <!-- Name -->
                    <div class="space-y-2">
                        <Label for="consultation-name" class="text-sm font-semibold">Full Name *</Label>
                        <div class="relative">
                            <User class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
                            <input
                                id="consultation-name"
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full rounded-sm border border-input bg-background py-2.5 pl-10 pr-4 text-foreground placeholder:text-muted-foreground focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                placeholder="Enter your full name"
                            />
                        </div>
                        <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
                    </div>

                    <!-- Email and Phone -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <Label for="consultation-email" class="text-sm font-semibold">Email *</Label>
                            <div class="relative">
                                <Mail class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
                                <input
                                    id="consultation-email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    class="w-full rounded-sm border border-input bg-background py-2.5 pl-10 pr-4 text-foreground placeholder:text-muted-foreground focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                    placeholder="your@email.com"
                                />
                            </div>
                            <p v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="consultation-phone" class="text-sm font-semibold">Phone *</Label>
                            <div class="relative">
                                <Phone class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
                                <input
                                    id="consultation-phone"
                                    v-model="form.phone"
                                    type="tel"
                                    required
                                    class="w-full rounded-sm border border-input bg-background py-2.5 pl-10 pr-4 text-foreground placeholder:text-muted-foreground focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                    placeholder="08012345678"
                                />
                            </div>
                            <p v-if="form.errors.phone" class="text-sm text-red-500">{{ form.errors.phone }}</p>
                        </div>
                    </div>

                    <!-- Preferred Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <Label for="consultation-date" class="text-sm font-semibold">Preferred Date *</Label>
                            <input
                                id="consultation-date"
                                v-model="form.preferred_date"
                                type="date"
                                required
                                :min="new Date().toISOString().split('T')[0]"
                                class="w-full rounded-sm border border-input bg-background py-2.5 px-4 text-foreground focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                            />
                            <p v-if="form.errors.preferred_date" class="text-sm text-red-500">{{ form.errors.preferred_date }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="consultation-time" class="text-sm font-semibold">Preferred Time *</Label>
                            <input
                                id="consultation-time"
                                v-model="form.preferred_time"
                                type="time"
                                required
                                class="w-full rounded-sm border border-input bg-background py-2.5 px-4 text-foreground focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                            />
                            <p v-if="form.errors.preferred_time" class="text-sm text-red-500">{{ form.errors.preferred_time }}</p>
                        </div>
                    </div>

                    <!-- Consultation Type -->
                    <div class="space-y-2">
                        <Label for="consultation-type" class="text-sm font-semibold">Consultation Type *</Label>
                        <select
                            id="consultation-type"
                            v-model="form.consultation_type"
                            required
                            class="w-full rounded-sm border border-input bg-background py-2.5 px-4 text-foreground focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                        >
                            <option v-for="type in consultationTypes" :key="type.value" :value="type.value">
                                {{ type.label }}
                            </option>
                        </select>
                        <p v-if="form.errors.consultation_type" class="text-sm text-red-500">{{ form.errors.consultation_type }}</p>
                    </div>

                    <!-- Message -->
                    <div class="space-y-2">
                        <Label for="consultation-message" class="text-sm font-semibold">Additional Information</Label>
                        <div class="relative">
                            <MessageSquare class="absolute left-3 top-3 h-5 w-5 text-muted-foreground" />
                            <textarea
                                id="consultation-message"
                                v-model="form.message"
                                rows="3"
                                class="w-full rounded-sm border border-input bg-background py-2.5 pl-10 pr-4 text-foreground placeholder:text-muted-foreground focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                placeholder="Tell us what you'd like to discuss..."
                            ></textarea>
                        </div>
                        <p v-if="form.errors.message" class="text-sm text-red-500">{{ form.errors.message }}</p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-3 pt-2">
                        <Button
                            type="button"
                            @click="handleClose"
                            variant="outline"
                            class="flex-1"
                            :disabled="form.processing"
                        >
                            Cancel
                        </Button>
                        <Button
                            type="submit"
                            class="flex-1 bg-[#D31C00] hover:bg-[#B01700]"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Booking...' : 'Book Consultation' }}
                        </Button>
                    </div>
                </form>
            </div>
        </DialogContent>
    </Dialog>
</template>
