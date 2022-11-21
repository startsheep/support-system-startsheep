<script>
export default {
    props: ['pagination'],
    methods: {
        onPageChange(page){
            this.$emit('onPageChange', page);
        }
    },
}
</script>
<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" style="cursor: pointer;" @click="onPageChange(pagination.currentPage - 1)" :class="{'disabled': pagination.currentPage == 1 }" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link active">{{ pagination.currentPage }}</a>
            </li>

            <li class="page-item">
                <a class="page-link" style="cursor: pointer;" @click="onPageChange(pagination.currentPage + 1)" :class="{'disabled': pagination.currentPage == pagination.lastPage }" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>
