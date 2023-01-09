<script>
import Loader from "../../../components/Loader.vue";

export default {
    props: ["ticket", "isLoading"],
    data() {
        return {};
    },
    methods: {},
    components: { Loader },
};
</script>

<template>
    <div class="card">
        <Loader v-if="isLoading" />
        <div class="card-body">
            <h5 class="card-title mb-3">General</h5>
            <div class="mb-2">
                <label><b>Status</b></label> <br />
                <div v-if="ticket.ticketStatus">
                    <button
                        class="btn rounded-pill"
                        disabled
                        :class="ticket.ticketStatus.color"
                        v-html="ticket.ticketStatus.status"
                    ></button>
                </div>
            </div>
            <div class="mb-2">
                <label><b>Project</b></label>
                <p
                    v-if="ticket.project"
                    v-html="ticket.project.projectName"
                ></p>
            </div>
            <div class="mb-2">
                <label><b>Priority</b></label>
                <p v-html="ticket.ticketPriority"></p>
            </div>
        </div>
    </div>
</template>
