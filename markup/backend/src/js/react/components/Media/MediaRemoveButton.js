import React from 'react';

class MediaRemoveButton extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        const {handleRemove} = this.props;
        return (
            <div onClick={handleRemove.bind(this)}>
                X
            </div>
        );
    }
}

export default MediaRemoveButton;