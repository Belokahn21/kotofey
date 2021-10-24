<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="panel-menu">
    <div class="panel-menu-item">
        <a href="/" class="panel-menu-item__link">
            На сайт
        </a>
    </div>
    <div class="panel-menu-item">
        <a href="/admin/" class="panel-menu-item__link">
            Рабочий стол
        </a>
    </div>
    <?php foreach (Yii::$app->getModules() as $moduleId => $data): ?>
        <?php $module = Yii::$app->getModule($moduleId); ?>
        <?php if ($module): ?>
            <?php if (method_exists($module, 'menuIndex')): ?>
                <div class="panel-menu-item">
                    <?php try { ?>
                        <?= Html::a($module->name, Url::to(['/admin/site/settings-backend/module', 'id' => $moduleId]), ['class' => 'panel-menu-item__link']); ?>
                    <? } catch (\yii\base\UnknownPropertyException $exception) { ?>
                        <?= Html::a("Без названия", Url::to(['/admin/site/settings-backend/module', 'id' => $moduleId]), ['class' => 'panel-menu-item__link']); ?>
                    <?php } ?>


                    <?php if ($items = $module->menuIndex()): ?>
                        <div class="panel-menu-sub">
                            <?php foreach ($items as $item): ?>
                                <div class="panel-menu-sub-item"><a class="panel-menu-sub-item__link" href="<?= $item['url']; ?>"><?= $item['name']; ?></a></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
