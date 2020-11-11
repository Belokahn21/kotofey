<?php

/* @var $items array */
?>
<?php if ($items): ?>
    <div class="social-me-container">
        <div class="social-me__title">Следите за нами в сетях!</div>
        <ul class="social-me">
            <?php foreach ($items as $item) : ?>
                <li class="social-me__item"><a target="_blank" href="<?= $item['url']; ?>" class="social-me__link"><img alt="social" class="social-me__image" src="<?= $item['image']; ?>"/></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
