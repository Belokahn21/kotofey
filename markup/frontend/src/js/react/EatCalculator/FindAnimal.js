import React from "react";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";

class FindAnimal extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            animals: []
        };

        this.loadAnimal();
    }

    loadAnimal() {
        RestRequest.all(config.restAnimal + '?expand=image').then(data => {
            this.setState({animals: data});
        })
    }

    render() {
        const {animals} = this.state;
        let {selectAnimal} = this.props;
        return (
            <>
                {animals.map((element, index) => {
                    return <label className="eat-calculator-config-pet__item" key={index}>
                        <input name="pet" value={element.id} type="radio" onChange={selectAnimal}/>
                        <div className="eat-calculator-config-pet__checked">
                            <i className="fas fa-check"/>
                        </div>
                        <img src={element.image}/>
                    </label>
                })}
            </>
        );
    }

}

export default FindAnimal;