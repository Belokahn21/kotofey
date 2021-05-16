<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\pets\models\helpers\PetsHelper;

/* @var $models \app\modules\pets\models\entity\Pets[] */
?>
<?php if ($models): ?>
    <div class="pet-list">
        <?php foreach ($models as $model): ?>
            <div class="pet-list__item">
                <div class="pet-list__avatar">
                    <a href="<?= PetsHelper::getImage($model); ?>" data-lightbox="roadtrip">
                        <img alt="<?= $model->name; ?>" src="<?= PetsHelper::getImage($model); ?>">
                    </a>
                </div>
                <div class="pet-list__data">
                    <div class="pet-list__name">
                        <?= $model->name; ?>
                    </div>
                    <div class="pet-list__date">
                        Дата рождения: <?= date('d.m.Y', $model->created_at); ?>
                    </div>
                </div>
                <div class="pet-list__controls">
                    <?= Html::a(Html::tag('i', null, ['class' => 'fas fa-edit']), "/pet/update/$model->id/"); ?>
                    <?= Html::a(Html::tag('i', null, ['class' => 'fas fa-trash-alt']), "/pet/delete/$model->id/"); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
