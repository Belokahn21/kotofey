<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

?>
<div class="todo">
    <h2 class="todo__title">
        Задачи
        <? if ($init === true): ?>
            <span><a href="?run=y"><i class="fas fa-play"></i></a></span>
        <? else: ?>
            <?
            Modal::begin([
                'header' => '<h2>Новое задание</h2>',
                'toggleButton' => [
                    'label' => '<i class="fas fa-plus-circle"></i>',
                    'tag' => 'button',
                    'class' => 'todo-btn-new',
                ],
            ]);
            ?>
            <? $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'description')->textarea(); ?>
            <?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
            <? ActiveForm::end() ?>
            <? Modal::end(); ?>
        <? endif; ?>
    </h2>
    <table class="todo-items">
        <? if (!empty($items)): ?>
            <? /* @var $item \app\models\entity\TodoList*/ ?>
            <? foreach ($items as $item): ?>
                <tr class="todo-item">
                    <td class="todo-item__time"><?= date("[d.m.Y]", $item->created_at); ?></td>
                    <td class="todo-item__name"><?= $item->name; ?></td>
                    <td class="todo-item__close" data-id="<?= $item->id; ?>">
                        <? if ($item->close): ?>
                            <i class="fas fa-lock"></i>
                        <? else: ?>
                            <i class="fas fa-lock-open"></i>
                        <? endif; ?>
                    </td>
                    <td class="todo-item__remove" data-id="<?= $item->id; ?>">
                        <i class="fas fa-trash-alt"></i>
                    </td>
                </tr>
            <? endforeach; ?>
        <? endif; ?>
    </table>
</div>
