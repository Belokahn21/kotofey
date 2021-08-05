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
        const {breeds,handleTyping} = this.props;
        return <>
            <FindBreedForm handleTyping={handleTyping}/>
            <div className="breed-list">
                {breeds.map((el, i) => {
                    return <div className="breed-list-item" key={i}>
                        <div className="breed-list-item__name">
                            {el.name}
                        </div>

                        <label className="breed-list-item-select">
                            <input type="checkbox" name="breed" value={el.id}/>
                            <div className="breed-list-item-select__marker"/>
                        </label>
                    </div>
                })}
            </div>
        </>
    }
}

export default FindBreed;