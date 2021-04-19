import React from 'react';

class PromotionElement extends React.Component {
    constructor(props) {
        super(props);
        this.modelName = '';
    }

    render() {
        return <div className="row">
            <div className="col-3">
                <select name={this.modelName + "[promotion_mechanic_id]"}>
                    <option>Механика аккци</option>
                    <option>Процент от цены</option>
                    <option>Добавить товар</option>
                </select>
            </div>
            <div className="col-3">
                <input type="text" name={this.modelName + "[product_id]"}/>
            </div>
            <div className="col-3">
                <input type="text" name={this.modelName + "[discountRule]"}/>
            </div>
            <div className="col-3">
                <input type="text" name={this.modelName + "[amount]"}/>
            </div>
        </div>;
    }
}

export default PromotionElement;