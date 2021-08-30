import RestRequest from "../../../../frontend/src/js/tools/RestRequest";
import config from "../../../../frontend/src/js/config";
import React from "react";
import ReactDOM from 'react-dom';
import {map} from "react-bootstrap/ElementChildren";

class LoadBreedSizes {
    constructor() {
        this.element = document.querySelectorAll('.js-load-breed-sizes');
        this.panel = document.querySelector('.js-add-new-line-area');

        this.init();
    }

    init() {
        if (this.element) {
            this.element.forEach(el => {
                el.onclick = this.handleClick.bind(this);
            })
        }
    }

    handleClick(e) {
        e.preventDefault();
        let element = e.target;
        let key = element.getAttribute('data-key');


        RestRequest.all(config.restBreeds + '?BreedSearchForm[size]=' + key).then(data => {
            data.map(model => {
                ReactDOM.render(<RenderFormElement models={data}/>, this.panel)
            });
        })

    }
}

class RenderFormElement extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        let count = -1;
        const {models} = this.props;
        return <>
            {models.map(el => {
                count++;
                return <div className="row" key={el.id}>
                    <div className="col-sm-6">
                        <input name={`ProductToBreed[${count}][animal_id]`} value={el.animal_id}/>
                    </div>
                    <div className="col-sm-6">
                        <input name={`ProductToBreed[${count}][breed_id]`} value={el.id}/>
                    </div>
                </div>;

            })}
        </>
    }
}

export default LoadBreedSizes;