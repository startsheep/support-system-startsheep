import { createStore } from "vuex";
import action from "./services/action";
import ticket from "./modules/ticket";

const store = createStore({
    modules: {
        action,
        ticket,
    },
});

export default store;
