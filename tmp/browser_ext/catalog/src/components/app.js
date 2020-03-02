import React, {Component} from "react";

import '../styles/App.css';

class App extends Component {
    render() {
        return (
            <form className="milenium-form">
                <label className="w-100">
                    __MSG_form_input_name__
                    <input type="text" value={this.props.result.name + ", " + this.props.result.weight + "__MSG_weight_unit__"}/>
                </label>

                <label>
                    __MSG_form_input_purchase__
                    <input type="text" value={this.props.result.purchase}/>
                </label>

                <label>
                    __MSG_form_input_price__
                    <input type="text" value={this.props.result.price}/>
                </label>

                <label>
                    __MSG_form_input_article__
                    <input type="text" value={this.props.result.article}/>
                </label>

                <label>
                    __MSG_form_input_weight__
                    <input type="text" value={this.props.result.weight}/>
                </label>

                <label>
                    __MSG_form_input_category__
                    <select name="category_id" className="category_three">
                    </select>
                </label>

                <label className="w-100">
                    <textarea name="description">{this.props.result.description}</textarea>
                </label>

                <div className="form-control">
                    <button type="button" className="form-control-button">__MSG_form_button_submit__</button>
                </div>
            </form>
        );
    }
}

export default App;