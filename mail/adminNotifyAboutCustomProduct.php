<style type="text/css">
    .contacts {
        list-style: none;
        margin: 0;
        padding: 0;
    }
</style>
Приятные новости! Клиенту нужен предмет:
<br/>
<hr/>

<? if (!empty($description)): ?>
    <?= $description; ?>
<? else: ?>
    <ul>
        <li>Тип предмета: <?= $type; ?></li>
        <li>Кожа: <?= $leather; ?></li>
        <li>Цвет: <?= $color; ?></li>
    </ul>
<? endif; ?>

<hr/>
<br/>
Контактные данные
<ul class="contacts">
    <li>E-Mail: <?= $email; ?></li>
    <li>Телефон: <?= $phone; ?></li>
</ul>