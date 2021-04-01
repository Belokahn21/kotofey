<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<h2>Управление</h2>
<div class="modules">
    <?php foreach (Yii::$app->getModules() as $moduleId => $data): ?>
        <?php $module = Yii::$app->getModule($moduleId); ?>
        <?php if ($module): ?>
            <?php if (method_exists($module, 'menuIndex')): ?>
                <div class="modules__item">
                    <div class="modules__name">
                        <?php
                        try {
                            echo $module->name;
                        } catch (\yii\base\UnknownPropertyException $exception) {
                            echo "Без названия";
                        } ?>
                        <?= Html::a(Html::tag('i', '', ['class' => 'fas fa-cogs']), Url::to(['/admin/site/settings-backend/module', 'id' => $moduleId])); ?>
                    </div>
                    <ul class="module-menu">
                        <?php if ($items = $module->menuIndex()): ?>
                            <?php foreach ($items as $item): ?>
                                <li class="module-menu__item"><a class="module-menu__link" href="<?= $item['url']; ?>"><?= $item['name']; ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
