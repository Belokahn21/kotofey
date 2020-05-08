import React from 'react';
import ReactDom from 'react-dom';

import Result from '../search_result/index';

class Search extends React.Component {

	handleClick(e) {
		console.log('значение this:', e.target.value);
	}

	render() {
		return (
			<form className="search-form">
				<input className="search-form__input" name="search" placeholder="Поиск по сайту..." onChange={this.handleClick}/>
				<Result/>
			</form>
		)
	}
}

ReactDom.render(<Search/>, document.querySelector('.search-admin'));