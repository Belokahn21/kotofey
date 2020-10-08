<?php

/* @var $this yii\web\View
 * @var $console \app\modules\site\models\forms\ConsoleForm
 */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Title::showTitle("Консоль");
?>
<section class="payment">
    <h1 class="title">Консоль</h1>
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => '']
    ]); ?>
    <?= $form->field($console, 'code')->textarea(['rows' => 10])->label(false); ?>
    <?= Html::submitButton('Выполнить', ['class' => 'btn-main']) ?>
    <?php if ($console->output): ?>
        <p>Вывод:</p>
        <div>
            <?= $console->output; ?>
        </div>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</section>