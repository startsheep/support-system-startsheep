<script>
import Loader from "../../components/Loader.vue";
import Properties from "./components/Properties.vue";
import moment from "moment";
import General from "./components/General.vue";
import Comment from "./components/Comment.vue";
import PusherUtil from "../../store/utils/pusher";

export default {
    props: ["id"],
    data() {
        return {
            ticket: {},

            isLoading: false,
        };
    },
    mounted() {
        this.getTicket();

        PusherUtil.getMessage("tickets", "TicketMessage", (response) => {
            this.getTicket();
        });
    },
    methods: {
        getTicket() {
            this.isLoading = true;
            this.$store
                .dispatch("showData", ["ticket", this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.ticket = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        onUpdate() {
            this.getTicket();
        },
        dateTime(value, format) {
            return moment(value).format(format ?? "YYYY-MM-DD HH:mm");
        },
        onBack() {
            return this.$router.go(-1);
        },
    },
    components: { Loader, Properties, General, Comment },
};
</script>

<template>
    <div class="d-flex">
        <router-link class="text-dark mb-3 me-2" to="" @click="onBack()"
            ><span class="material-symbols-outlined">
                chevron_left
            </span></router-link
        >
        <h1 class="h3 mb-3">
            {{ this.$route.name + " " + ticket.ticketCode }}
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <Loader v-if="isLoading" />
                <div class="card-header d-flex">
                    <img
                        v-if="ticket.createdBy"
                        :src="`https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=${ticket.createdBy.name}`"
                    />
                    <div class="card-header-sub ms-3">
                        <span
                            ><b
                                v-if="ticket.createdBy"
                                v-html="ticket.createdBy.name"
                            ></b
                        ></span>
                        <br />
                        <span
                            >Request on
                            {{
                                dateTime(
                                    ticket.createdAt,
                                    "HH:mm, DD MMMM YYYY"
                                )
                            }}</span
                        >
                    </div>
                </div>
                <div class="card-body">
                    <h3>
                        {{ ticket.ticketTitle }}
                    </h3>
                    <br />
                    <p>Description :</p>
                    <p>
                        {{ ticket.description }}
                    </p>
                    <div v-if="ticket.files && ticket.files.length > 0">
                        <span><b>Attachments</b> :</span>
                        <div class="row mt-2">
                            <div
                                v-for="(file, index) in ticket.files"
                                :key="index"
                                class="col-lg-3 col-md-4 col-sm-6 col-12"
                            >
                                <a :href="file.filePath" target="_blank">
                                    <img
                                        :src="file.filePath"
                                        class="img-fluid mb-3"
                                    />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Comment />
        </div>
        <div class="col-lg-4">
            <General
                :ticket="ticket"
                :isLoading="isLoading"
                v-if="$can('general', 'Ticket')"
            />
            <Properties
                :ticket="ticket"
                @updateTicket="onUpdate"
                v-if="$can('properties', 'Ticket')"
            />
        </div>
    </div>
</template>
