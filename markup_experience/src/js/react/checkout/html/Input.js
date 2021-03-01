import React, {Component} from "react";

class Input extends Component {
    constructor(props) {
        super(props);

    }

    buildElementName() {
        return `Order[${this.props.name}]`;
    }

    render() {
        return (
            <label className="checkout-form__label" htmlFor={"checkout-" + this.props.name}>
                <div>{this.props.title}</div>
                <input className="checkout-form__input" id={"checkout-" + this.props.name} name={this.props.name} type="text" placeholder={this.props.placeholder}/>
            </label>
        );
    }

}

export default Input;