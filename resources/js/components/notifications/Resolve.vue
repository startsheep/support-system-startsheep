<script>
export default {
    methods: {
        onConfirm() {
            this.$emit("onConfirm", 1);
        },
    },
};
</script>

<template>
    <div
        class="modal fade"
        id="resolveModal"
        tabindex="-1"
        aria-labelledby="resolveModalLabel"
        aria-hidden="true"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="resolveModalLabel">
                        Resolve Ticket
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
                        Are you sure want to resolve this ticket?
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
                            @click="onConfirm"
                        >
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
