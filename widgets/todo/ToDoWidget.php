<?

namespace app\widgets\todo;

use app\models\tool\System;
use app\models\entity\TodoList;
use app\widgets\notification\Notify;

class ToDoWidget extends \yii\base\Widget
{
	public function run()
	{
		$model = new TodoList();
		$items = TodoList::find()->orderBy(['created_at' => SORT_DESC])->where(['close' => false, 'user_id' => \Yii::$app->user->id])->all();

		if (\Yii::$app->request->isPost) {
			if ($model->create()) {
				Notify::setSuccessNotify('Задача успешно создана');
				\Yii::$app->controller->refresh();
			}
		}

		return $this->render('default', [
			'items' => $items,
			'model' => $model,
		]);
	}
}