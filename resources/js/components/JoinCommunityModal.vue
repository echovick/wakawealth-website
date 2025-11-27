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
import { Users, Mail, CheckCircle2 } from 'lucide-vue-next';

const isOpen = defineModel<boolean>('isOpen');
const showSuccess = ref(false);

const form = useForm({
    email: '',
});

const submitForm = () => {
    form.post('/community/join', {
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
        <DialogContent class="!max-w-md sm:!max-w-md !duration-700 overflow-hidden">
            <!-- Success State -->
            <div v-if="showSuccess" class="p-8 text-center">
                <div class="mb-6 flex justify-center">
                    <div class="rounded-full bg-green-100 p-4 dark:bg-green-900/20">
                        <CheckCircle2 class="h-12 w-12 text-green-600 dark:text-green-500" />
                    </div>
                </div>
                <h3 class="mb-3 text-xl font-bold text-foreground">Welcome to the Community!</h3>
                <p class="text-muted-foreground">
                    Thank you for joining! You'll receive exclusive updates, investment tips, and community news.
                </p>
            </div>

            <!-- Form State -->
            <div v-else>
                <DialogHeader class="space-y-4 text-center mb-6">
                    <div class="flex justify-center mb-2">
                        <div class="rounded-full bg-[#D31C00]/10 p-4">
                            <Users class="h-8 w-8 text-[#D31C00]" />
                        </div>
                    </div>
                    <DialogTitle class="text-2xl md:text-3xl font-semibold">
                        Join Our Community
                    </DialogTitle>
                    <DialogDescription class="text-base">
                        Connect with other investors, get exclusive updates, market insights, and early access to new properties.
                    </DialogDescription>
                </DialogHeader>

                <form @submit.prevent="submitForm" class="space-y-5">
                    <!-- Email -->
                    <div class="space-y-2">
                        <Label for="community-email" class="text-sm font-semibold">Email Address *</Label>
                        <div class="relative">
                            <Mail class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
                            <input
                                id="community-email"
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full rounded-sm border border-input bg-background py-3 pl-10 pr-4 text-foreground placeholder:text-muted-foreground focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                                placeholder="your@email.com"
                                autofocus
                            />
                        </div>
                        <p v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</p>
                    </div>

                    <!-- Benefits List -->
                    <div class="rounded-lg bg-muted/50 p-4">
                        <p class="text-sm font-semibold text-foreground mb-3">What you'll get:</p>
                        <ul class="space-y-2 text-sm text-muted-foreground">
                            <li class="flex items-start gap-2">
                                <CheckCircle2 class="h-4 w-4 text-[#D31C00] mt-0.5 flex-shrink-0" />
                                <span>Weekly market insights and property alerts</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <CheckCircle2 class="h-4 w-4 text-[#D31C00] mt-0.5 flex-shrink-0" />
                                <span>Exclusive investment tips and strategies</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <CheckCircle2 class="h-4 w-4 text-[#D31C00] mt-0.5 flex-shrink-0" />
                                <span>Early access to new property listings</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <CheckCircle2 class="h-4 w-4 text-[#D31C00] mt-0.5 flex-shrink-0" />
                                <span>Invitations to community events and workshops</span>
                            </li>
                        </ul>
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
                            {{ form.processing ? 'Joining...' : 'Join Now' }}
                        </Button>
                    </div>
                </form>
            </div>
        </DialogContent>
    </Dialog>
</template>
