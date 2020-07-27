import React from 'react';
import ReactDom from 'react-dom';
import config from '../../config';
import {Modal, Button} from 'react-bootstrap';

class StatisticItem extends React.Component {

	constructor(props) {
		super(props);
	}

	render() {
		return (
			<li className="statistic__item" key={this.props.index}>
				<div className="statistic__icon" data-toggle="modal" data-target="#exampleModal">
						<span>
							<i className={"fas " + this.props.element.icon}></i>
						</span>
				</div>
				<div className="statistic__content">
					<ul className="statistic-info">
						{this.props.element.data.map((element, index) => {
							return <li className="statistic-info__row" key={index}>
								<div className="statistic-info__key">{element.title}</div>
								<div className="statistic-info__value">{element.value}</div>
							</li>
						})}
					</ul>
				</div>


				<div className="modal fade" id="exampleModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div className="modal-dialog" role="document">
						<div className="modal-content">
							<div className="modal-header">
								<h5 className="modal-title" id="exampleModalLabel">Modal title</h5>
								<button type="button" className="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div className="modal-body">
								...
							</div>
							<div className="modal-footer">
								<button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" className="btn btn-primary">Save changes</button>
							</div>
						</div>
					</div>
				</div>
			</li>
		);
	}
}

module.exports = StatisticItem;