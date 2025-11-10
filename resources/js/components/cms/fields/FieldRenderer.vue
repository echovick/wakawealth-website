<script setup lang="ts">
import { computed } from 'vue';
import TextField from './TextField.vue';
import TextareaField from './TextareaField.vue';
import NumberField from './NumberField.vue';
import EmailField from './EmailField.vue';
import UrlField from './UrlField.vue';
import SelectField from './SelectField.vue';
import CheckboxField from './CheckboxField.vue';
import RadioField from './RadioField.vue';
import TrueFalseField from './TrueFalseField.vue';
import DatePickerField from './DatePickerField.vue';
import TimePickerField from './TimePickerField.vue';
import RepeaterField from './RepeaterField.vue';
import GroupField from './GroupField.vue';
import PostsField from './PostsField.vue';

interface Field {
    name: string;
    label: string;
    type: string;
    required: boolean;
    instructions: string | null;
    field_config: Record<string, any>;
}

interface Props {
    field: Field;
    modelValue?: any;
    posts?: any[];
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const fieldComponent = computed(() => {
    const componentMap: Record<string, any> = {
        text: TextField,
        textarea: TextareaField,
        number: NumberField,
        email: EmailField,
        url: UrlField,
        select: SelectField,
        checkbox: CheckboxField,
        radio: RadioField,
        true_false: TrueFalseField,
        date_picker: DatePickerField,
        time_picker: TimePickerField,
        repeater: RepeaterField,
        group: GroupField,
        posts: PostsField,
    };

    return componentMap[props.field.type] || TextField;
});

const updateValue = (value: any) => {
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="space-y-2">
        <component
            :is="fieldComponent"
            :field="field"
            :model-value="modelValue"
            :posts="posts"
            @update:model-value="updateValue"
        />
        <p v-if="field.instructions" class="text-sm text-muted-foreground">
            {{ field.instructions }}
        </p>
    </div>
</template>
