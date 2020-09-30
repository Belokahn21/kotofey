<?php
/* @var $logs \app\modules\logger\models\entity\Logger[] */

use yii\helpers\Html;

?>
<div class="modal fade" id="log-list" tabindex="-1" role="dialog" aria-labelledby="log-listLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="log-listLabel">Лог-лист сайта</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($logs): ?>
                    <div class="search-history">
                        <div class="search-history__item header-item">
                            <div class="search-history__ip">Uniq</div>
                            <div class="search-history__phrase">Запрос</div>
                            <div class="search-history__date">Дата</div>
                        </div>
                        <?php foreach ($logs as $log): ?>
                            <div class="search-history__item">
                                <div class="search-history__ip"><?= $log->uniqCode; ?></div>
                                <div class="search-history__phrase"><?= $log->message ?></div>
                                <div class="search-history__date"><?= date('d.m.Y', $log->created_at) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>