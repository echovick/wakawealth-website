<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { store } from '@/routes/register';
import { Form, Head } from '@inertiajs/vue3';
</script>

<template>
    <AuthBase
        title="Start Your Journey"
        description="Create your account and start building wealth today"
    >
        <Head title="Register" />

        <Form
            v-bind="store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name" class="text-sm font-semibold text-gray-300">Full Name</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Enter your full name"
                        class="w-full rounded-sm border border-gray-700 bg-gray-800 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                    />
                    <InputError :message="errors.name" class="text-sm text-red-400" />
                </div>

                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-semibold text-gray-300">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder="email@example.com"
                        class="w-full rounded-sm border border-gray-700 bg-gray-800 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                    />
                    <InputError :message="errors.email" class="text-sm text-red-400" />
                </div>

                <div class="grid gap-2">
                    <Label for="password" class="text-sm font-semibold text-gray-300">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Create a strong password"
                        class="w-full rounded-sm border border-gray-700 bg-gray-800 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                    />
                    <InputError :message="errors.password" class="text-sm text-red-400" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation" class="text-sm font-semibold text-gray-300">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Re-enter your password"
                        class="w-full rounded-sm border border-gray-700 bg-gray-800 py-3 px-4 text-white placeholder-gray-500 focus:border-[#D31C00] focus:outline-none focus:ring-1 focus:ring-[#D31C00]"
                    />
                    <InputError :message="errors.password_confirmation" class="text-sm text-red-400" />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full rounded-sm bg-[#D31C00] py-3 font-semibold text-white transition-colors hover:bg-[#B01700] disabled:opacity-50 disabled:cursor-not-allowed"
                    tabindex="5"
                    :disabled="processing"
                    data-test="register-user-button"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    {{ processing ? 'Creating account...' : 'Create account' }}
                </Button>
            </div>

            <div class="text-center text-sm text-gray-400">
                Already have an account?
                <TextLink
                    :href="login()"
                    class="text-[#D31C00] hover:text-[#B01700] transition-colors font-semibold"
                    :tabindex="6"
                    >Log in</TextLink
                >
            </div>
        </Form>
    </AuthBase>
</template>
