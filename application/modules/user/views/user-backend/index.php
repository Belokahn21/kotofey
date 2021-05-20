<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\user\models\entity\UserSex;
use app\modules\bonus\models\entity\UserBonus;
use app\modules\user\models\entity\UsersReferal;
use app\modules\order\models\entity\Order;

/* @var $model \app\modules\user\models\entity\User
 * @var $groups \app\modules\rbac\models\entity\AuthItem[]
 */

$this->title = Title::show("Пользователи"); ?>
    <section>
        <div class="title-group">
            <h1 class="title">Пользователи</h1>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $this->render('_form', [
            'model' => $model,
            'form' => $form,
            'groups' => $groups
        ]); ?>
        <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    </section>
    <h1>Список пользователей</h1>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Пользователи отсутствуют',
    'columns' => [
        'id',
        'phone',
        'email',
        [
            'label' => 'Реферальный код',
            'format' => 'raw',
            'value' => function ($model) {
                if ($referal = UsersReferal::findOneByUserId($model->id)) {
                    return $referal->key;
                }
            }
        ],
        [
            'label' => 'Количество заказов',
            'value' => function ($model) {
                return Order::find()->where(['phone' => $model->phone])->count();
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-sign-in-alt"></i>', Url::to(["auth", 'id' => $model->id]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["delete", 'id' => $key]));
                },
            ]
        ],
    ],
]); ?>