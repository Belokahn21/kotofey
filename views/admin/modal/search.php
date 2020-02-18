<?php
/* @var $last_search \app\models\entity\SearchQuery[] */
?>
<div class="modal fade" id="show-search-stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Что ищут посетители?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="search-info">
                    <li class="search-info__item">
                        <div class="search-info__item-date">Дата</div>
                        <div class="search-info__item-user">Посетитель</div>
                        <div class="search-info__item-query">Запрос</div>
                        <div class="search-info__item-count">Количество</div>
                        <div class="search-info__item-ip">IP</div>
                    </li>
					<?php $count_find_by_one_ip = array(); ?>
					<?php foreach ($last_search as $item): ?>
						<?php $count_find_by_one_ip[$item->ip] = $item->ip; ?>
                        <li class="search-info__item">
                            <div class="search-info__item-date"><?= date('d.m.Y', $item->created_at); ?></div>
                            <div class="search-info__item-user">
								<?php if ($item->user): ?>
									<?= $item->user->email; ?>
								<?php endif; ?>
                            </div>
                            <div class="search-info__item-query"><?= $item->text; ?></div>
                            <div class="search-info__item-count"><?= $item->count_find; ?></div>
                            <div class="search-info__item-ip"><?= $item->ip; ?> (<?= count($count_find_by_one_ip[$item->ip]); ?>)</div>
                        </li>
					<?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>