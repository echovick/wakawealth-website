<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { onMounted, ref } from 'vue';

const isOpen = ref(false);

onMounted(() => {
    // Show modal after a short delay for better UX
    setTimeout(() => {
        isOpen.value = true;
    }, 500);
});

const handleClose = () => {
    isOpen.value = false;
};
</script>

<template>
    <Transition
        enter-active-class="transition-all duration-700 ease-out"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition-all duration-300 ease-in"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
        <Dialog :open="isOpen" @update:open="handleClose">
            <DialogContent class="!max-w-5xl sm:!max-w-5xl !duration-700 p-0 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                    <!-- Image Section -->
                    <div class="relative h-64 md:h-auto overflow-hidden">
                        <img
                            src="/assets/ceo-portrait.jpg"
                            alt="Comfort Enayi Amos-Kwari, CEO of Waka Wealth"
                            class="h-full w-full object-cover"
                        />
                    </div>

                    <!-- Content Section -->
                    <div class="flex flex-col justify-center p-8 md:p-10">
                        <DialogHeader class="space-y-4 text-left">
                            <DialogTitle class="text-2xl md:text-3xl font-semibold">
                                Welcome to Waka Wealth
                            </DialogTitle>
                            <DialogDescription class="space-y-4 text-base leading-relaxed">
                                <p>
                                    Every journey begins with a step and we are honored you
                                    chose to take this one with us.
                                </p>
                                <p>
                                    Here, your dreams are seen, your goals matter, and your
                                    wealth journey truly begins.
                                </p>
                                <p class="font-medium">
                                    Let's walk into Wealth together.
                                </p>
                                <div class="mt-6 border-t border-border pt-4">
                                    <p class="font-semibold text-foreground">Comfort Enayi Amos-Kwari</p>
                                    <p class="text-sm text-muted-foreground">
                                        CEO, Waka Wealth
                                    </p>
                                </div>
                            </DialogDescription>
                        </DialogHeader>

                        <div class="mt-6">
                            <Button @click="handleClose" class="w-full md:w-auto min-w-32">
                                Get Started
                            </Button>
                        </div>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </Transition>
</template>
