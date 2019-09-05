<?

/* @var $this yii\web\View */
/* @var $model \app\models\rbac\AuthItem */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle("Управление группами");
?>
    <section class="group-form">
        <div class="group-form-wrap">
            <h1 class="title">Группы</h1>
            <? $form = ActiveForm::begin(); ?>
            <div class="tabs-container">
                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-1">Основное</li>
                </ul>
                <div id="tab-1" class="tab-content current">
                    <?= $form->field($model, 'name')->textInput(); ?>
                    <?= $form->field($model, 'parent')->dropDownList(\yii\helpers\ArrayHelper::map(Yii::$app->getAuthManager()->getRoles(), 'name', 'name'), ['prompt' => 'Родительская группа']); ?>
                    <?= $form->field($model, 'description')->textInput(); ?>
                </div>
            </div>
            <?= Html::submitButton('Добавить'); ?>
            <? ActiveForm::end(); ?>
        </div>
        <div class="list-groups">
            <? $auth = \Yii::$app->authManager; ?>
            <? foreach(Yii::$app->getAuthManager()->getRoles() as &$role): ?>
                <div class="group-item">
                    <h4><?= $role->name; ?></h4>
                    <?
                    $childs = $auth->getChildRoles($role->name);
                    array_shift($childs);
                    ?>
                    <ul class="list-childs">
                        <?
                        foreach ($childs as $child){
                         ?>
                            <li class="list-childs__item"><?=$child->name?></li>
                        <?
                        }
                        ?>
                    </ul>
                </div>
            <? endforeach; ?>
        </div>
    </section>
    <h2 class="title">Список групп</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Товары отсутствуют',
    'columns' => [
        [
            'attribute' => 'name',
        ],
        [
            'attribute' => 'description',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/group/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/group/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>