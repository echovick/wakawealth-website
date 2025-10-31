<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { email } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthLayout
        title="Forgot Password?"
        description="No worries! Enter your email and we'll send you a reset link"
    >
        <Head title="Forgot password" />

        <div
            v-if="status"
            class="mb-4 rounded-sm bg-green-500/10 border border-green-500/20 p-3 text-center text-sm font-medium text-green-400"
        >
            {{ status }}
        </div>

        <div class="space-y-6">
            <Form v-bind="email.form()" v-slot="{ errors, processing }">
                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-semibold text-gray-300">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="off"
                        autofocus
                        placeholder="email@example.com"
                        class="w-full rounded-sm border border-gray-700 bg-gray-800 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                    />
                    <InputError :message="errors.email" class="text-sm text-red-400" />
                </div>

                <div class="my-6 flex items-center justify-start">
                    <Button
                        class="w-full rounded-sm bg-[#D31C00] py-3 font-semibold text-white transition-colors hover:bg-[#B01700] disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="processing"
                        data-test="email-password-reset-link-button"
                    >
                        <Spinner v-if="processing" class="mr-2" />
                        {{ processing ? 'Sending...' : 'Send reset link' }}
                    </Button>
                </div>
            </Form>

            <div class="space-x-1 text-center text-sm text-gray-400">
                <span>Remember your password?</span>
                <TextLink :href="login()" class="text-[#D31C00] hover:text-[#B01700] transition-colors font-semibold">Log in</TextLink>
            </div>
        </div>
    </AuthLayout>
</template>
