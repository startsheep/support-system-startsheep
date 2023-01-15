<script>
import Loader from "../../components/Loader.vue";
import Pagination from "../../components/Pagination.vue";
import Delete from "../../components/notifications/Detele.vue";
import Resolve from "../../components/notifications/Resolve.vue";
import Multiselect from "vue-multiselect";
import PusherUtil from "../../store/utils/pusher";
import CamelCase from "../../store/utils/camelCase";

export default {
    data() {
        return {
            search: "",
            isLoading: false,
            isLoadingStaff: false,
            assignTo: null,

            staffs: [],
            ticketSelected: [],
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
        this.getStaffs();

        PusherUtil.getMessage("tickets", "CreateTicketMessage", (response) => {
            this.tickets.unshift(CamelCase.toCamelCase(response.message));
        });

        PusherUtil.getMessage("tickets", "TicketMessage", (response) => {
            if (response.message.message == "deleted") {
                const index = this.tickets.findIndex(
                    (ticket) => ticket.id == response.id
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
        getStaffs(search = "") {
            this.isLoadingStaff = true;
            const params = [`search=${search}`].join("&");
            this.$store
                .dispatch("getData", ["user/staff", params])
                .then((response) => {
                    this.isLoadingStaff = false;
                    this.staffs = response.data;
                })
                .catch((error) => {
                    this.isLoadingStaff = false;
                    console.log(error);
                });
        },
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
        resolveTickets() {
            $("#resolveModal").modal("hide");
            let resolvedData = [];

            this.ticketSelected.forEach((ticket, index) => {
                resolvedData[index] = ticket;
            });

            const data = {
                resolved_data: resolvedData,
            };

            this.$store
                .dispatch("putData", ["ticket/resolve", data])
                .then((response) => {
                    this.getTickets();
                    this.ticketSelected = [];
                    this.$toast.success("data has been resolved");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deleteTickets() {
            $("#deleteModal").modal("hide");
            let deletedData = [];

            this.ticketSelected.forEach((ticket, index) => {
                deletedData[index] = ticket;
            });

            const data = {
                deleted_data: deletedData,
            };

            this.$store
                .dispatch("deleteMultipleData", [
                    "ticket/multiple-delete",
                    data,
                ])
                .then((response) => {
                    this.getTickets();
                    this.ticketSelected = [];
                    this.$toast.success("data has been deleted");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        assignTickets() {
            $("#assignTo").modal("hide");
            let assignedData = [];

            this.ticketSelected.forEach((ticket, index) => {
                assignedData[index] = ticket;
            });

            const data = {
                assigned_data: assignedData,
                staff_id: this.assignTo.id,
            };

            this.$store
                .dispatch("putData", ["ticket/assign", data])
                .then((response) => {
                    this.getTickets();
                    this.ticketSelected = [];
                    this.assignTo = null;
                    this.$toast.success("data has been assigned");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onSearch() {
            setTimeout(() => {
                this.getTickets();
            }, 1000);
        },
        onDelete() {
            $("#deleteModal").modal("show");
        },
        onResolve() {
            $("#resolveModal").modal("show");
        },
        onAssign() {
            $("#assignTo").modal("show");
        },
        onPageChange(page) {
            this.pagination.page = page;
            this.getTickets();
        },
        customLabel(option) {
            return `${option.name}`;
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
    components: { Pagination, Loader, Delete, Resolve, Multiselect },
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
                                v-if="$can('create', 'Ticket')"
                            >
                                Create New Ticket
                            </router-link>
                            <span v-show="ticketSelected.length > 0">
                                <button
                                    class="btn btn-primary me-3"
                                    v-if="$can('assignTo', 'Ticket')"
                                    @click="onAssign"
                                >
                                    Assign To
                                </button>
                                <button
                                    class="btn btn-primary me-3"
                                    @click="onResolve"
                                >
                                    Resolve
                                </button>
                                <button
                                    class="btn btn-primary me-3"
                                    v-if="$can('delete', 'Ticket')"
                                    @click="onDelete"
                                >
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
                                            v-model="ticketSelected"
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
                                    >
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
        </div>
    </div>

    <Delete @onDelete="deleteTickets" />
    <Resolve @onConfirm="resolveTickets" />
    <div
        class="modal fade"
        id="assignTo"
        tabindex="-1"
        aria-labelledby="assignToLabel"
        aria-hidden="true"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="assignToLabel">
                        Assign to staff
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label for="search">Search:</label>
                        <Multiselect
                            :searchable="true"
                            :internal-search="false"
                            @search-change="getStaffs"
                            v-model="assignTo"
                            :options="staffs"
                            :custom-label="customLabel"
                            placeholder="select staff"
                            track-by="id"
                            :loading="isLoadingStaff"
                        >
                        </Multiselect>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            class="btn btn-success"
                            @click="assignTickets"
                        >
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
