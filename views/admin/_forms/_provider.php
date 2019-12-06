<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
        <a class="nav-item nav-link" id="nav-preview-tab" data-toggle="tab" href="#nav-preview" role="tab" aria-controls="nav-preview" aria-selected="false">Краткий обзор</a>
        <a class="nav-item nav-link" id="nav-detail-tab" data-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false">Детальный обзор</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
			<?php echo $form->field($model, 'active')->radioList(['Нет', 'Да']); ?>
        </div>
        <div class="form-element">
			<?php echo $form->field($model, 'name')->textInput(); ?>
        </div>
        <div class="form-element">
			<?php echo $form->field($model, 'description')->textarea(); ?>
        </div>
        <div class="form-element">
			<?php echo $form->field($model, 'notes')->textarea(); ?>
        </div>

        <div class="form-element">
			<?php echo $form->field($model, 'link')->textInput(); ?>
        </div>
        <div class="form-element">
			<?php echo $form->field($model, 'image')->fileInput(); ?>
        </div>

        <div class="form-element">
			<?php echo $form->field($model, 'sort')->textInput(); ?>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-seo" role="tabpanel" aria-labelledby="nav-seo-tab">

    </div>
    <div class="tab-pane fade" id="nav-preview" role="tabpanel" aria-labelledby="nav-preview-tab">

    </div>
    <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">

    </div>
</div>