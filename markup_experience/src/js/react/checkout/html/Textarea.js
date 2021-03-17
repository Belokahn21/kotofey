import React, {Component} from 'react';

class Textarea extends Component {
    constructor(props) {
        super(props);

    }

    render() {
        return (
            <>
                <div className="checkout-form__label-text">{this.props.title}</div>
                <div className="form-group field-checkout-comment">
                    <textarea id="checkout-comment" className="checkout-form__textarea" name={this.props.buildElementName()} placeholder={this.props.options.placeholder}/>
                    <p className="help-block help-block-error"/>
                </div>
            </>
        );
    }

}

export default Textarea;