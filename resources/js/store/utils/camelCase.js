import camelcaseKeys from "camelcase-keys";

export default {
    toCamelCase(data) {
        return camelcaseKeys(data, { deep: true });
    },
};
