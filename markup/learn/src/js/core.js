import React from 'react';
import ReactDOM from 'react-dom';
import Task from './Task';

class App extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            tasks: [
                {id: 0, title: 'Create todo-react app 1', done: false},
                {id: 1, title: 'Create todo-react app 2', done: false},
                {id: 2, title: 'Create todo-react app 3', done: false},
                {id: 3, title: 'Create todo-react app 4', done: false}
            ]
        }
    }

    render() {

        const {tasks} = this.state;

        return <div className="App">
            <h1 className="top">ActiveTask: {tasks.length}</h1>
            {tasks.map((el, key) => {
                return <Task task={el} key={key}/>
            })}
        </div>
    }
}


const element = document.querySelector('#ract-app');
if (element) ReactDOM.render(<App/>, element);