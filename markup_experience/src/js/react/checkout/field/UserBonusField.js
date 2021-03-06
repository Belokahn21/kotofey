import React, {Component} from "react";
import config from "../../../config";
import $ from "jquery";

class UserBonusField extends Component {
    constructor(props, context) {
        super(props, context);

        this.accountId = this.props.accountId;

        this.state = {
            bonus: 0
        };

        this.loadBonus();
    }

    loadBonus() {
        fetch(config.restBonusGet + this.accountId + '/').then(response => response.json()).then(data => {
            if (data.status === 200) {
                this.setState({
                    bonus: data.count
                });
            }
        });
    }

    componentDidMount() {
        var slider = require('ion-rangeslider');

        let bonusInput = document.querySelector('#order-bonus');
        let object = $(".js-select-user-bonus");
        if (object && bonusInput) {
            object.ionRangeSlider({
                min: object.data('min'),
                max: object.data('max'),
                from: object.data('from'),
                onStart: function (data) {
                    bonusInput.value = data.from;
                },
                onChange: function (data) {
                    bonusInput.value = data.from;
                },
            });
        }
    }


    render() {
        let {bonus} = this.state
        return (
            <label className="checkout-form__label" htmlFor="checkout-phone">
                <div className="form-group field-order-bonus has-success">

                    <div className="checkout-form-label-group">
                        <div>Бонусы</div>
                        <div>Доступно бонусов: {bonus}</div>
                    </div>
                    <input type="text" id="order-bonus" className="checkout-form__input js-validate-promocode" name="Order[bonus]" placeholder="Списать бонусы" />
                    <input type="range" id="js-bonus-input" className="js-select-user-bonus" name="bonus" data-min="0" data-from="0" data-max={300} />
                </div>
            </label>


        );
    }

}

export default UserBonusField;