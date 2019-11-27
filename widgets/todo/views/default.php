<?php

/* @var $model \app\models\entity\TodoList */
/* @var $items \app\models\entity\TodoList[] */

/* @var $this \yii\web\View */

use yii\helpers\Url;

?>
<?= $this->render('include/modal/modal-form', [
    'model' => $model
]); ?>
<div class="todo-wrap">
    <div class="todo__title">Список заданий <i class="fas fa-plus-square" data-toggle="modal" data-target="#new-task"></i></div>
    <?php if ($items): ?>
        <ul class="todo-list">
            <li class="todo-list__item header">
                <div class="todo-list__item-close">Закрыто</div>
                <div class="todo-list__item-date">Дата</div>
                <div class="todo-list__item-title">Заголовок</div>
                <div class="todo-list__item-description">Описание</div>
                <div class="todo-list__item-user">Кому назначена</div>
            </li>
            <?php foreach ($items as $item): ?>
                <li class="todo-list__item">
                    <div class="todo-list__item-close"><?= ($item->close == 0 ? 'Отыркто' : 'Закрыто'); ?></div>
                    <div class="todo-list__item-date"><?= date('d.m.Y', $item->created_at); ?></div>
                    <div class="todo-list__item-title"><?= $item->name; ?></div>
                    <div class="todo-list__item-description"><?= $item->description; ?></div>
                    <div class="todo-list__item-user">
                        <a href="<?= Url::to(['admin/user', 'id' => $item->user_id]) ?>">
                            <?= $item->user->email; ?>
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
