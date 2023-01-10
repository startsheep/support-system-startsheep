import { reject } from "lodash";
import Api from "../services/api";

const process = {
    actions: {
        deleteMultipleData(context, param) {
            return new Promise((resolve, reject) => {
                Api.init();
                Api.deleteWithParams(param[0], param[1]).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error.response);
                    }
                );
            });
        },
    },
};

export default process;
