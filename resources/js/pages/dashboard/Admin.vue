<script>
export default {
    data() {
        return {
            dashboard: {
                openTickets: 0,
                closedTickets: 0,
                unresolvedTickets: 0,
                resolvedTickets: 0,
                unassignedTickets: 0,
                totalTickets: 0,
            },
        };
    },
    mounted() {
        this.getDashboard();
    },
    methods: {
        getDashboard() {
            this.$store
                .dispatch("showData", ["/dashboard", "admin"])
                .then((response) => {
                    this.dashboard = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
<template>
    <h1 class="h3 mb-3">{{ this.$route.name }}</h1>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Open</h3>
                </div>
                <div class="card-body pt-0">
                    <h1 v-html="dashboard.openTickets"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Closed</h3>
                </div>
                <div class="card-body pt-0">
                    <h1 v-html="dashboard.closedTickets"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Unresolved</h3>
                </div>
                <div class="card-body pt-0">
                    <h1 v-html="dashboard.unresolvedTickets"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resolved</h3>
                </div>
                <div class="card-body pt-0">
                    <h1 v-html="dashboard.resolvedTickets"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Unassigned</h3>
                </div>
                <div class="card-body pt-0">
                    <h1 v-html="dashboard.unassignedTickets"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Total Ticket</h3>
                </div>
                <div class="card-body pt-0">
                    <h1 v-html="dashboard.totalTickets"></h1>
                </div>
            </div>
        </div>
    </div>
</template>
