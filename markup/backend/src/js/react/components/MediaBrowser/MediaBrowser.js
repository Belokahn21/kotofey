import React from 'react';
import ReactDom from 'react-dom';
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";
import {Modal} from "react-bootstrap";
import MediaCard from "./MediaCard";
import MediaInput from "./MediaInput";
import MediaBrowserForm from "./MediaBrowserForm";

class MediaBrowser extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            show: false,
            show_new_media: false,
            inputs: [],
            media: []
        };
        this.config = null;
        this.modalId = Math.random().toString(36).substring(7);
        this.loadMedia();

        if (props.config) this.config = JSON.parse(props.config);

        if (this.config.values !== null && this.config.values.length > 0) {
            this.loadInputs(this.config.values);
        }
    }

    loadMedia() {
        RestRequest.all(config.restMedia + '?sort=-id').then(data => {
            this.setState({
                media: data
            })
        });
    }

    addMedia(media_row) {
        let {media} = this.state;

        media.unshift(media_row);

        this.setState({
            media: media
        });
    }

    loadInputs(ids) {
        for (let id in ids) {
            RestRequest.one(config.restPropertiesProductValues, ids[id], '?expand=media').then(data => {
                if (data.media !== null) {
                    this.fillInputs(data.media);
                }
            });
        }

    }

    setShow(show) {
        this.setState({show: show});
    }

    setShowNewMedia(show) {
        this.setState({show_new_media: show});
    }

    handleClose() {
        this.setShow(false);
    }

    handleCloseNewMedia() {
        this.setShowNewMedia(false);
    }

    handleShow() {
        this.setShow(true);
    }

    handleShowNewMedia() {
        this.setShowNewMedia(true);
    }

    handleSelectImage(mediaElement, e) {
        e.preventDefault();
        this.fillInputs(mediaElement);
    }

    handleRemoveImage(mediaEl, e) {
        e.preventDefault();
        let inputs = this.state.inputs;

        inputs.map((mediaElement, key) => {
            if (parseInt(mediaElement.id) === parseInt(mediaEl.id)) inputs.splice(key, 1);
        });

        this.setState({
            inputs: inputs
        });
    }

    fillInputs(mediaElement) {
        let {inputs} = this.state;
        inputs.push(mediaElement);

        inputs = [...new Set(inputs)];

        this.setState({
            inputs: inputs
        })
    }

    render() {
        const {show, media, inputs, show_new_media} = this.state;
        const input_name = this.config.model + this.config.attribute;
        return (
            <div>
                <div className="media-browser">
                    <input type="hidden" name={input_name}/>
                    {inputs.map((el, i) => {
                        return <>
                            <MediaCard key={i} uniq={i} element={el} handleRemoveImage={this.handleRemoveImage.bind(this)}/>
                            <MediaInput name={input_name} element={el} key={i} uniq={i}/>
                        </>
                    })}
                </div>
                <button type="button" onClick={this.handleShow.bind(this)} className="btn-main">Выбрать</button>

                <Modal size="lg" show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>
                            Выбрать медиа

                            <button type="button" onClick={this.handleShowNewMedia.bind(this)} className="btn-main">Добавить</button>
                        </Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="media-browser">
                            {media.map((el, i) => {
                                return <MediaCard handleSelectImage={this.handleSelectImage.bind(this)} uniq={i} key={i} element={el}/>
                            })}
                        </div>
                    </Modal.Body>
                </Modal>

                <Modal size="lg" show={show_new_media} onHide={this.handleCloseNewMedia.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>
                            Загрузить новое медиа
                        </Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <MediaBrowserForm addMedia={this.addMedia.bind(this)}/>
                    </Modal.Body>
                </Modal>
            </div>
        );
    }
}

let elements = document.querySelectorAll('.media-browser-react');
if (elements) {
    elements.forEach(el => {
        ReactDom.render(<MediaBrowser config={el.getAttribute('data-config')}/>, el);
    })
}