<script>
import Loader from "@/components/Loader.vue";

export default {
    props: ["id"],
    data() {
        return {
            ticketStatus: [],
            cards: [],

            clientX: 0,
            clientY: 0,
            isLoading: false,
            ticketId: "",
        };
    },
    mounted() {
        this.getTicketStatus();
    },
    methods: {
        getTicketStatus() {
            const params = [`without=closed`].join("&");
            this.$store
                .dispatch("getData", ["ticket-status", params])
                .then((response) => {
                    this.isLoading = false;
                    this.ticketStatus = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
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
        startDrag(evt, ticket) {
            evt.dataTransfer.dropEffect = "move";
            evt.dataTransfer.effectAllowed = "move";
            evt.dataTransfer.setData("ticketId", ticket.id);
        },
        onDrop(evt, statusId) {
            const ticketId = evt.dataTransfer.getData("ticketId");
            this.ticketId = ticketId;
            this.isLoading = true;

            this.$store
                .dispatch("updateData", [
                    "ticket/update-status",
                    ticketId,
                    { ticketStatus: statusId },
                ])
                .then((response) => {
                    this.getTicketStatus();
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
    },
    components: {
        Loader,
    },
};
</script>
<template>
    <div class="d-flex">
        <router-link
            class="text-dark mb-3 me-2"
            :to="{ name: 'Project Detail', params: { id: id } }"
            ><span class="material-symbols-outlined">
                chevron_left
            </span></router-link
        >
        <h1 class="h3 mb-3">{{ this.$route.name }}</h1>
    </div>

    <div class="board">
        <div
            class="tasks"
            v-for="(status, index) in ticketStatus"
            :key="index"
            @drop="onDrop($event, status.id)"
            @dragover.prevent
            @dragenter.prevent
        >
            <h5 class="mt-0 task-header text-uppercase">
                {{ status.status }}
            </h5>
            <div class="task-list-items">
                <router-link
                    :to="{
                        name: 'Ticket Detail',
                        params: { id: ticket.id },
                    }"
                    style="text-decoration: none"
                    id="cardForMove"
                    v-for="(ticket, index) in status.tickets"
                    :key="index"
                    draggable
                    @drag="onDrag"
                    @dragstart="startDrag($event, ticket)"
                >
                    <div class="card mb-0" v-if="ticket.projectId == id">
                        <Loader v-if="isLoading && ticket.id == ticketId" />
                        <div class="card-body p-3">
                            <span
                                v-html="
                                    alertTicketPriority(ticket.ticketPriority)
                                "
                            ></span>
                            <h5
                                class="mt-3 mb-3"
                                v-html="ticket.ticketTitle"
                            ></h5>
                            <img
                                v-if="ticket.staff"
                                :src="`https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=${ticket.staff.name}`"
                                class="float-end"
                            />
                            <span
                                class="text-muted"
                                v-html="ticket.ticketCode"
                            ></span>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<style>
@keyframes move {
    from {
        transform: translate(0, 0);
    }
    to {
        transform: translate(10px, 10px);
    }
}

.dragging {
    animation: move 0.2s linear;
    z-index: 100;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}
</style>
