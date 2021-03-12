import config from "../../config";

class Terminal {

    registerOrder(order_id) {
        fetch(config.restAddAcquiring + '/' + order_id + '/', {
            method: 'POST',
        }).then(response => response.json()).then(data => {
            console.log(data);
        });
    }
}

export default Terminal;