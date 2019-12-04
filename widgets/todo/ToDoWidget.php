<?php

namespace app\widgets\todo;

use app\models\search\TodoSearchForm;
use app\models\tool\System;
use app\models\entity\TodoList;
use app\widgets\notification\Notify;
use yii\helpers\Url;

class ToDoWidget extends \yii\base\Widget
{
	public function run()
	{
		$model = new TodoList();
		$searchModel = new TodoSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->get('action') == 'delete' && \Yii::$app->request->get('target') == 'todo') {
			$entity = TodoList::findOne(\Yii::$app->request->get('id'));
			if ($entity) {
				if ($entity->delete()) {
					Notify::setSuccessNotify('Задание удалено');
					\Yii::$app->controller->redirect(Url::to(['admin/index']));
				}
			}
		}

		if (\Yii::$app->request->get('id')) {
			$model = TodoList::findOne(\Yii::$app->request->get('id'));

			if (\Yii::$app->request->isPost) {
				if ($model->edit()) {
					Notify::setSuccessNotify('Задача успешно обновлена');
					\Yii::$app->controller->redirect(Url::to(['admin/index']));
				}
			}


			return $this->render('default', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'model' => $model,
			]);
		}

		if (\Yii::$app->request->isPost) {
			if ($model->create()) {
				Notify::setSuccessNotify('Задача успешно создана');
				\Yii::$app->controller->refresh();
			}
		}

		return $this->render('default', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'model' => $model,
		]);
	}
}