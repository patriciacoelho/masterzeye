<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { DateTime } from 'luxon';

const props = defineProps({
    projects: {
        type: Array,
        required: true
    },
});

const formatDate = (date) => {
    if (!date) {
        return '';
    }

    return DateTime.fromSQL(date).toFormat('dd/MM/yyyy');
};
</script>

<template>
    <table class="shadow-lg bg-white table-auto w-full">
        <thead>
            <tr>
                <th class="bg-blue-100 border text-left px-8 py-4">Name</th>
                <th class="bg-blue-100 border text-left px-8 py-4">Activity</th>
                <th class="bg-blue-100 border text-left px-8 py-4">Status</th>
                <th class="bg-blue-100 border text-left px-8 py-4">Creator</th>
                <th class="bg-blue-100 border text-left px-8 py-4"></th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="project in projects"
                :key="project.id"
            >
                <td class="border px-8 py-4">
                    {{ project.name }}
                </td>
                <td class="border px-8 py-4">
                    Started: {{ formatDate(project.start_date) }}
                    <span v-if="project.end_date">
                        <br>
                        Ended: {{ formatDate(project.end_date) }} 
                    </span>
                </td>
                <td class="border px-8 py-4">
                    <span
                        v-if="project.status === 'active'"
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                    >
                        {{ project.status }}
                    </span>
                    <span
                        v-else
                        class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10"
                    >

                        {{ project.status }}
                    </span>
                </td>
                <td class="border px-8 py-4">
                    {{ project.creator_name }}
                </td>
                <td>
                    <PrimaryButton class="ml-4" @click="$emit('edit', project)">
                        Edit
                    </PrimaryButton>
                    <DangerButton class="ml-4" @click="$emit('delete', project)">
                        Delete
                    </DangerButton>
                </td>
            </tr>
        </tbody>
    </table>
</template>