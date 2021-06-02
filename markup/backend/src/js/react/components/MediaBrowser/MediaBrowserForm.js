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
        let data = new FormData(form);
        let input = form.querySelector('input[type="file"]');

        if (input) {
            data.append('path', input.files[0]);
        }

        RestRequest.post(config.restMedia, {
            body: data
        }).then(data => {
            console.log(data);
        })
    }

    render() {
        return <form method="POST" onSubmit={this.handleSubmitForm.bind(this)} encType="multipart/form-data">

            <div className="form-group">
                <label htmlFor="fileUpload">Файл</label>
                <input type="file" name="path" className="form-control-file" id="fileUpload"/>
            </div>

            <div className="form-group">
                <label htmlFor="nameFile">Имя файла</label>
                <input type="text" name="name" className="form-control" id="nameFile" aria-describedby="emailHelp" placeholder="Имя файла"/>
            </div>


            <div className="form-group">
                <label htmlFor="selectLocation">Example select</label>
                <select name="location" className="form-control" id="selectLocation">
                    <option>Выбрать место хранения</option>
                    <option value="cdn">CDN</option>
                    <option value="server">Сервер</option>
                </select>
            </div>


            <button type="submit" className="btn-main">Загрузить</button>
        </form>
    }
}

export default MediaBrowserForm;
