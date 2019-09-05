<div class="site-reviews">
    <h2 class="site-reviews__title">Отзывы о нас</h2>
    <a href="/reviews/" class="btn-main site-reviews__new">Оставить отзыв</a>
    <?if($reviews):?>
        <table class="site-reviews-list">
            <? foreach ($reviews as $review): ?>
                <tr class="site-reviews__item">
                    <td class="site-reviews__item-avatar">
                        <a href="/profile/<?= $review->user->id; ?>/">
                            <img src="<?= (!empty($review->user->avatar)) ? $review->user->avatar : "/web/upload/images/man.png"; ?>">
                        </a>
                        <div class="site-reviews__item-time"><?= date("d.m.Y", $review->created_at); ?></div>
                    </td>
                    <td>
                        <div class="site-reviews__content">
                            <?= $review->user->name; ?> пишет: <?= substr($review->text, 0, 100) . ((strlen($review->text) < 100) ?: " <a href='/reviews/' class='site-reviews__detail-link'>читать дальше</a>"); ?>
                        </div>
                    </td>
                </tr>
            <? endforeach; ?>
        </table>
    <? else: ?>
        <div class="clearfix"></div>
        <div style="text-align: justify; color: #FF1A4A;">
            Будь первым, кто оставит о нас своё мнение!!!
        </div>
    <? endif; ?>
</div>
