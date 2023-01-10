import { defineAbility } from "@casl/ability";
import Cookies from "js-cookie";

export default defineAbility((can) => {
    if (Cookies.get("user") !== undefined) {
        can("manage", "all");
        var permission = "";
        for (var prop in permission) {
            if (permission.hasOwnProperty(prop)) {
                can(
                    permission[prop],
                    prop.charAt(0).toUpperCase() + prop.slice(1)
                );
            }
        }
    }
});
