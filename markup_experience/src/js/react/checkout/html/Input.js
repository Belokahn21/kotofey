import React, {Component} from "react";
import Error from "./Error";

class Input extends Component {
    constructor(props) {
        super(props);

    }

    handleInputChange(e) {
        this.props.unsetError(this.props.options.name);
    }

    render() {
        const options = this.props.options;
        let error, aria_invalid;

        if (typeof this.props.errors === 'object' && !Array.isArray(this.props.errors)) {
            error = <Error errors={this.props.errors[options.name]}/>
            aria_invalid = this.props.errors[options.name] !== undefined && this.props.errors[options.name] !== null;
        }

        return (
            <label className="checkout-form__label" htmlFor={"checkout-" + options.name}>
                <div className="checkout-form__label-text">{options.title}</div>
                <input
                    onChange={this.handleInputChange.bind(this)}
                    className={"checkout-form__input " + options.class}
                    id={"checkout-" + options.name}
                    name={this.props.buildElementName()}
                    type="text"
                    aria-invalid={aria_invalid}
                    placeholder={options.placeholder}/>
                {error}
            </label>
        );
    }

}

export default Input;