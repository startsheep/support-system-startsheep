<template>
    <span
        class="error"
        v-if="errors"
        v-for="(error, index) in errors"
        :key="index"
        >{{ error }}</span
    >
</template>

<script>
export default {
    props: ["errors"],
};
</script>
