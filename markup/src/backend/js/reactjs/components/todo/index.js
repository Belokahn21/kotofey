import React from 'react';
import ReactDom from 'react-dom';
import List from './list';

class Todo extends React.Component {
    render() {
        return <div className="todo">
            <div className="todo-header">
                <div className="todo-header__title">Список задач</div>
                <button className="todo-header__new-task">Добавить</button>
            </div>
            <List/>
        </div>;
    }
}

const todoContainer = document.querySelector('#todo-react');

if (todoContainer) {
    ReactDom.render(<Todo/>, todoContainer);
}