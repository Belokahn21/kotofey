import React, {Component} from "react";
import config from "../../../config";
import RestRequest from "../../../tools/RestRequest";
import Slider from 'rc-slider';


class UserBonusField extends Component {
    constructor(props, context) {
        super(props, context);

        this.accountId = this.props.accountId, this.timerEx, this.timeout = 80, this.marks = {0: 0, 999: 999};

        this.state = {
            bonus: 0,
            selectedBonuses: 0
        };
        this.loadBonus();
    }

    componentDidMount() {
        // this.loadBonus();
    }

    loadBonus() {
        RestRequest.one(config.restBonus, this.accountId).then(data => {
            this.setState({
                bonus: 999
            });
        });
    }

    handleChangeInput(amount) {
        if (this.timerEx) clearTimeout(this.timerEx);

        this.setState({selectedBonuses: amount});

        this.timerEx = setTimeout(() => {
            this.props.updateUsedBonus(amount);
            this.props.refreshBasket();
        }, this.timeout);
    }

    render() {
        return (
            <label className="checkout-form__label" htmlFor="checkout-phone">
                <div className="form-group field-order-bonus has-success">

                    <div className="checkout-form-label-group">
                        <div className="checkout-form__label-text">Бонусы</div>
                        <div className="checkout-form__label-text">Доступно бонусов: {this.state.bonus}</div>
                    </div>
                    <input type="text" id="order-bonus" className="checkout-form__input" name="Order[bonus]"  readOnly={true} value={this.state.selectedBonuses} placeholder="Списать бонусы"/>
                    <Slider min={0} max={999} marks={this.marks} onChange={this.handleChangeInput.bind(this)}/>
                </div>
            </label>


        );
    }

}

export default UserBonusField;