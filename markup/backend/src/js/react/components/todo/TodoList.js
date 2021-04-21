import React from 'react';
import ConvertDate from '../../../block/ConvertDate'

class TodoList extends React.Component {

    constructor(props) {
        super(props);
        this.ConverDate = new ConvertDate;
    }

    render() {

        const {items, handleRemove} = this.props;

        return <ul className="todo-list">
            <li className="todo-list__row todo-list-header">
                <div className="todo-list-col">Название</div>
                <div className="todo-list-col">Дата создания</div>
                <div className="todo-list-col">Описание</div>
                <div className="todo-list-col">Кому назначена</div>
                <div className="todo-list-col"/>
            </li>
            {items.map((item, index) => {
                return <li className="todo-list__row todo-list-body" key={index}>
                    <div className="todo-list-col">{item.name}</div>
                    <div className="todo-list-col">{this.ConverDate.format(item.created_at)}</div>
                    <div className="todo-list-col">{item.description}</div>
                    <div className="todo-list-col">{item.user.email}</div>
                    <div className="todo-list-col">
                        <div className="todo-list-icons">
                            <i className="fas fa-pen"/>
                            <i className="fas fa-trash-alt" onClick={handleRemove.bind(this, item.id)}/>
                        </div>
                    </div>
                </li>
            })}
        </ul>;
    }
}

export default TodoList;