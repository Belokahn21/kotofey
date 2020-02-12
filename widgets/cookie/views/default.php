<?php

use app\models\tool\System;

?>
<div class="cookie">
    <div class="cookie__text">
        Наш сайт <strong><?= System::domain(); ?></strong> использует файлы cookie для улучшение взаимодействия пользователя с сайтом
    </div>

    <div class="cookie__group">
        <div class="cookie__button-wrap">
            <button class="cookie__button">
                <span>Закрыть</span>
            </button>
        </div>
        <a href="javascript:void(0);" class="cookie__more">Подробнее</a>
    </div>
</div>