<?php

use app\models\entity\Geo;

/* @var $cities \app\models\entity\Geo[] */
?>
<div class="current-city">
    Ваш город: <span class="select-city">
                <span class="select-city__city"><?= Geo::findOne($_SESSION['city_id'])->name; ?></span>
                <span class="select-city__change" data-toggle="modal" data-target="#select-city-id">(изменить)</span>
            </span>
</div>
<!-- Modal -->
<div class="modal fade" id="select-city-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Выбрать свой город</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-city">
					<?php if ($cities): ?>
						<?php foreach ($cities as $city): ?>
                            <li class="city__item">
                                <a href="javascript:void(0);" class="city__item-link" data-city-id="<?= $city->id; ?>"><?= $city->name; ?></a>
                            </li>
						<?php endforeach; ?>
					<?php endif; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-main" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
