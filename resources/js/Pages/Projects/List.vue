<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProjectsTable from './Partials/ProjectsTable.vue';
import EditProjectForm from './Partials/EditProjectForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';

const projects = ref([]);
const showEditModal = ref(false);
const showDeleteConfirmation = ref(false);
const isEdit = ref(false);
const selectedProject = ref({});

const openEditProjectModal = () => {
    showEditModal.value = true;
};

const closeEditProjectModal = () => {
    showEditModal.value = false;
    isEdit.value = false;
    selectedProject.value = {};
};

const closeDeleteConfirmation = () => {
    showDeleteConfirmation.value = false;
    selectedProject.value = {};
};

const handleEditProject = (project) => {
    selectedProject.value = project;
    showEditModal.value = true;
    isEdit.value = true;
};

const handleDeleteProject = (project) => {
    selectedProject.value = project;
    showDeleteConfirmation.value = true;
};

const handleSuccessUpdate = (message) => {
    console.info(message);
    getProjects();
    closeEditProjectModal();
}

const deleteProject = (params) => axios.delete(route('projects.destroy', params.id))
    .then(({ data }) => {
        console.info(data.message);
        getProjects();
        closeDeleteConfirmation();
    });

const getProjects = () => axios.get(route('projects.index'))
    .then(({ data }) => {
        projects.value = data.projects;
    });

onMounted(() => {
    getProjects();
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
                        <SecondaryButton @click="openEditProjectModal">
                            New
                        </SecondaryButton>
                    </div>
                    <ProjectsTable
                        :projects="projects"
                        @edit="handleEditProject"
                        @delete="handleDeleteProject"
                    />
                </div>
            </div>
        </div>

        <Modal :show="showEditModal" @close="closeEditProjectModal">
            <div class="p-6">
                <EditProjectForm
                    :project="selectedProject"
                    :isEdit="isEdit"
                    @success="handleSuccessUpdate"
                    @cancel="closeEditProjectModal"
                />
            </div>
        </Modal>

        <Modal :show="showDeleteConfirmation" @close="closeDeleteConfirmation">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this project?
                </h2>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeDeleteConfirmation"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        @click="deleteProject(selectedProject)"
                    >
                        Delete Project
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
