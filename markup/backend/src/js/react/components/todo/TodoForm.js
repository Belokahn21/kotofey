import React from "react";
import config from '../../config';

class TodoForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            users: []
        };

        this.findUsers();
    }

    render() {
        const modelName = 'TodoList';
        const {users} = this.state;

        return (
            <form className="todo-form" id="todo-new-task" onSubmit={this.props.handleAddElement.bind(this)}>
                <div className="todo-form__element">
                    <input className="todo-form__input" type="text" name="name" placeholder="Заголовок задачи"/>
                </div>

                <div className="todo-form__element">
                    <select className="todo-form__select" name='user_id'>
                        <option>Кому назначена</option>
                        {users.map((user, index) => {
                            return <option key={index} value={user.id}>{user.email}</option>
                        })}
                    </select>
                </div>

                <div className="todo-form__element">
                    <textarea className="todo-form__textarea" name="description" rows="10" placeholder="Описание задачи"/>
                </div>

                <button type="submit" className="btn btn-primary">Добавить</button>
            </form>
        );
    }

    findUsers() {
        fetch(config.restUser).then(response => response.json()).then(data => {
            this.setState({
                users: data
            });
        });
    }
}

export default TodoForm;