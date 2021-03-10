import React, {Component} from "react";
import Error from "./Error";

class Input extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const options = this.props.options;
        let error;

        if (this.props.errors) error = <Error errors={this.props.errors[options.name]}/>

        return (
            <label className="checkout-form__label" htmlFor={"checkout-" + options.name}>
                <div>{options.title}</div>
                <input className={"checkout-form__input " + options.class} id={"checkout-" + options.name} name={this.props.buildElementName()} type="text" placeholder={options.placeholder}/>
                {error}
            </label>
        );
    }

}

export default Input;