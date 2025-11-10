<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';

declare const route: any;
import { Button } from '@/components/ui/button';
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { MoreHorizontal } from 'lucide-vue-next';

interface Contact {
  id: number;
  name: string;
  email: string;
  subject: string;
  message: string;
  created_at: string;
}

interface Props {
  contacts: {
    data: Contact[];
    links: Array<{
      url: string | null;
      label: string;
      active: boolean;
    }>;
  };
}

const props = defineProps<Props>();

const deleteContact = (contactId: number): void => {
  if (confirm('Are you sure you want to delete this contact message?')) {
    router.delete(route('cms.contacts.destroy', contactId));
  }
};

const formatDate = (date: string): string => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};
</script>

<template>
  <Head title="Contacts" />

  <CmsLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Contact Messages</h1>
        <p class="text-muted-foreground">
          View and manage contact form submissions
        </p>
      </div>

      <div class="rounded-md border">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Name</TableHead>
              <TableHead>Email</TableHead>
              <TableHead>Subject</TableHead>
              <TableHead>Date</TableHead>
              <TableHead class="w-[70px]"></TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-if="contacts.data.length === 0">
              <TableCell colspan="5" class="text-center text-muted-foreground">
                No contact messages found.
              </TableCell>
            </TableRow>
            <TableRow v-for="contact in contacts.data" :key="contact.id">
              <TableCell class="font-medium">{{ contact.name }}</TableCell>
              <TableCell>{{ contact.email }}</TableCell>
              <TableCell>{{ contact.subject }}</TableCell>
              <TableCell class="text-muted-foreground">
                {{ formatDate(contact.created_at) }}
              </TableCell>
              <TableCell>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="ghost" size="icon">
                      <MoreHorizontal class="h-4 w-4" />
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent align="end">
                    <DropdownMenuItem as-child>
                      <Link :href="route('cms.contacts.show', contact.id)">
                        View
                      </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem
                      class="text-destructive"
                      @click="deleteContact(contact.id)"
                    >
                      Delete
                    </DropdownMenuItem>
                  </DropdownMenuContent>
                </DropdownMenu>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>

      <div v-if="contacts.links.length > 3" class="flex items-center justify-center space-x-2">
        <Link
          v-for="(link, index) in contacts.links"
          :key="index"
          :href="link.url || '#'"
          :class="[
            'px-3 py-2 text-sm rounded-md',
            link.active
              ? 'bg-primary text-primary-foreground'
              : 'hover:bg-muted',
            !link.url && 'opacity-50 pointer-events-none',
          ]"
          v-html="link.label"
        />
      </div>
    </div>
  </CmsLayout>
</template>
