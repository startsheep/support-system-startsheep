<script>
import Loader from "../../../components/Loader.vue";

export default {
    data() {
        return {
            isLoading: false,
            user: {},
        };
    },
    mounted() {
        this.getUser();
    },
    methods: {
        getUser() {
            this.isLoading = true;
            this.$store
                .dispatch("postData", ["/auth/check", {}])
                .then((response) => {
                    this.isLoading = false;
                    this.user = response.user;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
    },
    components: { Loader },
};
</script>

<template>
    <div class="card">
        <Loader v-if="isLoading" />
        <div class="card-header d-flex">
            <img
                :src="`https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=${user.name}`"
            />
            <div class="card-header-sub ms-3">
                <span><b v-html="user.name"></b></span><br />
                <span v-if="user.roles">{{ user.roles[0].name }}</span>
            </div>
        </div>
        <div class="card-body">
            <p class="mb-4">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Voluptates nisi cupiditate quia, perferendis tempora quas, qui
                quasi blanditiis excepturi cumque aliquid eligendi debitis
                doloremque? Pariatur voluptas molestiae dolores eos voluptatem!
            </p>
            <span><b>Attachments</b> :</span>
        </div>
    </div>

    <div class="card">
        <Loader v-if="isLoading" />
        <div class="card-header d-flex">
            <img
                :src="`https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=${user.name}`"
            />
            <div class="card-header-sub ms-3 mt-1">
                <span><b v-html="user.name"></b></span>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label>Write your message</label>
                <textarea
                    class="form-control"
                    rows="5"
                    placeholder="Write your message here..."
                ></textarea>
            </div>
            <div class="mb-3">
                <label for="documents">Upload photos / videos</label>
                <div
                    class="text-center"
                    id="customFileInput"
                    style="cursor: pointer"
                >
                    <p>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-upload align-middle me-2"
                        >
                            <path
                                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                            ></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                    </p>
                    <p>upload documents in here...</p>
                    <input type="file" multiple="" id="fileInput" hidden="" />
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button class="btn btn-success">Submit</button>
        </div>
    </div>
</template>
