import React from 'react';
import ReactDom from 'react-dom';
import FindBreed from "./FindBreed";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";
import Result from "./Result";
import FindAnimal from "./FindAnimal";

class EatCalculator extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            products: [],
            breeds: [],
            selected_animal_id: null
        }
    }

    handleTyping(event) {
        if (this.timerEx) clearTimeout(this.timerEx);
        let element = event.target;
        let value = element.value;
        let {selected_animal_id} = this.state;

        if (selected_animal_id == null) return false;

        this.timerEx = setTimeout(() => {
            RestRequest.all(config.restBreeds + '?BreedSearchForm[name]=' + value + '&BreedSearchForm[animal_id]=' + selected_animal_id).then(data => {
                this.setBreeds(data);
            });
        }, this.timerSec)
    }

    setBreeds(data) {
        this.setState({breeds: data});
    }

    loadBreeds() {
        RestRequest.all(config.restBreeds).then(data => {
            this.setBreeds(data);
        });
    }

    handleSubmitForm(event) {
        event.preventDefault();
        let form = event.target;

        RestRequest.post(config.restPetCalculator, {
            body: new FormData(form)
        }).then(data => {
            this.setState({products: data});
        })
    }

    handleSelectAnimal(event) {
        if (this.timerEx) clearTimeout(this.timerEx);
        let element = event.target;
        let value = element.value;

        this.timerEx = setTimeout(() => {
            RestRequest.all(config.restBreeds + '?BreedSearchForm[animal_id]=' + element.value).then(data => {
                this.setBreeds(data)
                this.setState({selected_animal_id: value});
            });
        }, this.timerSec)
    }

    render() {
        const {products, breeds, selected_animal_id} = this.state;
        return <div className="eat-calculator">
            <form className="eat-calculator-config" onSubmit={this.handleSubmitForm.bind(this)}>

                <div className="eat-calculator-config-row">


                    <div className="eat-calculator-config-pet eat-calculator-config-col">
                        <div className="eat-calculator-config-block">
                            <FindAnimal selectAnimal={this.handleSelectAnimal.bind(this)}/>
                        </div>

                    </div>

                    <div className="eat-calculator-config-age eat-calculator-config-col">
                        <div className="eat-calculator-config-block">
                            <div className="filter-catalog-checkboxes__item">
                                <input type="radio" name="age" value="1" id="filter-chb-1"/>
                                <label htmlFor="filter-chb-1"><i className="fas fa-paw" aria-hidden="true"/>До года</label>
                            </div>
                            <div className="filter-catalog-checkboxes__item">
                                <input type="radio" name="age" value="2" id="filter-chb-2"/>
                                <label htmlFor="filter-chb-2"><i className="fas fa-paw" aria-hidden="true"/>Больше года</label>
                            </div>
                            <div className="filter-catalog-checkboxes__item">
                                <input type="radio" name="age" value="3" id="filter-chb-3"/>
                                <label htmlFor="filter-chb-3"><i className="fas fa-paw" aria-hidden="true"/>Старше 7 лет</label>
                            </div>
                        </div>
                    </div>

                    <div className="eat-calculator-config-breed eat-calculator-config-col">
                        <div className="eat-calculator-config-block">
                            <FindBreed handleTyping={this.handleTyping.bind(this)} breeds={breeds}/>
                        </div>
                    </div>
                </div>

                <div className="eat-calculator-config-row eat-calculator-panel-action">
                    <button className="eat-calculator-submit" type="submit">Найти</button>
                </div>
            </form>

            <Result models={products}/>
        </div>
    }

}

let elements = document.querySelectorAll('.eat-calculator-react');
if (elements) {
    elements.forEach(el => {
        ReactDom.render(<EatCalculator/>, el);
    });
}