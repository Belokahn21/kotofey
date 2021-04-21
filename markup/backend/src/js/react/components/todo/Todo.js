import React from 'react';
import ReactDom from 'react-dom';
import List from './TodoList';
import TodoForm from './TodoForm';
import {Modal, Button} from 'react-bootstrap';
import $ from 'jquery';
import config from "../../config";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";

window.$ = $;

class Todo extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            show: false,
            items: []
        }

        this.loadData();
    }

    loadData() {
        fetch(config.restTodo + '?expand=user').then(response => response.json()).then(data => {
            this.setState({
                items: data.items
            });
        });
    }

    handleShow() {
        this.updateShow(true);
    }

    handleClose() {
        this.updateShow(false);
    }

    updateShow(show) {
        this.setState({show: show});
    }

    handleAddElement(event) {
        event.preventDefault();
        const form = event.target;
        console.log(new FormData(form));
        RestRequest.post(config.restTodo, {
            body: new FormData(form)
        });
    }

    render() {
        const {show, items} = this.state;
        return <div className="todo-wrap">
            <div className="todo">
                <div className="todo-header">
                    <div className="todo-header__title">Список задач</div>
                    <button className="todo-header__new-task" onClick={this.handleShow.bind(this)}>Добавить</button>
                </div>
                <List items={items}/>
                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Добавить новую задачу</Modal.Title>
                    </Modal.Header>

                    <Modal.Body>
                        <TodoForm handleAddElement={this.handleAddElement}/>
                    </Modal.Body>
                </Modal>
            </div>
        </div>
    }

}


const todoContainer = document.querySelector('#todo-react');
if (todoContainer) ReactDom.render(<Todo/>, todoContainer);