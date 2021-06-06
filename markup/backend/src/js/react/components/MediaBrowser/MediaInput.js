import React from "react";

class MediaInput extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {name, element} = this.props;
        if (!element) return false;
        return <input type="hidden" value={element.id} name={name}/>
    }

}

export default MediaInput;