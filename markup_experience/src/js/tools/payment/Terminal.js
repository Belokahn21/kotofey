class Terminal {

    constructor(login, password) {
        this.login = login;
        this.password = password;

        this.url = {
            registerDo: 'https://3dsec.sberbank.ru/payment/rest/register.do',

        }
    }

    registerOrder(order_id, options) {

        let fetchOptions = {
            userName: this.login,
            password: this.password,
            orderNumber: order_id,
            ...options
        };

        console.log(JSON.stringify(fetchOptions));

        fetch(this.url.registerDo, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(fetchOptions)
        }).then(response => response.json()).then(data => {
            console.log(data);
        });
    }
}

export default Terminal;