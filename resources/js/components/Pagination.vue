<script>
export default {
    props: ["pagination"],
    methods: {
        onPageChange(page) {
            this.$emit("onPageChange", page);
        },
    },
};
</script>
<template>
    <nav class="d-flex align-items-center justify-content-end">
        <p class="me-2">{{ pagination.from }} - {{ pagination.to }}</p>
        <p class="me-2">of</p>
        <p class="me-2">{{ pagination.total }}</p>
        <p :class="pagination.currentPage == 1 ? 'pointer-block' : ''">
            <button
                class="btn no-border show-block"
                :disabled="pagination.currentPage == 1"
                @click="onPageChange(pagination.currentPage - 1)"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-arrow-left-circle"
                >
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 8 8 12 12 16"></polyline>
                    <line x1="16" y1="12" x2="8" y2="12"></line>
                </svg>
            </button>
        </p>
        <p
            :class="
                pagination.currentPage == pagination.lastPage
                    ? 'pointer-block'
                    : ''
            "
        >
            <button
                class="btn show-block no-border"
                :disabled="pagination.currentPage == pagination.lastPage"
                @click="onPageChange(pagination.currentPage + 1)"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-arrow-right-circle"
                >
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 16 16 12 12 8"></polyline>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
            </button>
        </p>
    </nav>
</template>
<style>
.pointer-block {
    cursor: no-drop;
}

.no-border {
    border: none;
}

.show-block:hover {
    background-color: rgba(0, 0, 0, 0.035);
}
</style>
