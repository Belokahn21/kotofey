import React from "react";

class MediaCardServer extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {element, handleSelectImage, handleRemoveImage, uniq} = this.props;
        const image_path = `/upload/${element.path}`;
        return <div className="media-browser-card" key={uniq}>
            <a target="_blank" href={`/admin/media/media-backend/update/?id=${element.id}`}>
                <img className="media-browser-card__image" src={image_path}/>
            </a>
            {handleSelectImage ? <button type="button" className="media-browser-card__select" onClick={handleSelectImage.bind(this, element)}>Выбрать</button> : ""}
            {handleRemoveImage ? <button type="button" className="media-browser-card__select" onClick={handleRemoveImage.bind(this, element)}>Удалить</button> : ""}
        </div>;
    }

}

export default MediaCardServer;