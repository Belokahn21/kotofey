import {Component} from 'react';

class PromotionElement extends Component {
    constructor(props) {
        super(props);
        this.modelName = '';
    }

    render() {
        return <div>
            <input type="text" name={this.modelName + "[promotion_mechanic_id]"}/>
            <input type="text" name={this.modelName + "[product_id]"}/>
            <input type="text" name={this.modelName + "[discountRule]"}/>
            <input type="text" name={this.modelName + "[amount]"}/>
        </div>;
    }
}

export default PromotionElement;