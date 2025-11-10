<script setup lang="ts">
import { cn } from '@/lib/utils';
import { useAttrs } from 'vue';

const attrs = useAttrs();
</script>

<template>
    <div class="relative w-full overflow-auto">
        <table
            :class="cn('w-full caption-bottom text-sm', attrs.class)"
            v-bind="$attrs"
        >
            <slot />
        </table>
    </div>
</template>
