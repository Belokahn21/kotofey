import React from 'react';
import config from '../../config';
import ConvertDate from '../../../block/ConvertDate'

class TodoList extends React.Component {

    constructor(props) {
        super(props);

        this.ConverDate = new ConvertDate;

        this.state = {
            items: []
        };

        this.loadData();
    }

    render() {
        return <ul className="todo-list">
            <li className="todo-list__row todo-list-header">
                <div className="todo-list-col">Название</div>
                <div className="todo-list-col">Дата создания</div>
                <div className="todo-list-col">Описание</div>
                <div className="todo-list-col">Кому назначена</div>
                <div className="todo-list-col"/>
            </li>
            {this.state.items.map((item, index) => {
                return <li className="todo-list__row todo-list-body" key={index}>
                    <div className="todo-list-col">{item.name}</div>
                    <div className="todo-list-col">{this.ConverDate.format(item.created_at)}</div>
                    <div className="todo-list-col">{item.description}</div>
                    <div className="todo-list-col">{item.user_id}</div>
                    <div className="todo-list-col">
                        <div className="todo-list-icons">
                            <i className="fas fa-pen"></i>
                            <i className="fas fa-trash-alt"></i>
                        </div>
                    </div>
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

export default TodoList;