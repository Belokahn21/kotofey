import React, {Component} from 'react';
import Error from "./Error";

class Textarea extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        let error, aria_invalid, options = this.props.options;

        if (typeof this.props.errors === 'object' && !Array.isArray(this.props.errors)) {
            error = <Error errors={this.props.errors[options.name]}/>
            aria_invalid = this.props.errors[options.name] !== undefined;
        }

        return (
            <>
                <div className="checkout-form__label-text">{this.props.title}</div>
                <div className="form-group field-checkout-comment">
                    <textarea id="checkout-comment" className="checkout-form__textarea" name={this.props.buildElementName()} aria-invalid={aria_invalid} placeholder={options.placeholder}/>
                    {error}
                </div>
            </>
        );
    }

}

export default Textarea;