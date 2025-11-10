<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
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
import { Switch } from '@/components/ui/switch';
import { MoreHorizontal, Plus } from 'lucide-vue-next';

interface FieldGroup {
  id: number;
  title: string;
  key: string;
  active: boolean;
  fields_count: number;
}

interface Props {
  fieldGroups: {
    data: FieldGroup[];
    links: Array<{
      url: string | null;
      label: string;
      active: boolean;
    }>;
  };
}

const props = defineProps<Props>();

const deleteFieldGroup = (fieldGroupId: number): void => {
  if (confirm('Are you sure you want to delete this field group? All associated fields will be deleted.')) {
    router.delete(`/cms/field-groups/${fieldGroupId}`);
  }
};

const toggleActive = (fieldGroup: FieldGroup): void => {
  router.put(`/cms/field-groups/${fieldGroup.id}`, {
    ...fieldGroup,
    active: !fieldGroup.active,
  }, {
    preserveScroll: true,
  });
};
</script>

<template>
  <Head title="Field Groups" />

  <CmsLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold tracking-tight">Field Groups</h1>
          <p class="text-muted-foreground">
            Create and manage custom field groups for your content
          </p>
        </div>
        <Link href="/cms/field-groups/create">
          <Button>
            <Plus class="mr-2 h-4 w-4" />
            New Field Group
          </Button>
        </Link>
      </div>

      <div class="rounded-md border">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Title</TableHead>
              <TableHead>Key</TableHead>
              <TableHead>Fields</TableHead>
              <TableHead>Status</TableHead>
              <TableHead class="w-[70px]"></TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-if="fieldGroups.data.length === 0">
              <TableCell colspan="5" class="text-center text-muted-foreground">
                No field groups found. Create your first field group to get started.
              </TableCell>
            </TableRow>
            <TableRow v-for="fieldGroup in fieldGroups.data" :key="fieldGroup.id">
              <TableCell class="font-medium">{{ fieldGroup.title }}</TableCell>
              <TableCell class="text-muted-foreground">{{ fieldGroup.key }}</TableCell>
              <TableCell>
                {{ fieldGroup.fields_count }} {{ fieldGroup.fields_count === 1 ? 'field' : 'fields' }}
              </TableCell>
              <TableCell>
                <Switch
                  :checked="fieldGroup.active"
                  @update:checked="toggleActive(fieldGroup)"
                />
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
                      <Link :href="`/cms/field-groups/${fieldGroup.id}/edit`">
                        Edit
                      </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem
                      class="text-destructive"
                      @click="deleteFieldGroup(fieldGroup.id)"
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

      <div v-if="fieldGroups.links.length > 3" class="flex items-center justify-center space-x-2">
        <Link
          v-for="(link, index) in fieldGroups.links"
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
