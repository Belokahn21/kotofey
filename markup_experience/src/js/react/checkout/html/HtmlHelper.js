import React, {Component} from "react";
import Input from "./Input";
import Textarea from "./Textarea";

class HtmlHelper extends Component {
    constructor(props) {
        super(props);

    }

    buildElementName() {
        return `${this.props.modelName}[${this.props.options.name}]`;
    }

    renderInput() {
        return <Input errors={this.props.errors} unsetError={this.props.unsetError} options={this.props.options} buildElementName={this.buildElementName.bind(this)}/>;
    }

    renderTextarea() {
        return <Textarea errors={this.props.errors} options={this.props.options} buildElementName={this.buildElementName.bind(this)}/>;
    }


    render() {

        switch (this.props.element) {
            case "input":
                return this.renderInput();
            case "textarea":
                return this.renderTextarea();
        }

    }

}

export default HtmlHelper;