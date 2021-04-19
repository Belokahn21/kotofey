import React from 'react';
import MediaRemoveButton from "./MediaRemoveButton";

class MediaCard extends React.Component {

    constructor(props) {
        super(props);
    }


    render() {

        const {resource} = this.props;
        const {handleRemove} = this.props;

        return (
            <div className="cdn-resource-list__item">
                <MediaRemoveButton resource={resource} handleRemove={handleRemove}/>
                <img width="150" src={resource.secure_url}/>
            </div>
        );
    }
}

export default MediaCard;