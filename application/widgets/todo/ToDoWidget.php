<?php

namespace app\widgets\todo;

use app\modules\todo\models\entity\TodoSearchForm;
use app\models\tool\System;
use app\modules\todo\models\entity\TodoList;
use app\widgets\notification\Alert;
use yii\helpers\Url;
use yii\web\HttpException;

class ToDoWidget extends \yii\base\Widget
{
	public function run()
	{
		$model = new TodoList();
		$searchModel = new TodoSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (!empty(\Yii::$app->request->get('id')) && \Yii::$app->request->get('action') == 'delete' && \Yii::$app->request->get('target') == 'todo') {
			$entity = TodoList::findOne(\Yii::$app->request->get('id'));
			if ($entity) {
				if ($entity->delete()) {
					Alert::setSuccessNotify('Задание удалено');
					\Yii::$app->controller->redirect(Url::to(['admin/index']));
					return '';
				}
			}
		}

		if (\Yii::$app->request->get('id')) {
			$model = TodoList::findOne(\Yii::$app->request->get('id'));

			if (!$model) {
				throw new HttpException(404, 'Задание не найдено');
			}

			if (\Yii::$app->request->isPost) {
				if ($model->edit()) {
					Alert::setSuccessNotify('Задача успешно обновлена');
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
				Alert::setSuccessNotify('Задача успешно создана');
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