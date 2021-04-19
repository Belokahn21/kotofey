import React from "react";
import config from '../../config';

class TodoForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            users: []
        };

        this.findUsers();

        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(event) {
        event.preventDefault();
        console.log('Форма отправлена');


        fetch(config.restTodoAdd, {
            method: 'POST',
            body: new FormData(event.target)
        }).then(response => response.json()).then(data => {
            console.log(data);
        });
    }

    render() {
        const ARClassName = 'TodoList';

        return (
            <form action="" className="todo-form" id="todo-new-task" onSubmit={this.handleSubmit}>
                <div className="todo-form__element">
                    <input className="todo-form__input" type="text" name={ARClassName + '[name]'} placeholder="Заголовок задачи"/>
                </div>

                <div className="todo-form__element">
                    <select className="todo-form__select" name={ARClassName + '[user_id]'}>
                        <option>Кому назначена</option>
                        {this.state.users.map((user, index) => {
                            return <option key={index} value={user.id}>{user.email}</option>
                        })}
                    </select>
                </div>

                <div className="todo-form__element">
                    <textarea className="todo-form__textarea" name={ARClassName + '[description]'} rows="10" placeholder="Описание задачи"/>
                </div>

                <button type="submit" className="btn btn-primary">Добавить</button>
            </form>
        );
    }

    findUsers() {
        fetch(config.restUserGet).then(response => response.json()).then(data => {
            this.setState({
                users: data
            });
        });
    }
}

export default TodoForm;