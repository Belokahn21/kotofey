import React, {Component} from "react";

class CheckoutUserBonusAuth extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <div className="bonus-no-authorize">
                    <div>Чтобы воспользоваться бонусами авторизуйтесь на сайте</div>
                    <button type="button" className="checkout-button-auth" data-toggle="modal" data-target="#signinModal">Войти на сайт</button>
                </div>
            </div>
        );

    }
}

export default CheckoutUserBonusAuth;