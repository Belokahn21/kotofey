import React from 'react';

class MediaCard extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const {element} = this.props;
        const elementCdn = JSON.parse(element.json_cdn_data);

        return <div className="media-browser-card">
            <img className="media-browser-card__image" src={elementCdn.secure_url}/>
        </div>
    }
}

export default MediaCard;