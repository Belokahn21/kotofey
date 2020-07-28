import React from 'react';
import ReactDom from 'react-dom';
import config from '../../config';
import {Modal, Button} from 'react-bootstrap';

class StatisticItem extends React.Component {

	constructor(props) {
		super(props);
	}

	render() {
		const statisticItem = this.props.element;
		const statisticModal = this.props.element.modal;

		return (
			<li className="statistic__item" key={this.props.index}>
				<div className="statistic__icon" data-toggle="modal" data-target={statisticModal !== undefined ? "#" + statisticModal.modalId : null}>
						<span>
							<i className={"fas " + statisticItem.icon}></i>
						</span>
				</div>
				<div className="statistic__content">
					<ul className="statistic-info">
						{Object.keys(statisticItem.data).map((element, index) => {
							const value = statisticItem.data[element];
							return <li className="statistic-info__row" key={index}>
								<div className="statistic-info__key">{element}</div>
								<div className="statistic-info__value">{value}</div>
							</li>
						})}
					</ul>
				</div>

				{statisticModal !== undefined &&
				<div key={this.props.index} className="modal fade" id={statisticModal.modalId} tabIndex="-1" role="dialog" aria-labelledby={statisticModal.id + 'Label'} aria-hidden="true">
					<div className="modal-dialog" role="document">
						<div className="modal-content">
							<div className="modal-header">
								<h5 className="modal-title" id={statisticModal.id + 'Label'}>{statisticModal.title}</h5>
								<button type="button" className="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div className="modal-body">
								{Object.keys(statisticModal.data).map((rowCounter, rowIndex) => {
									const row = statisticModal.data[rowCounter];

									return Object.keys(row).map((key, index) => {
										const value = row[key];
										return <div key={index} className="d-flex flex-row align-items-center">
											<span className="w-25">{key}</span>
											<span className="w-25">{value}</span>
										</div>
									});

								})}
							</div>
							<div className="modal-footer">
								<button type="button" className="btn btn-secondary" data-dismiss="modal">Закрыть</button>
							</div>
						</div>
					</div>
				</div>
				}
			</li>
		);
	}
}

module.exports = StatisticItem;