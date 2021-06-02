import React from 'react';
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";

class MediaBrowserForm extends React.Component {
    constructor(props) {
        super(props);
    }

    handleSubmitForm(event) {
        event.preventDefault();
        let form = event.target;

        RestRequest.post(config.restMediaUpload, {
            body: new FormData(form)
        }).then(data => {
            console.log(data);
        })
    }

    render() {
        return <form method="POST" onSubmit={this.handleSubmitForm.bind(this)}>
            <input type="file" name="file"/>
            <input type="name" name="text"/>
            <select name="text">
                <option>Выбрать место хранения</option>
                <option value="cdn">CDN</option>
                <option value="server">Сервер</option>
            </select>
            <button type="submit" className="btn-main">Загрузить</button>
        </form>
    }
}

export default MediaBrowserForm;
