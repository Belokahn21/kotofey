<?php

use yii\helpers\Html;
use app\modules\catalog\models\entity\Offers;

?>
<div class="modal fade" id="product-stat" tabindex="-1" role="dialog" aria-labelledby="product-statLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="product-statLabel">Товарные позиции</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ожидание поступления</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Без поставщика</a>
                    </li>
<!--                    <li class="nav-item" role="presentation">-->
<!--                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>-->
<!--                    </li>-->
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <?php foreach (Offers::find()->where(['status_id' => Offers::STATUS_WAIT])->orderBy(['vendor_id' => SORT_DESC])->all() as $product): ?>
                            <div>
                                <?= Html::a($product->name, \yii\helpers\Url::to(['/admin/catalog/product-backend/update', 'id' => $product->id])); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <?php foreach (Offers::find()->where(['vendor_id' => null])->all() as $product): ?>
                            <div>
                                <?= Html::a($product->name, \yii\helpers\Url::to(['/admin/catalog/product-backend/update', 'id' => $product->id])); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
<!--                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>-->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>