<template>
    <nav class="isolate flex justify-center -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        <a
            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
            href="javascript:void(0)"
            :disabled="disablePrevious"
            @click="changePage(currentPage - 1)"
        >
            <span class="sr-only">Previous</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
            </svg>
        </a>

        <a
            v-for="(page, index) in pages"
            :key="index"
            href="javascript:void(0)"
            :class="itemClass(page)"
            @click="changePage(page)"
        >
            {{ page }}
        </a>
        <a
            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
            href="javascript:void(0)"
            :disabled="disableNext"
            @click="changePage(currentPage + 1)"
        >
            <span class="sr-only">Next</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
            </svg>
        </a>
    </nav>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            default: 1,
        },
        pages: {
            type: Number,
            required: true,
        },
    },
    computed: {
        disablePrevious() {
            return this.currentPage > 1;
        },
        disableNext() {
            return this.currentPage < this.pages;
        },
    },
    methods: {
        changePage(page) {
            if (page < 1 || page > this.pages) {
                return;
            }
            this.$emit('change-page', page);
        },
        itemClass(page) {
            return page === this.currentPage
                ? 'relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0';
        },
    },
};
</script>