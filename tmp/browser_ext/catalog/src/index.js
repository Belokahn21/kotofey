import React from "react";
import ReactDOM from "react-dom";
import App from "./components/App.js";


document.addEventListener('DOMContentLoaded', function () {
    chrome.tabs.query({currentWindow: true, active: true}, function (tabs) {
        chrome.tabs.sendMessage(tabs[0].id, 'hi !', render);
    });

    function render(res) {
        ReactDOM.render(<App result={res.element} />, document.getElementById("root"));
    }


}, false);