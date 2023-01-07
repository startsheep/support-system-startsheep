<template>
    <div
        class="modal fade"
        id="successModal"
        tabindex="-1"
        aria-labelledby="successModalLabel"
        aria-hidden="true"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="successModalLabel">
                        success
                    </h1>
                </div>
                <div class="modal-body">{{ msg }}.</div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-dismiss="modal"
                        v-if="!route"
                    >
                        OK
                    </button>
                    <button
                        @click="handleOk"
                        type="button"
                        class="btn btn-primary"
                        v-else
                    >
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["msg", "route"],
    methods: {
        handleOk() {
            $("#successModal").modal("hide");
            this.$router.push(this.route);
        },
    },
};
</script>
