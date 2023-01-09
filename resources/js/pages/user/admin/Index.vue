<script>
import Loader from "../../../components/Loader.vue";
import Pagination from "../../../components/Pagination.vue";
import Delete from "../../../components/notifications/Detele.vue";
import UserNav from "../UserNav.vue";

export default {
    data() {
        return {
            admins: [],
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
        this.getAdmins();
    },
    methods: {
        getAdmins() {
            this.isLoading = true;

            const params = [
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
                `search=${this.search}`,
            ].join("&");
            this.$store
                .dispatch("getData", ["user/admin", params])
                .then((response) => {
                    this.isLoading = false;
                    this.admins = response.data;
                    this.metaPagination = response.meta;
                })
                .catch((errors) => {
                    this.isLoading = false;
                    console.log(errors);
                });
        },
        deleteAdmin() {
            $("#deleteModal").modal("hide");

            this.isLoading = true;

            this.$store
                .dispatch("deleteData", ["user/admin", this.deleteId])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "data has been deleted";
                    this.getAdmins();
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
                this.getAdmins();
            }, 1000);
        },
        onPageChange(event) {
            this.pagination.page = event;
            this.getAdmins();
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
                                :to="{ name: 'Create Admin' }"
                                class="btn btn-primary mb-3"
                            >
                                Create New Admin
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(admin, index) in admins"
                                    :key="index"
                                >
                                    <td>
                                        <img
                                            :src="
                                                'https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=' +
                                                admin.name
                                            "
                                            class="me-2"
                                        />
                                        {{ admin.name }}
                                    </td>
                                    <td v-html="admin.email"></td>
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'Admin Edit',
                                                params: { id: admin.id },
                                            }"
                                            class="btn btn-sm btn-warning me-2"
                                        >
                                            Edit
                                        </router-link>
                                        <button
                                            class="btn btn-sm btn-danger"
                                            @click="onDelete(admin.id)"
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

    <Delete @onDelete="deleteAdmin" />
</template>
