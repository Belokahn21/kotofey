<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\entity\UserSex;

/* @var $model \app\models\entity\User */

$this->title = Title::showTitle("Пользователи"); ?>
    <section>
        <h1 class="title">Пользователи</h1>
        <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
                <li class="tab-link" data-tab="tab-2">Аватар</li>
                <li class="tab-link" data-tab="tab-3">Разрешения</li>
                <li class="tab-link" data-tab="tab-4">Расширенное</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?= $form->field($model, 'email'); ?>
                <?//= $form->field($model, 'phone'); ?>
                <?= $form->field($model, 'new_password')->passwordInput(); ?>
            </div>
            <div id="tab-2" class="tab-content">
                <?= $form->field($model, 'avatarFile')->fileInput(); ?>
            </div>
            <div id="tab-3" class="tab-content">
                <div class="left-col">
                    <h2>Группы</h2>
                    <?= $form->field($model, 'roleName')->dropDownList(ArrayHelper::map($groups, 'name', 'name'),['prompt' => 'Группа']); ?>
                </div>
                <div class="right-col">
                    <h2>Разрешения</h2>
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="tab-4" class="tab-content">
                <?= $form->field($model, 'first_name'); ?>
                <?= $form->field($model, 'name'); ?>
                <?= $form->field($model, 'last_name'); ?>
                <?= $form->field($model, 'birthday')->textInput(); ?>
                <?= $form->field($model, 'sex')->dropDownList(ArrayHelper::map(UserSex::find()->all(), 'id', 'name'),['prompt' => 'Пол']); ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?= Html::submitButton('Добавить'); ?>
        <? ActiveForm::end(); ?>
    </section>
    <h1>Список заказов</h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Пользователи отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'email',
        ],
        [
            'attribute' => 'vk_uid',
            'label' => 'Страница Вконтакте',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->vk_uid) {
                    return Html::a("Перейти", '//vk.com/id' . $model->vk_uid, ['target' => '_blank']);
                }
            },
        ],
        [
            'attribute' => 'sex',
            'value' => function ($model) {
                return UserSex::findOne($model->sex)->name;
            }
        ],
        [
            'attribute' => 'first_name',
        ],
        [
            'attribute' => 'name',
        ],
        [
            'attribute' => 'last_name',
        ],
        [
            'attribute' => 'role',
            'label' => 'Группа',
            'value' => function ($model) {
                return rand();
            }
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date("d.m.Y", $model->created_at);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/user/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/user/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>