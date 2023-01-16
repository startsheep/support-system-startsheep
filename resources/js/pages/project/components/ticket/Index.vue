<script>
import Loader from "../../../../components/Loader.vue";
import Pagination from "../../../../components/Pagination.vue";
import PusherUtil from "../../../../store/utils/pusher";
import CamelCase from "../../../../store/utils/camelCase";
import Cookies from "js-cookie";

export default {
    props: ["id"],
    data() {
        return {
            isLoading: false,
            search: "",

            user: {},
            tickets: [],
            metaPagination: [],
            pagination: {
                perPage: 4,
                page: 1,
            },
        };
    },
    mounted() {
        this.getTickets();
        this.getUser();

        PusherUtil.getMessage("tickets", "CreateTicketMessage", (response) => {
            this.tickets.unshift(CamelCase.toCamelCase(response.message));
        });

        PusherUtil.getMessage("tickets", "TicketMessage", (response) => {
            if (response.message.message == "deleted") {
                const index = this.tickets.findIndex(
                    (ticket) => ticket.id == response.message.id
                );
                this.tickets.splice(index, 1);
            } else {
                const index = this.tickets.findIndex(
                    (ticket) => ticket.id == response.message.id
                );
                this.tickets.splice(
                    index,
                    1,
                    CamelCase.toCamelCase(response.message)
                );
            }
        });
    },
    methods: {
        getUser() {
            this.user = JSON.parse(Cookies.get("user"));
            return this.$store.getters.getUser;
        },
        getTickets() {
            this.isLoading = true;
            const params = [
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
                `project=${this.id}`,
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
        onPageChange(page) {
            this.pagination.page = page;
            this.getTickets();
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
    <div class="card">
        <Loader v-if="isLoading" />
        <div
            class="card-header d-flex justify-content-between align-items-center"
        >
            <h5 class="card-title mb-0">Ticket Project</h5>
            <div>
                <router-link
                    :to="{ name: 'Kanban Board', params: { id: id } }"
                    class="btn btn-primary"
                    >Kanban Board</router-link
                >
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="mb-2">
                    <router-link
                        :to="'/'"
                        class="btn btn-primary me-2"
                        v-if="user.roles && user.roles[0].name != 'Admin'"
                        >Create New Ticket</router-link
                    >
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
                            <th>Subject</th>
                            <th>Priority</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(ticket, index) in tickets" :key="index">
                            <td>
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
                            <td v-html="ticket.ticketTitle"></td>
                            <td
                                v-html="
                                    alertTicketPriority(ticket.ticketPriority)
                                "
                            ></td>
                            <td class="text-center" v-if="ticket.ticketStatus">
                                <button
                                    class="btn rounded-pill"
                                    disabled
                                    :class="ticket.ticketStatus.color"
                                    v-html="ticket.ticketStatus.status"
                                ></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
