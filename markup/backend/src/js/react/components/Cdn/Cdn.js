import React from 'react';
import ReactDOM from 'react-dom';
import {Modal} from "react-bootstrap";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from '../../config';
import MediaCard from "../Media/MediaCard";

class Cdn extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            show: false,
            resources: []
        };
        this.modalId = Math.random().toString(36).substring(7);
        this.loadResources();
    }

    loadResources() {
        RestRequest.all(config.restMeida).then(data => {
            this.setState({
                resources: data
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

    handleRemove() {

    }

    render() {
        const {show} = this.state;
        const {resources} = this.state;
        return (
            <div>
                <button type="button" onClick={this.handleShow.bind(this)} className="btn-main">Выбрать</button>

                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Выбрать медиа из CDN</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="cdn-resource-list">
                            {resources.map((el, i) => {
                                return <MediaCard handleRemove={this.handleRemove} resource={el}/>
                            })}
                        </div>
                    </Modal.Body>
                </Modal>
            </div>
        );
    }
}

const element = document.querySelector('.cdn-modal-react');
if (element) ReactDOM.render(<Cdn/>, element);