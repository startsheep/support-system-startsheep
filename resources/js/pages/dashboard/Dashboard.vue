<script>
import Customer from "./Customer.vue";

export default {
    data() {
        return {
            isCustomer: false,
            isDefault: false,
        };
    },
    mounted() {
        this.getUser();
    },
    methods: {
        getUser() {
            this.$store
                .dispatch("postData", ["/auth/check", {}])
                .then((response) => {
                    if (response.role[0] == "Customer") {
                        this.isCustomer = true;
                    } else {
                        this.isDefault = true;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    components: { Customer },
};
</script>

<template>
    <div v-if="isCustomer">
        <Customer />
    </div>
    <div v-if="isDefault">Hallo</div>
</template>
