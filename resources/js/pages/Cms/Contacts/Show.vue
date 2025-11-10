<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';

const route = (window as any).route;
import { Button } from '@/components/ui/button';
import { ArrowLeft, Trash2 } from 'lucide-vue-next';

interface Contact {
  id: number;
  name: string;
  email: string;
  phone: string | null;
  subject: string;
  message: string;
  created_at: string;
}

interface Props {
  contact: Contact;
}

const props = defineProps<Props>();

const deleteContact = (): void => {
  if (confirm('Are you sure you want to delete this contact message?')) {
    router.delete(route('cms.contacts.destroy', props.contact.id), {
      onSuccess: () => {
        router.visit(route('cms.contacts.index'));
      },
    });
  }
};

const formatDate = (date: string): string => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};
</script>

<template>
  <Head :title="`Contact from ${contact.name}`" />

  <CmsLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <Link :href="route('cms.contacts.index')">
            <Button variant="ghost" size="icon">
              <ArrowLeft class="h-4 w-4" />
            </Button>
          </Link>
          <div>
            <h1 class="text-3xl font-bold tracking-tight">Contact Message</h1>
            <p class="text-muted-foreground">
              Received {{ formatDate(contact.created_at) }}
            </p>
          </div>
        </div>
        <Button variant="destructive" @click="deleteContact">
          <Trash2 class="mr-2 h-4 w-4" />
          Delete
        </Button>
      </div>

      <div class="rounded-lg border bg-card">
        <div class="p-6 space-y-6">
          <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-2">
              <h3 class="text-sm font-medium text-muted-foreground">Name</h3>
              <p class="text-lg">{{ contact.name }}</p>
            </div>

            <div class="space-y-2">
              <h3 class="text-sm font-medium text-muted-foreground">Email</h3>
              <a
                :href="`mailto:${contact.email}`"
                class="text-lg text-primary hover:underline"
              >
                {{ contact.email }}
              </a>
            </div>

            <div v-if="contact.phone" class="space-y-2">
              <h3 class="text-sm font-medium text-muted-foreground">Phone</h3>
              <a
                :href="`tel:${contact.phone}`"
                class="text-lg text-primary hover:underline"
              >
                {{ contact.phone }}
              </a>
            </div>

            <div class="space-y-2">
              <h3 class="text-sm font-medium text-muted-foreground">Subject</h3>
              <p class="text-lg">{{ contact.subject }}</p>
            </div>
          </div>

          <div class="space-y-2">
            <h3 class="text-sm font-medium text-muted-foreground">Message</h3>
            <div class="rounded-md border bg-muted/50 p-4">
              <p class="whitespace-pre-wrap">{{ contact.message }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </CmsLayout>
</template>
