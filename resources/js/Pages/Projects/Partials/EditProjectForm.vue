<script setup>
import { ref, watch } from 'vue';
import { DateTime } from 'luxon';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    project: {
        type: Object,
        default: () => ({}),
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['success']);

const inactiveProject = ref(props.project.status === 'inactive');

const form = useForm({
    ...props.project,
    name: props.project.name || null,
    start_date: DateTime.fromSQL(props.project.start_date).toFormat('yyyy-MM-dd'),
    end_date: DateTime.fromSQL(props.project.end_date).toFormat('yyyy-MM-dd'),
    status: props.project.status || 'active',
    value: props.project.value || null,
});

watch(inactiveProject, (newValue) => {
    form.status = newValue ? 'inactive' : 'active';
});

const putProject = (params) => axios.put(route('projects.update', params.id), params)
    .then(({ data }) => {
        emit('success', data.message);
    });
const postProject = (params) => axios.post(route('projects.store'), params)
    .then(({ data }) => {
        emit('success', data.message);
    });

const submitForm = () => {
    return props.isEdit ? putProject(form) : postProject(form);
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Project</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update project information.
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="start_date" value="Start date" />

                <TextInput
                    id="start_date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.start_date"
                    required
                    autofocus
                    autocomplete="start_date"
                />

                <InputError class="mt-2" :message="form.errors.start_date" />
            </div>

            <div>
                <InputLabel for="end_date" value="End date" />

                <TextInput
                    id="end_date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.end_date"
                    required
                    autofocus
                    autocomplete="end_date"
                />

                <InputError class="mt-2" :message="form.errors.start_date" />
            </div>

            <div>
                <InputLabel for="value" value="Value" />

                <TextInput
                    id="value"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.value"
                    required
                    autofocus
                    autocomplete="value"
                />

                <InputError class="mt-2" :message="form.errors.value" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="inactiveProject" />
                    <span class="ml-2 text-sm text-gray-600">Is this project inactive?</span>
                </label>
            </div>

            <div class="flex items-center gap-4 justify-end">
                <SecondaryButton :disabled="form.processing" @click="$emit('cancel', true)">Cancel</SecondaryButton>
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </section>
</template>
