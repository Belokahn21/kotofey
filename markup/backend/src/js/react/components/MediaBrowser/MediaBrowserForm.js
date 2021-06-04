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
        let {addMedia} = this.props;


        RestRequest.post(config.restMedia, {
            body: data
        }).then(data => {
            addMedia(data);
            form.reset();
        })
    }

    render() {
        return <form method="POST" onSubmit={this.handleSubmitForm.bind(this)} encType="multipart/form-data">

            <div className="form-group">
                <label htmlFor="fileUpload">Файл</label>
                {/*<input type="file" name="path" className="form-control-file" id="fileUpload"/>*/}
                <input type="file" name="Media[path]" className="form-control-file" id="fileUpload"/>
            </div>

            <div className="form-group">
                <label htmlFor="nameFile">Имя файла</label>
                {/*<input type="text" name="name" className="form-control" id="nameFile" aria-describedby="emailHelp" placeholder="Имя файла"/>*/}
                <input type="text" name="Media[name]" className="form-control" id="nameFile" aria-describedby="emailHelp" placeholder="Имя файла"/>
            </div>


            <div className="form-group">
                <label htmlFor="selectLocation">Место хранения</label>
                {/*<select name="location" className="form-control" id="selectLocation">*/}
                <select name="Media[location]" className="form-control" id="selectLocation">
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
