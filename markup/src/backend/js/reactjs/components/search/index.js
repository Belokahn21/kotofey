import React from 'react';
import Result from './result';

class Search extends React.Component {
	constructor() {
		super();
		this.timerId = null;
		this.state = {
			result: [],
			isShowResult: false,
			isNeedShowLoader: ""
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
			this.loadProcessOn();
			fetch(url)
				.then(response => response.json())
				.then(commits => {
					this.loadProcessOff();
					this.renderResult(JSON.parse(commits))
				});
		}, timerTime);
	}

	loadProcessOn() {
		this.setState({
			isNeedShowLoader: "with-loader",
		});
	}

	loadProcessOff() {
		this.setState({
			isNeedShowLoader: "",
		});
	}

	renderResult(elements) {
		this.setState({
			result: elements,
			isShowResult: true
		});
	}

	render() {
		return (
			<div className="search-admin">
				<div className="search-form-container">

					<form className="search-form">
						<input className={this.state.isNeedShowLoader + " search-form__input"} name="search" placeholder="Поиск по сайту..." onChange={this.handleClick}/>
					</form>

					<Result isNeedShow={this.state.isShowResult} result={this.state.result}/>

				</div>
			</div>
		)

	}
}

module.exports = Search;