import React, {Component} from "react";

class Input extends Component {
    constructor(props) {
        super(props);

    }


    render() {
        return (
            <label className="checkout-form__label" htmlFor={"checkout-" + this.props.options.name}>
                <div>{this.props.options.title}</div>
                <input className="checkout-form__input" id={"checkout-" + this.props.options.name} name={this.props.buildElementName()} type="text" placeholder={this.props.options.placeholder}/>
            </label>
        );
    }

}

export default Input;