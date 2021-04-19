import React from 'react';

class MediaRemoveButton extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        const {resource} = this.props;
        const {handleRemove} = this.props;

        return (
            <div className="cdn-resource-list__close" onClick={handleRemove.bind(this, resource)}>
                X
            </div>
        );
    }
}

export default MediaRemoveButton;