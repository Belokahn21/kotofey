import config from "../../config";
import RestRequest from "../RestRequest";
import BuildQuery from "../BuildQuery";

class Terminal {
    registerOrder(order_id) {
        return RestRequest.post(config.restAcquiring, {
            body: BuildQuery.formDataFromObject({order_id: order_id})
        });
    }
}

export default Terminal;