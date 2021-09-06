<?php

$html = file_get_contents('https://toptara.ru/katalog/plastikovyie-yashhiki/');

$html = htmlspecialchars($html);

\app\modules\site\models\tools\Debug::p($html);