import React from 'react';
import config from '../../config';

class TodoList extends React.Component {

    constructor() {
        super();


        this.state = {
            items: [
                {title: 'Убрать мусор', date: '14.10.2020', 'author': 'Vasin Konstanin', 'who': 'Irina Malyshko'},
                {title: 'Закрыть окно', date: '14.10.2020', 'author': 'Vasin Konstanin', 'who': 'Irina Malyshko'},
            ]
        };

        this.loadData();
    }

    render() {
        return <ul className="todo-list">
            <li className="todo-list__item todo-list-header">
                <div className="todo-list-col-25">Название</div>
                <div className="todo-list-col-25">Дата создания</div>
                <div className="todo-list-col-25">Ответственный</div>
                <div className="todo-list-col-25">Кому назначена</div>
            </li>
            {this.state.items.map((item, index) => {
                return <li className="todo-list__item todo-list-body" key={index}>
                    <div className="todo-list-col-25">{item.name}</div>
                    <div className="todo-list-col-25">{item.date}</div>
                    <div className="todo-list-col-25">{item.author}</div>
                    <div className="todo-list-col-25">{item.who}</div>
                </li>
            })}
        </ul>;
    }

    loadData() {
        fetch(config.restTodoGet).then(response => response.json()).then(data => {
            this.setState({
                items: data
            });
        });
    }
}

module.exports = TodoList;