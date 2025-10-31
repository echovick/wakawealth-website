<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <AuthBase
        title="Welcome Back"
        description="Log in to continue your wealth-building journey"
    >
        <Head title="Log in" />

        <div
            v-if="status"
            class="mb-4 rounded-sm bg-green-500/10 border border-green-500/20 p-3 text-center text-sm font-medium text-green-400"
        >
            {{ status }}
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-semibold text-gray-300">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                        class="w-full rounded-sm border border-gray-700 bg-gray-800 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                    />
                    <InputError :message="errors.email" class="text-sm text-red-400" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="text-sm font-semibold text-gray-300">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm text-[#D31C00] hover:text-[#B01700] transition-colors"
                            :tabindex="5"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                        class="w-full rounded-sm border border-gray-700 bg-gray-800 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                    />
                    <InputError :message="errors.password" class="text-sm text-red-400" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3 cursor-pointer">
                        <Checkbox id="remember" name="remember" :tabindex="3" class="border-gray-700 data-[state=checked]:bg-[#D31C00] data-[state=checked]:border-[#D31C00]" />
                        <span class="text-sm text-gray-300">Remember me</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full rounded-sm bg-[#D31C00] py-3 font-semibold text-white transition-colors hover:bg-[#B01700] disabled:opacity-50 disabled:cursor-not-allowed"
                    :tabindex="4"
                    :disabled="processing"
                    data-test="login-button"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    {{ processing ? 'Logging in...' : 'Log in' }}
                </Button>
            </div>

            <div
                class="text-center text-sm text-gray-400"
                v-if="canRegister"
            >
                Don't have an account?
                <TextLink :href="register()" :tabindex="5" class="text-[#D31C00] hover:text-[#B01700] transition-colors font-semibold">Sign up</TextLink>
            </div>
        </Form>
    </AuthBase>
</template>
