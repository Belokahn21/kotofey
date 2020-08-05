import React from 'react';

class TodoList extends React.Component {

    constructor() {
        super();


        this.state = {
            items: [
                {title: 'Убрать мусор', date: '14.10.2020', 'author': 'Vasin Konstanin', 'who': 'Irina Malyshko'},
                {title: 'Закрыть окно', date: '14.10.2020', 'author': 'Vasin Konstanin', 'who': 'Irina Malyshko'},
            ]
        };
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
                    <div className="todo-list-col-25">{item.title}</div>
                    <div className="todo-list-col-25">{item.date}</div>
                    <div className="todo-list-col-25">{item.author}</div>
                    <div className="todo-list-col-25">{item.who}</div>
                </li>
            })}
        </ul>;
    }
}

module.exports = TodoList;