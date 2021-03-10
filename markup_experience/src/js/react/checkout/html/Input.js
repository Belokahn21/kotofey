import React, {Component} from "react";

class Input extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        const options = this.props.options;
        return (
            <label className="checkout-form__label" htmlFor={"checkout-" + options.name}>
                <div>{options.title}</div>
                <input className={"checkout-form__input " + options.class} id={"checkout-" + options.name} name={this.props.buildElementName()} type="text" placeholder={options.placeholder}/>
                <p className="help-block help-block-error" />
            </label>
        );
    }

}

export default Input;