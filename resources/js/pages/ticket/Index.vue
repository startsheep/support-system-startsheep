<script>
import Loader from "../../components/Loader.vue";
import Pagination from "../../components/Pagination.vue";

export default {
    data() {
        return {
            search: "",
            isLoading: false,

            selectedCheckbox: [],
            tickets: [],
            metaPagination: [],
            pagination: {
                perPage: 10,
                page: 1,
            },
        };
    },
    mounted() {
        this.getTickets();
    },
    methods: {
        getTickets() {
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
        onSearch() {
            setTimeout(() => {
                this.getTickets();
            }, 1000);
        },
        alertTicketStatus(ticket) {
            if (ticket.status == "Open") {
                return `<button class="btn rounded-pill btn-outline-primary" disabled>${ticket.status}</button>`;
            } else if (ticket.status == "On Hold") {
                return `<button class="btn rounded-pill btn-outline-secondary" disabled>${ticket.status}</button>`;
            } else if (ticket.status == "On Progress") {
                return `<button class="btn rounded-pill btn-outline-warning" disabled>${ticket.status}</button>`;
            } else if (ticket.status == "Closed") {
                return `<button class="btn rounded-pill btn-outline-danger" disabled>${ticket.status}</button>`;
            } else if (ticket.status == "Done") {
                return `<button class="btn rounded-pill btn-outline-success" disabled>${ticket.status}</button>`;
            }
        },
        alertTicketPriority(priority) {
            if (priority == "Minor") {
                return `<div class="badge rounded bg-secondary">${priority}</div>`;
            } else if (priority == "Major") {
                return `<div class="badge rounded bg-success">${priority}</div>`;
            } else if (priority == "Urgent") {
                return `<div class="badge rounded bg-warning">${priority}</div>`;
            } else if (priority == "Emergency") {
                return `<div class="badge rounded bg-danger">${priority}</div>`;
            }
        },
    },
    components: { Pagination, Loader },
};
</script>

<template>
    <h1 class="h3 mb-3">{{ this.$route.name }}</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <Loader v-if="isLoading" />
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3">
                            <router-link
                                :to="{ name: 'Create Ticket' }"
                                class="btn btn-primary me-3"
                            >
                                Create New Ticket
                            </router-link>
                            <span v-show="selectedCheckbox.length > 0">
                                <button class="btn btn-primary me-3">
                                    Assign To
                                </button>
                                <button class="btn btn-primary me-3">
                                    Resolve
                                </button>
                                <button class="btn btn-primary me-3">
                                    Delete
                                </button>
                            </span>
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
                                    <th>Code</th>
                                    <th>Project</th>
                                    <th>Subject</th>
                                    <th>Assigned To</th>
                                    <th>Priority</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(ticket, index) in tickets"
                                    :key="index"
                                >
                                    <td>
                                        <input
                                            type="checkbox"
                                            class="me-2"
                                            v-model="selectedCheckbox"
                                            :value="ticket.id"
                                            style="cursor: pointer"
                                        />
                                        <router-link
                                            :to="{
                                                name: 'Ticket Detail',
                                                params: { id: ticket.id },
                                            }"
                                            class="text-dark"
                                        >
                                            {{ ticket.ticketCode }}
                                        </router-link>
                                    </td>
                                    <td
                                        v-html="
                                            ticket.project
                                                ? ticket.project.projectName
                                                : '-'
                                        "
                                    ></td>
                                    <td v-html="ticket.ticketTitle"></td>
                                    <td
                                        v-html="
                                            ticket.staff
                                                ? ticket.staff.name
                                                : 'Unassign'
                                        "
                                    ></td>
                                    <td
                                        v-html="
                                            alertTicketPriority(
                                                ticket.ticketPriority
                                            )
                                        "
                                    ></td>
                                    <td
                                        class="text-center"
                                        v-if="ticket.ticketStatus"
                                        v-html="
                                            alertTicketStatus(
                                                ticket.ticketStatus
                                            )
                                        "
                                    ></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
