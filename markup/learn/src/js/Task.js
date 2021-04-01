import React from 'react';

const Task = ({task, ...props}) => {

    const ActionBtn = () => <div className="item-toggle">{task.done ? '+' : '-'}</div>;

    return <div className="task-item">
        <p>{task.title}</p>
        <ActionBtn/>
    </div>
};

export default Task;