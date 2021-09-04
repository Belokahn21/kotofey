import React from 'react';
import MediaCardCDN from "./MediaCardCDN";
import MediaCardServer from "./MediaCardServer";

class MediaCard extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const {element, handleSelectImage, handleRemoveImage, uniq} = this.props;

        if (!element) return false;

        return element.location === 'cdn' ?
            <MediaCardCDN element={element} handleSelectImage={handleSelectImage} handleRemoveImage={handleRemoveImage} uniq={uniq}/> :
            <MediaCardServer element={element} handleSelectImage={handleSelectImage} handleRemoveImage={handleRemoveImage} uniq={uniq}/>;
    }
}

export default MediaCard;