<?php

use app\models\tool\seo\Title;
use app\models\entity\Order;
use yii\helpers\Url;

/* @var $models \app\models\entity\user\Billing[] */

$this->title = Title::showTitle("Личный кабинет");
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => '/profile/'];
$this->params['breadcrumbs'][] = ['label' => 'Адреса доставки', 'url' => '/billing/'];
?>
<h1>Управлеие адресами доставки</h1>
<?php if ($models): ?>
    <div class="billing-wrap">
        <ul class="billing">
			<?php foreach ($models as $model): ?>
                <li class="billing__item">
                    <div class="billing__title">
                        <div><?= ($model->getName()); ?> <a class="billing__edit" href="<?= Url::to(['site/billing', 'id' => $model->id]); ?>">(Редактировать)</a></div>
                        <div>
							<?php if ($model->is_main): ?>
                                <i class="fas fa-check-circle" data-toggle="tooltip" data-placement="right" title="Адрес назначен как основной"></i>
							<?php else: ?>
                                <i class="far fa-check-circle"></i>
							<?php endif; ?>
                        </div>
                    </div>
                    <ul class="billing-info">
                        <li class="billing-info__item">
                            <div class="key">Город</div>
                            <div class="value"><?= $model->city; ?></div>
                        </li>
                        <li class="billing-info__item">
                            <div class="key">Улица</div>
                            <div class="value"><?= $model->street; ?></div>
                        </li>
                        <li class="billing-info__item">
                            <div class="key">Дом</div>
                            <div class="value"><?= $model->home; ?></div>
                        </li>
                        <li class="billing-info__item">
                            <div class="key">Квартира</div>
                            <div class="value"><?= $model->house; ?></div>
                        </li>
                    </ul>
                </li>
			<?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
