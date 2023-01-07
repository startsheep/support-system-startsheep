<script>
export default {
    methods: {
        onDelete() {
            this.$emit("onDelete", 1);
        },
    },
};
</script>

<template>
    <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
        aria-labelledby="deleteModalLabel"
        aria-hidden="true"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">
                        Deleting Data
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
                        Are you sure you want to <strong>delete</strong> this
                        data? This action cannot be undone.
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
                            class="btn btn-danger"
                            @click="onDelete"
                        >
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
