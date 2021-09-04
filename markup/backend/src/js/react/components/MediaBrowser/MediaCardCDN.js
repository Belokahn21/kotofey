import React from "react";

class MediaCardCDN extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const {element, handleSelectImage, handleRemoveImage, uniq} = this.props;
        const elementCdn = JSON.parse(element.json_cdn_data);

        return (
            <div className="media-browser-card" key={uniq}>
                <img className="media-browser-card__image" src={elementCdn.secure_url}/>
                {handleSelectImage ? <button type="button" className="media-browser-card__select" onClick={handleSelectImage.bind(this, element)}>Выбрать</button> : ""}
                {handleRemoveImage ? <button type="button" className="media-browser-card__select" onClick={handleRemoveImage.bind(this, element)}>Удалить</button> : ""}
            </div>
        );
    }

}

export default MediaCardCDN;