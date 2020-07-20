<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<?= $form->field($model, 'active')->checkbox() ?>
		<?= $form->field($model, 'name') ?>
		<?= $form->field($model, 'description')->textarea(); ?>
		<?php if ($model->image): ?>
            <img src="/upload/<?= $model->image; ?>">
		<?php endif; ?>
		<?= $form->field($model, 'image')->fileInput(); ?>
    </div>
</div>
