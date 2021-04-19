import React, {useState} from 'react';
import ReactDom from 'react-dom';
import List from './list';
import TodoForm from './form';
import {Modal, Button} from 'react-bootstrap';
import $ from 'jquery';

window.$ = $;

function Todo() {
    const [show, setShow] = useState(false);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    return (
        <div className="todo-wrap">
            <div className="todo">
                <div className="todo-header">
                    <div className="todo-header__title">Список задач</div>
                    <button className="todo-header__new-task" onClick={handleShow}>Добавить</button>
                </div>
                <List/>
                <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>Добавить новую задачу</Modal.Title>
                    </Modal.Header>

                    <Modal.Body>
                        <TodoForm/>
                    </Modal.Body>

                    <Modal.Footer>
                    </Modal.Footer>
                </Modal>
            </div>
        </div>
    );
}

const todoContainer = document.querySelector('#todo-react');
if (todoContainer) ReactDom.render(<Todo/>, todoContainer);