import React, {Component} from "react";
import HtmlHelper from "../html/HtmlHelper";
import config from "../../../config";

class UserBonusField extends Component {
    constructor(props) {
        super(props);

        this.accountId = this.props.accountId;

        this.state = {
            bonus: 0
        };

        this.loadBonus();
    }

    loadBonus() {
        fetch(config.restBonusGet + '/' + this.accountId + '/').then(response => response.json()).then(data => {
            if (data.status == 200) {
                this.setState({
                    bonus: data.count
                });
            }
        });
    }


    render() {
        return (
            <label className="checkout-form__label" htmlFor="checkout-phone">
                <div className="form-group field-order-bonus">
                    <div className="checkout-form-label-group">
                        <div>Бонусы</div>
                        <div>Доступно бонусов: {this.state.bonus}</div>
                    </div>
                    <HtmlHelper element="input" modelName="Order" options={{class: "js-validate-promocode", placehoder: "Списать бонусы", title: "Бонусы"}}/>
                    <input type="range" id="js-bonus-input" className="js-select-user-bonus " name="bonus" data-min="0" data-from="0" data-max="0" tabIndex="-1" readOnly=""/>
                    <p className="help-block help-block-error"/>
                </div>
            </label>
        );
    }

}

export default UserBonusField;