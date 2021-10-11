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
        const {options} = this.props;
        const {errors} = this.props;
        let error, aria_invalid;

        if (typeof errors === 'object' && !Array.isArray(errors)) {
            error = <Error errors={errors[options.name]}/>
            aria_invalid = errors[options.name] !== undefined && errors[options.name] !== null;
        }

        return (
            <label style={{display: options.isHiden == true ? 'none' : 'block'}} className="checkout-form__label" htmlFor={"checkout-" + options.name}>
                <div className="checkout-form__label-text">{options.title}</div>
                <input
                    onChange={this.handleInputChange.bind(this)}
                    className={"checkout-form__input " + options.class}
                    id={"checkout-" + options.name}
                    value={options.value}
                    name={this.props.buildElementName()}
                    type="text"
                    style={options.style}
                    aria-invalid={aria_invalid}
                    placeholder={options.placeholder}/>
                {error}
            </label>
        );
    }

}

export default Input;