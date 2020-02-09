<?php

use app\models\entity\ProductPropertiesValues;

?>
<?php if ($this->beginCache('providers-cache', ['duration' => 3600 * 24 * 7])): ?>
    <div class="container-fluid providers-wrap">
        <h1 class="homepage-providers__title">В продаже корма для животных известных производителей зоотоваров</h1>
        <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">
            <a class="btn-nav" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
            <div class="carousel-inner" role="listbox">
                <?php foreach ($providers->batch(6) as $iterI => $batchProviders): ?>
                    <div class="carousel-item<?= ($iterI == 1 ? ' active' : ''); ?>">
                        <div class="row homepage-providers">
                            <?php foreach ($batchProviders as $iter => $provider): ?>
                                <div class="col-2<?= ($iter > 1 ? ' clearfix d-none d-md-block' : ''); ?>">
                                    <div class="card">
                                        <a class="homepage-providers__link" href="<?= $provider->link; ?>">
                                            <img class="homepage-providers__image" src="/upload/<?= $provider->image; ?>" title="<?= $provider->name; ?>" alt="<?= $provider->name; ?>">
                                            <div class="homepage-providers__detail">К ассортимену (<?= ProductPropertiesValues::find()->where(['value' => $provider->id])->count('product_id'); ?>)</div>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="btn-nav" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
        </div>
    </div>
    <?php $this->endCache(); endif; ?>
