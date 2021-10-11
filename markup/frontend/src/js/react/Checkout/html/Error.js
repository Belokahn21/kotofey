import React, {Component} from 'react';

class Error extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return <p className="help-block help-block-error">{this.props.errors}</p>
    }
}

export default Error;