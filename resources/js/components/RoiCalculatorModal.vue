<script setup lang="ts">
import { computed, ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Calculator, TrendingUp, Home, Building2 } from 'lucide-vue-next';

const isOpen = defineModel<boolean>('isOpen');

const propertyType = ref<'site' | 'house'>('site');
const investmentAmount = ref<number>(5000000);
const investmentYears = ref<number>(3);
const roiPercentage = ref<number>(50);

// Property type configurations
const propertyTypes = {
    site: {
        name: 'Site & Services',
        minPrice: 5000000,
        maxPrice: 100000000,
        avgRoi: 50,
        icon: Building2,
        color: 'text-blue-500',
    },
    house: {
        name: 'Houses',
        minPrice: 150000000,
        maxPrice: 700000000,
        avgRoi: 40,
        icon: Home,
        color: 'text-green-500',
    },
};

// Format currency
const formatCurrency = (value: number): string => {
    return new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: 'NGN',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(value);
};

// Calculate ROI
const projectedValue = computed(() => {
    const principal = investmentAmount.value;
    const rate = roiPercentage.value / 100;
    const time = investmentYears.value;

    // Compound interest formula: A = P(1 + r)^t
    return principal * Math.pow(1 + rate, time);
});

const totalReturn = computed(() => projectedValue.value - investmentAmount.value);

const percentageGain = computed(() => {
    return ((totalReturn.value / investmentAmount.value) * 100).toFixed(1);
});

// Update investment amount based on property type
const updatePropertyType = (type: 'site' | 'house') => {
    propertyType.value = type;
    const config = propertyTypes[type];
    investmentAmount.value = config.minPrice;
    roiPercentage.value = config.avgRoi;
};

const handleClose = () => {
    isOpen.value = false;
};
</script>

<template>
    <Dialog :open="isOpen" @update:open="handleClose">
        <DialogContent class="!max-w-4xl sm:!max-w-4xl !duration-700 p-0 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-0">
                <!-- Left Side - Calculator -->
                <div class="lg:col-span-3 p-8 md:p-10">
                    <DialogHeader class="space-y-4 text-left mb-6">
                        <div class="flex items-center gap-3">
                            <div class="rounded-full bg-[#D31C00]/10 p-3">
                                <Calculator class="h-6 w-6 text-[#D31C00]" />
                            </div>
                            <DialogTitle class="text-2xl md:text-3xl font-semibold">
                                ROI Calculator
                            </DialogTitle>
                        </div>
                        <DialogDescription class="text-base">
                            Estimate your potential returns from real estate investment
                        </DialogDescription>
                    </DialogHeader>

                    <div class="space-y-6">
                        <!-- Property Type -->
                        <div class="space-y-3">
                            <Label class="text-base font-semibold">Property Type</Label>
                            <div class="grid grid-cols-2 gap-3">
                                <button
                                    @click="updatePropertyType('site')"
                                    :class="[
                                        'flex flex-col items-center gap-2 rounded-lg border-2 p-4 transition-all',
                                        propertyType === 'site'
                                            ? 'border-[#D31C00] bg-[#D31C00]/5'
                                            : 'border-border hover:border-[#D31C00]/50',
                                    ]"
                                >
                                    <Building2 class="h-6 w-6" :class="propertyType === 'site' ? 'text-[#D31C00]' : 'text-muted-foreground'" />
                                    <span class="text-sm font-medium">Site & Services</span>
                                    <span class="text-xs text-muted-foreground">₦5M - ₦100M</span>
                                </button>
                                <button
                                    @click="updatePropertyType('house')"
                                    :class="[
                                        'flex flex-col items-center gap-2 rounded-lg border-2 p-4 transition-all',
                                        propertyType === 'house'
                                            ? 'border-[#D31C00] bg-[#D31C00]/5'
                                            : 'border-border hover:border-[#D31C00]/50',
                                    ]"
                                >
                                    <Home class="h-6 w-6" :class="propertyType === 'house' ? 'text-[#D31C00]' : 'text-muted-foreground'" />
                                    <span class="text-sm font-medium">Houses</span>
                                    <span class="text-xs text-muted-foreground">₦150M - ₦700M</span>
                                </button>
                            </div>
                        </div>

                        <!-- Investment Amount -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <Label class="text-base font-semibold">Investment Amount</Label>
                                <span class="text-sm font-semibold text-[#D31C00]">{{ formatCurrency(investmentAmount) }}</span>
                            </div>
                            <input
                                type="range"
                                v-model="investmentAmount"
                                :min="propertyTypes[propertyType].minPrice"
                                :max="propertyTypes[propertyType].maxPrice"
                                :step="propertyType === 'site' ? 1000000 : 10000000"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-[#D31C00]"
                            />
                            <div class="flex justify-between text-xs text-muted-foreground">
                                <span>{{ formatCurrency(propertyTypes[propertyType].minPrice) }}</span>
                                <span>{{ formatCurrency(propertyTypes[propertyType].maxPrice) }}</span>
                            </div>
                        </div>

                        <!-- Investment Duration -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <Label class="text-base font-semibold">Investment Duration</Label>
                                <span class="text-sm font-semibold text-[#D31C00]">{{ investmentYears }} {{ investmentYears === 1 ? 'Year' : 'Years' }}</span>
                            </div>
                            <input
                                type="range"
                                v-model="investmentYears"
                                min="1"
                                max="10"
                                step="1"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-[#D31C00]"
                            />
                            <div class="flex justify-between text-xs text-muted-foreground">
                                <span>1 Year</span>
                                <span>10 Years</span>
                            </div>
                        </div>

                        <!-- Expected ROI -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <Label class="text-base font-semibold">Expected Annual ROI</Label>
                                <span class="text-sm font-semibold text-[#D31C00]">{{ roiPercentage }}%</span>
                            </div>
                            <input
                                type="range"
                                v-model="roiPercentage"
                                min="30"
                                max="75"
                                step="5"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-[#D31C00]"
                            />
                            <div class="flex justify-between text-xs text-muted-foreground">
                                <span>30%</span>
                                <span>75%</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <Button @click="handleClose" variant="outline" class="w-full">
                            Close
                        </Button>
                    </div>
                </div>

                <!-- Right Side - Results -->
                <div class="lg:col-span-2 bg-gradient-to-br from-[#D31C00] to-[#B01700] p-8 md:p-10 text-white flex flex-col justify-center">
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-6">
                            <TrendingUp class="h-6 w-6" />
                            <h3 class="text-xl font-bold">Projected Returns</h3>
                        </div>

                        <!-- Initial Investment -->
                        <div class="rounded-lg bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-sm text-white/80 mb-1">Initial Investment</div>
                            <div class="text-2xl font-bold">{{ formatCurrency(investmentAmount) }}</div>
                        </div>

                        <!-- Projected Value -->
                        <div class="rounded-lg bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-sm text-white/80 mb-1">Projected Value</div>
                            <div class="text-2xl font-bold">{{ formatCurrency(projectedValue) }}</div>
                            <div class="text-xs text-white/70 mt-1">After {{ investmentYears }} {{ investmentYears === 1 ? 'year' : 'years' }}</div>
                        </div>

                        <!-- Total Return -->
                        <div class="rounded-lg bg-white/20 p-4 backdrop-blur-sm border-2 border-white/30">
                            <div class="text-sm text-white/80 mb-1">Total Return</div>
                            <div class="text-3xl font-bold">{{ formatCurrency(totalReturn) }}</div>
                            <div class="flex items-center gap-2 mt-2">
                                <TrendingUp class="h-4 w-4" />
                                <span class="text-sm font-semibold">{{ percentageGain }}% Gain</span>
                            </div>
                        </div>

                        <!-- Stats Badge -->
                        <div class="mt-8 pt-6 border-t border-white/20">
                            <div class="text-center">
                                <div class="text-4xl font-bold mb-2">100+</div>
                                <div class="text-sm text-white/80">Successful Investments</div>
                            </div>
                        </div>

                        <!-- Disclaimer -->
                        <div class="text-xs text-white/60 mt-4">
                            * Estimates based on historical market trends. Actual returns may vary based on location, property type, and market conditions.
                        </div>
                    </div>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>
