import React, {Component} from "react";
import config from "../../../config";
import RestRequest from "../../../tools/RestRequest";
import Slider from 'rc-slider';


class UserBonusField extends Component {
    constructor(props, context) {
        super(props, context);

        this.accountId = this.props.accountId;

        this.state = {
            bonus: 0,
            used: 0
        };
        // this.loadBonus();
    }

    componentDidMount() {
        this.loadBonus();
    }

    loadBonus() {
        RestRequest.one(config.restBonus, this.accountId).then(data => {
            if (data.count !== undefined) {
                this.setState({
                    bonus: parseInt(data.count)
                });
            }
        });
    }

    handleChangeInput(amount) {

        if (amount > this.state.bonus) {
            amount = this.state.bonus;
        }

        this.setState({used: amount});
        this.props.updateUsedBonus(amount);
        this.props.refreshBasket();
    }

    render() {
        return (
            <label className="checkout-form__label" htmlFor="checkout-phone">
                <div className="form-group field-order-bonus has-success">

                    <div className="checkout-form-label-group">
                        <div className="checkout-form__label-text">Бонусы</div>
                        <div className="checkout-form__label-text">Доступно бонусов: {parseInt(this.state.bonus) - parseInt(this.state.used)}</div>
                    </div>
                    <input type="text" id="order-bonus" className="checkout-form__input" name="Order[bonus]" readOnly={true} value={this.state.used} placeholder="Списать бонусы"/>
                    <Slider min={0} max={this.state.bonus} onChange={this.handleChangeInput.bind(this)}/>
                </div>
            </label>


        );
    }

}

export default UserBonusField;