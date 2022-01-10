import React from "react";

export default function WaitButton({active, label}) {
    return <button type="submit" disabled={active} className="add-basket checkout-form__submit">
        {!active ? '' : <div>
            <img style={{filter: "none", width: "15px", objectFit: 'contain', margin: '0 5px 0 0'}} src="/images/hug.gif"/>
        </div>}
        {label}
    </button>
}