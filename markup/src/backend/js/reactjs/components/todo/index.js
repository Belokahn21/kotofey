import React, {useState} from 'react';
import ReactDom from 'react-dom';
import List from './list';
import {Modal, Button} from 'react-bootstrap';
import $ from 'jquery';

window.$ = $;

function Todo() {
    const [show, setShow] = useState(false);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    return (
        <div className="todo">
            <div className="todo-header">
                <div className="todo-header__title">Список задач</div>
                <button className="todo-header__new-task" onClick={handleShow}>Добавить</button>
            </div>
            <List/>
            <Modal show={show} onHide={handleClose}>
                <Modal.Dialog closeButton>
                    <Modal.Header>
                        <Modal.Title>Добавить новую задачу</Modal.Title>
                    </Modal.Header>

                    <Modal.Body>
                        <p>Новая задача</p>
                    </Modal.Body>

                    <Modal.Footer>
                        <Button variant="secondary" onClick={handleClose}>Закрыть</Button>
                        <Button variant="primary" onClick={handleClose}>Сохранить</Button>
                    </Modal.Footer>
                </Modal.Dialog>
            </Modal>
        </div>
    );
}

const todoContainer = document.querySelector('#todo-react');

if (todoContainer) {
    ReactDom.render(<Todo/>, todoContainer);
}