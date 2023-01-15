<script>
import Loader from "../../../components/Loader.vue";
import Pagination from "../../../components/Pagination.vue";
import Delete from "../../../components/notifications/Detele.vue";
import UserNav from "../UserNav.vue";

export default {
    data() {
        return {
            customers: [],
            metaPagination: {},
            pagination: {
                perPage: 10,
                page: 1,
            },

            search: "",
            isLoading: false,
            deleteId: null,
        };
    },
    mounted() {
        this.getCustomers();
    },
    methods: {
        getCustomers() {
            this.isLoading = true;

            const params = [
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
                `search=${this.search}`,
            ].join("&");

            this.$store
                .dispatch("getData", ["user/customer", params])
                .then((response) => {
                    this.isLoading = false;
                    this.customers = response.data;
                    this.metaPagination = response.meta;
                })
                .catch((errors) => {
                    this.isLoading = false;
                    console.log(errors);
                });
        },
        customerDelete() {
            $("#deleteModal").modal("hide");

            this.isLoading = true;

            this.$store
                .dispatch("deleteData", ["user/customer", this.deleteId])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "data has been deleted";
                    this.getCustomers();
                    $("#successModal").modal("show");
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        iteration(index) {
            return (
                (this.metaPagination.currentPage - 1) *
                    this.metaPagination.perPage +
                index +
                1
            );
        },
        onDelete(e) {
            this.deleteId = e;
            $("#deleteModal").modal("show");
        },
        onSearch(e) {
            setTimeout(() => {
                this.getCustomers();
            }, 1000);
        },
        onPageChange(event) {
            this.pagination.page = event;
            this.getCustomers();
        },
    },
    components: { Loader, Pagination, Delete, UserNav },
};
</script>
<template>
    <h1 class="h3 mb-3">{{ this.$route.name }}</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <Loader v-if="isLoading" />
                <div class="card-header">
                    <UserNav />
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <router-link
                                :to="{ name: 'Create Customer' }"
                                class="btn btn-primary mb-3"
                            >
                                Create New Customer
                            </router-link>
                        </div>
                        <div
                            class="d-flex justify-content-end flex-md-row flex-xs-column align-items-center"
                        >
                            <div class="me-2">
                                <input
                                    type="search"
                                    class="form-control"
                                    style="margin-top: -13px"
                                    @keyup="onSearch"
                                    v-model="search"
                                    placeholder="Search..."
                                />
                            </div>

                            <Pagination
                                :pagination="metaPagination"
                                @onPageChange="onPageChange($event)"
                            />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover border-top">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Project</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(customer, index) in customers"
                                    :key="index"
                                >
                                    <td>
                                        <img
                                            :src="
                                                'https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=' +
                                                customer.name
                                            "
                                            class="me-2"
                                        />
                                        {{ customer.name }}
                                    </td>
                                    <td v-html="customer.email"></td>
                                    <td>
                                        <p
                                            class="p-0 m-0"
                                            v-if="
                                                customer.customerHasProject
                                                    .length > 0
                                            "
                                            v-for="(
                                                project, index
                                            ) in customer.customerHasProject"
                                            :key="index"
                                            v-html="
                                                '- ' +
                                                project.project.projectName
                                            "
                                        ></p>
                                        <p
                                            class="p-0 m-0"
                                            v-else
                                            v-html="'- ' + 'No Project'"
                                        ></p>
                                    </td>
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'Customer Edit',
                                                params: { id: customer.id },
                                            }"
                                            class="btn btn-sm btn-warning me-2"
                                        >
                                            Edit
                                        </router-link>
                                        <button
                                            class="btn btn-sm btn-danger"
                                            @click="onDelete(customer.id)"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Delete @onDelete="customerDelete" />
</template>
