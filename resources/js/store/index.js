import { createStore } from "vuex";
import action from "./services/action";

const store = createStore({
    modules: {
        action,
    },
});

export default store;
