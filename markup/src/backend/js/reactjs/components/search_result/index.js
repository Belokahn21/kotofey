import React from 'react';

class SearchResult extends React.Component {

    renderAjaxItems(items) {
    	console.log('start render items in result component');
    	console.log(items);
    	console.log('end render items in result component');
    }

    render() {
        return (
            <div className="search-result">
                Результат поиска
            </div>
        )
    }
}

module.exports = SearchResult;