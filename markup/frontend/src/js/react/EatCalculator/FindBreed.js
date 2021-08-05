import React from "react";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";
import FindBreedForm from "./FindBreedForm";

class FindBreed extends React.Component {
    constructor(props) {
        super(props);

        this.timerEx;
        this.timerSec = 600;


    }

    render() {
        const {breeds, handleTyping} = this.props;
        return <>
            <FindBreedForm handleTyping={handleTyping}/>
            <div className="breed-list">
                {breeds.map((el, i) => {
                    return <div className="breed-list-item" key={i}>
                        <div className="breed-list-item__name">
                            {el.name}
                        </div>

                        <div className="filter-catalog-checkboxes__item">
                            <input type="radio" name="breed" value={el.id} id={"breed-filter-" + el.id}/>
                            <label htmlFor={"breed-filter-" + el.id}><i className="fas fa-paw" aria-hidden="true"/></label>
                        </div>
                    </div>
                })}
            </div>
        </>
    }
}

export default FindBreed;