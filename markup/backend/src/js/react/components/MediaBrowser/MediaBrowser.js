import React from 'react';
import ReactDom from 'react-dom';
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";
import {Modal} from "react-bootstrap";
import MediaCard from "./MediaCard";
import MediaInput from "./MediaInput";

class MediaBrowser extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            show: false,
            inputs: [],
            media: []
        };
        this.config = null;
        this.modalId = Math.random().toString(36).substring(7);
        this.loadMedia();

        if (props.config) this.config = JSON.parse(props.config);
    }

    loadMedia() {
        RestRequest.all(config.restMeida).then(data => {
            this.setState({
                media: data
            })
        });
    }

    setShow(show) {
        this.setState({show: show});
    }

    handleClose() {
        this.setShow(false);
    }

    handleShow() {
        this.setShow(true);
    }

    handleSelectImage(mediaElement, e) {
        let {inputs} = this.state;

        inputs.push(mediaElement);

        inputs = [...new Set(inputs)];

        this.setState({
            inputs: inputs
        })
    }

    render() {
        const {show, media, inputs} = this.state;
        return (
            <div>
                <div className="media-browser">
                    {inputs.map((el, i) => {
                        return <>
                            <MediaCard key={i} element={el}/>
                            <MediaInput name={this.config.model + this.config.attribute} element={el} key={i}/>
                        </>
                    })}
                </div>
                <button type="button" onClick={this.handleShow.bind(this)} className="btn-main">Выбрать</button>

                <Modal size="lg" show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Выбрать медиа</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="media-browser">
                            {media.map((el, i) => {
                                return <MediaCard handleSelectImage={this.handleSelectImage.bind(this)} key={i} element={el}/>
                            })}
                        </div>
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