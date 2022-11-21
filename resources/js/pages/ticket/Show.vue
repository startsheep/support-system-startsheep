<script>
import Loader from '../../components/Loader.vue';

export default {
    props: ['id'],
    data() {
        return {
            ticket: {},
            isLoading: false
        }
    },
    mounted() {
        this.getTicket()
    },
    methods: {
        getTicket() {
            this.isLoading = true;
            this.$store
                .dispatch("showData", ["ticket/" + this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.ticket = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        }
    },
    components: { Loader }
}
</script>
<template>
    <div class="container mt-5 position-relative">
        <Loader v-if="isLoading" />
        <div class="card mb-3">
            <div class="card-header d-flex">
                <img :src="`https://ui-avatars.com/api/?background=random&size=25&rounded=true&length=2&name=${ticket.createdBy}`">
                <div class="card-header-sub ms-3">
                    <span><b>{{ ticket.createdBy }}</b></span>
                    <br>
                    <span>Request on {{ ticket.createdAt }}</span>
                </div>
            </div>
            <div class="card-body">
                <h3>{{ ticket.title }}</h3>
                <p>description :</p>
                <p>
                    {{ ticket.description }}
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad totam eaque, iusto asperiores, officia aspernatur magni odit dolore magnam incidunt non assumenda quibusdam provident, voluptatibus id repellendus eveniet vero tempora?
            </div>
        </div>
    </div>
</template>
