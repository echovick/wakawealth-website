<script setup lang="ts">
import MarketingNav from '@/components/marketing/MarketingNav.vue';
import MarketingFooter from '@/components/marketing/MarketingFooter.vue';
</script>

<template>
    <div class="min-h-screen bg-black">
        <MarketingNav />
        <main>
            <slot />
        </main>
        <MarketingFooter />
    </div>
</template>
