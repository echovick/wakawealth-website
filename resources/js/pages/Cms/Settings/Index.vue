<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import CmsLayout from '@/layouts/cms/CmsLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Switch } from '@/components/ui/switch';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from '@/components/ui/tabs';

interface Setting {
  id: number;
  group: string;
  key: string;
  value: any;
  label: string;
  type: string;
  options: Record<string, any>;
}

interface Props {
  settings: Record<string, Setting[]>;
}

const props = defineProps<Props>();

const settingGroups = computed(() => Object.keys(props.settings));
const activeTab = ref(settingGroups.value[0] || 'general');

const forms = computed(() => {
  const formsByGroup: Record<string, any> = {};

  for (const [group, settings] of Object.entries(props.settings)) {
    const formData: Record<string, any> = {};
    settings.forEach(setting => {
      formData[setting.key] = setting.value;
    });
    formsByGroup[group] = useForm({
      group,
      settings: formData,
    });
  }

  return formsByGroup;
});

const saveSettings = (group: string): void => {
  forms.value[group].put(route('cms.settings.update'));
};

const getInputComponent = (type: string): string => {
  const componentMap: Record<string, string> = {
    text: 'input',
    textarea: 'textarea',
    boolean: 'switch',
    number: 'input',
    email: 'input',
    url: 'input',
  };
  return componentMap[type] || 'input';
};

const getInputType = (type: string): string => {
  const typeMap: Record<string, string> = {
    text: 'text',
    number: 'number',
    email: 'email',
    url: 'url',
  };
  return typeMap[type] || 'text';
};
</script>

<template>
  <Head title="Settings" />

  <CmsLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Settings</h1>
        <p class="text-muted-foreground">
          Manage your website settings and configuration
        </p>
      </div>

      <Tabs v-model="activeTab" class="space-y-6">
        <TabsList>
          <TabsTrigger
            v-for="group in settingGroups"
            :key="group"
            :value="group"
          >
            {{ group.charAt(0).toUpperCase() + group.slice(1) }}
          </TabsTrigger>
        </TabsList>

        <TabsContent
          v-for="group in settingGroups"
          :key="group"
          :value="group"
        >
          <form @submit.prevent="saveSettings(group)" class="space-y-6">
            <div class="rounded-lg border p-6 space-y-6">
              <div
                v-for="setting in settings[group]"
                :key="setting.id"
                class="space-y-2"
              >
                <template v-if="setting.type === 'boolean'">
                  <div class="flex items-center space-x-2">
                    <Switch
                      :id="`setting-${setting.key}`"
                      v-model:checked="forms[group].settings[setting.key]"
                    />
                    <Label :for="`setting-${setting.key}`">
                      {{ setting.label }}
                    </Label>
                  </div>
                </template>

                <template v-else-if="setting.type === 'textarea'">
                  <Label :for="`setting-${setting.key}`">
                    {{ setting.label }}
                  </Label>
                  <Textarea
                    :id="`setting-${setting.key}`"
                    v-model="forms[group].settings[setting.key]"
                    :placeholder="setting.label"
                  />
                </template>

                <template v-else>
                  <Label :for="`setting-${setting.key}`">
                    {{ setting.label }}
                  </Label>
                  <Input
                    :id="`setting-${setting.key}`"
                    v-model="forms[group].settings[setting.key]"
                    :type="getInputType(setting.type)"
                    :placeholder="setting.label"
                  />
                </template>

                <p
                  v-if="forms[group].errors[`settings.${setting.key}`]"
                  class="text-sm text-destructive"
                >
                  {{ forms[group].errors[`settings.${setting.key}`] }}
                </p>
              </div>
            </div>

            <div class="flex justify-end">
              <Button
                type="submit"
                :disabled="forms[group].processing"
              >
                Save {{ group.charAt(0).toUpperCase() + group.slice(1) }} Settings
              </Button>
            </div>
          </form>
        </TabsContent>
      </Tabs>

      <div v-if="settingGroups.length === 0" class="text-center text-muted-foreground py-12">
        No settings found. Settings can be added programmatically or through database seeding.
      </div>
    </div>
  </CmsLayout>
</template>
