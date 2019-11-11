<?php
/* @var $user \app\models\entity\User */
$user = Yii::$app->user->identity;
?>
<?php $tooltip_html = ''; ?>
<?php $tooltip_html .= '<div class="container">'; ?>
<?php $attr = array('city', 'street', 'home', 'house'); ?>
<?php foreach ($attr as $attribute): ?>
    <?php if (isset($user->billing->{$attribute}) && !empty($user->billing->{$attribute})): ?>
        <?php $tooltip_html .= '<div class="row">'; ?>
        <?php $tooltip_html .= '<div class="col">' . $user->billing->getAttributeLabel($attribute) . '</div>'; ?>
        <?php $tooltip_html .= '<div class="col">' . $user->billing->{$attribute} . '</div>'; ?>
        <?php $tooltip_html .= '</div>'; ?>
    <?php endif; ?>
<?php endforeach; ?>
<?php $tooltip_html .= '</div>'; ?>
<div class="fast-buy-billing">
    <div class="container">
        <div class="row">
            <div class="col">
                <span class="fast-buy-user_billing" data-html="true" data-toggle="tooltip" data-placement="bottom" title='<?= $tooltip_html; ?>'>Плательщик</span>
                <span class="user_billing_change"><a href="/profile/">(Изменить)</a></span>
            </div>
        </div>
        <div class="row">
            <div class="col"><?= $user->email; ?></div>
            <div class="col phone_mask"><?= $user->phone; ?></div>
        </div>
    </div>
</div>