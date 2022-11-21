<script>
import Table from "../../components/Table.vue";
import Loader from "../../components/Loader.vue";

export default {
    data() {
        return {
            tickets: [],
            isLoading: false,
            search: '',
            pagination: {
                perPage: 10,
                page: 1
            },
            metaPagination: {},
            headings: [
                "Ticket Code", "Title", "Request By", "Action"
            ],
            variables: [
                "code", "title", "createdBy",
            ]
        };
    },
    mounted() {
        this.getTicket();
    },
    methods: {
        getTicket() {
            this.isLoading = true;

            const params = [
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
                `search=${this.search}`,
            ].join("&");

            this.$store
                .dispatch("getData", ["ticket", params])
                .then((response) => {
                    this.isLoading = false;
                    this.tickets = response.data;
                    this.metaPagination = response.meta;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        onSort(e) {
            this.pagination.perPage = e;
            this.getTicket()
        },
        onSearch(e) {
            this.search = e;
            this.getTicket()
        },
        onPageChange(e){
            this.pagination.page = e;
            this.getTicket()
        }
    },
    components: { Loader, Table },
};
</script>
<template>
    <div class="container mt-5 position-relative">
        <Loader v-if="isLoading" />
        <Table
            :isShow="true"
            :isPaginate="true"
            :isSort="true"
            :isSearch="true"
            :numeric="false"
            :headings="headings"
            :data="tickets"
            :variables="variables"
            :metaPagination="metaPagination"
            @onSort="onSort($event)"
            @onSearch="onSearch($event)"
            @onPageChange="onPageChange($event)"
        />
    </div>
</template>
