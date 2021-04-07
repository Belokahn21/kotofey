import React, {Component} from 'react';
import Error from "./Error";

class Textarea extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        let error, aria_invalid;
        const {options} = this.props;
        const {errors} = this.props;

        if (typeof errors === 'object' && !Array.isArray(errors)) {
            error = <Error errors={errors[options.name]}/>
            aria_invalid = errors[options.name] !== undefined;
        }

        return (
            <>
                <div className="checkout-form__label-text">{options.title}</div>
                <div className="form-group field-checkout-comment">
                    <textarea id="checkout-comment" className="checkout-form__textarea" name={this.props.buildElementName()} aria-invalid={aria_invalid} placeholder={options.placeholder}/>
                    {error}
                </div>
            </>
        );
    }

}

export default Textarea;