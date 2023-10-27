<script setup>
import { ref, onMounted } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProjectsTable from './Partials/ProjectsTable.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head } from '@inertiajs/vue3';

const projects = ref([]);

onMounted(() => {
    axios.get(route('projects.index'))
        .then(({ data }) => {
            projects.value = data.projects;
        });
});
</script>

<template>
    <Head title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="my-4 text-right">
                        <SecondaryButton>
                            New
                        </SecondaryButton>
                    </div>
                    <ProjectsTable
                        :projects="projects"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
