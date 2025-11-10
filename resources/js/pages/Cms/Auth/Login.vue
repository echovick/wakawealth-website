<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AuthCardLayout from '@/layouts/auth/AuthCardLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/cms/login', {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <AuthCardLayout
        title="CMS Login"
        description="Sign in to access the content management system"
    >
        <form @submit.prevent="submit" class="space-y-4">
            <div class="space-y-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    placeholder="admin@wakawealth.com"
                    required
                    autofocus
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="space-y-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                />
                <InputError :message="form.errors.password" />
            </div>

            <div class="flex items-center space-x-2">
                <Checkbox
                    id="remember"
                    :checked="form.remember"
                    @update:checked="form.remember = $event"
                />
                <Label for="remember" class="text-sm font-normal cursor-pointer">
                    Remember me
                </Label>
            </div>

            <Button
                type="submit"
                class="w-full"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Signing in...' : 'Sign in' }}
            </Button>
        </form>
    </AuthCardLayout>
</template>
