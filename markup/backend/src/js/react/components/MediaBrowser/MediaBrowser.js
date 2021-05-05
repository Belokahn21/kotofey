import React from 'react';
import ReactDom from 'react-dom';
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";
import {Modal} from "react-bootstrap";
import MediaCard from "./MediaCard";

class MediaBrowser extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            show: false,
            media: []
        };
        this.modalId = Math.random().toString(36).substring(7);
        this.loadMedia();
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

    render() {
        const {show, media} = this.state;
        return (
            <div>
                <input type="hidden" placeholder="Media ID"/>
                <button type="button" onClick={this.handleShow.bind(this)} className="btn-main">Выбрать</button>

                <Modal size="lg" show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Выбрать медиа</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="media-browser">
                            {media.map((el, i) => {
                                return <MediaCard key={i} element={el}/>
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
        ReactDom.render(<MediaBrowser/>, el);
    })
}