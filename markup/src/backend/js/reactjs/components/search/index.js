import React from 'react';
import ReactDom from 'react-dom';

import Result from '../search_result/index';

class Search extends React.Component {

	constructor() {
		super();
		this.timerId = null;
		this.state = {
			result: [],
			isShowResult: false
		};

		this.handleClick = this.handleClick.bind(this);
	}

	handleClick(e) {
		let elements = [];
		let value = e.target.value;
		let timerTime = 3000;
		const url = "http://local.kotofey.store/rest/product/get/?text=" + value;

		if (this.timerId) {
			clearTimeout(this.timerId);
		}

		this.timerId = setTimeout(() => {
			fetch(url)
				.then(response => response.json())
				.then(commits => this.renderResult(JSON.parse(commits)));
		}, timerTime);
	}

	renderResult(elements) {
		this.setState({
			result: elements,
			isShowResult: true
		});
	}

	render() {
		return (
			<div className="search-form-container">

				<form className="search-form">
					<input className="search-form__input" name="search" placeholder="Поиск по сайту..." onChange={this.handleClick}/>
				</form>

				<Result isNeedShow={this.state.isShowResult} result={this.state.result} />

			</div>
		)

	}
}

ReactDom.render(<Search/>, document.querySelector('.search-admin'));