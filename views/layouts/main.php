<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\admin_panel\AdminPanel;
use app\models\entity\Category;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\models\entity\Basket;
use app\widgets\notification\Alert;
use app\widgets\Breadcrumbs;
use app\models\entity\SiteSettings;
use yii\widgets\ActiveForm;
use app\models\entity\Subscribe;
use app\widgets\search\SearchWidget;
use app\widgets\cookie\CookieWidget;
use yii\helpers\Url;
use app\models\services\CompareService;
use app\widgets\geo\GeoWidget;
use app\widgets\inspector\InspectorWidget;

AppAsset::register($this);

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="2lxEu3cepZijbEYmJ7zv4H8lhUKvX89GhMA_ujLklmk"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<?php if (YII_ENV == 'prod'): ?>
		<?php echo $this->render('include/head/yandex/metrika.php'); ?>
		<?php echo $this->render('include/head/yandex/webmaster.php'); ?>
		<?php echo $this->render('include/head/google/google_metrika.php'); ?>
		<?php echo $this->render('include/head/jivo.php'); ?>
	<?php endif; ?>
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php // NotifyWidget::widget(); ?>
<?= Alert::widget(); ?>
<?= AdminPanel::widget(); ?>
<?php // InspectorWidget::widget(); ?>
<div class="wrap-page">
    <div class="top-menu-wrap">
		<?= GeoWidget::widget(); ?>
        <ul class="top-menu">
            <li class="top-menu__item"><a class="top-menu__link" href="/delivery/">Доставка</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/payment/">Оплата</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/contacts/">Контакты</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/about/">О компании</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/support/" rel="nofollow">Поддержка</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="<?= Url::to(['site/vacancy']) ?>">Вакансии</a></li>
			<?php if (Yii::$app->user->isGuest): ?>
                <li class="top-menu__item"><a class="top-menu__link" href="/signin/">Войти на сайт</a></li>
			<?php else: ?>
                <li class="top-menu__item"><a class="top-menu__link" href="/profile/">Личный кабинет</a> (<a href="/logout/" class="top-menu__link">Выйти</a>)</li>
			<?php endif; ?>
        </ul>
    </div>
    <header class="header">
        <div class="logo-wrap">
            <a href="/" class="logo-link">
                <div class="logo__image-wrap">
                    <img src="/upload/images/_logo.png" alt="Интернет магазин зоотоваров с доставкой на дом" title="Интернет магазин зоотоваров с доставкой на дом">
                </div>
                <div class="logo-title-wrap">
                    <div class="logo-title"><?= SiteSettings::getValueByCode('site_logo'); ?></div>
                    <div class="logo-sub-title">интернет магазин зоотоваров</div>
                </div>
            </a>
        </div>

        <div class="search-wrap">
			<?= SearchWidget::widget(); ?>
        </div>

        <div class="contact-wrap">
            <div class="contact-block">
                <div class="contacts-reglament">Ежедневно с 08:00 до 23:00</div>
                <div class="phone-group">
                    <div class="contact-value phone_mask"><?= SiteSettings::getValueByCode('phone_1') ?></div>
                    <span>
                        <a rel="nofollow" onclick="ym(55089223, 'reachGoal', 'whatsapp');" href="whatsapp://send?phone=+79967026637">
                            <img class="contact-block__wa" src="/upload/images/whatsapp.png">
                        </a>
                    </span>
                </div>
            </div>
            <div class="contact-block">
                <div class="contacts-reglament">Информация по любым вопросам</div>
                <div class="contact-value">
                    <a href="mailto:<?= SiteSettings::getValueByCode('email'); ?>"><?= SiteSettings::getValueByCode('email'); ?></a>
                </div>
            </div>
        </div>

        <div class="compare-wrap">
            <a href="<?= Url::to(['site/compare']); ?>" class="compare">
                <i class="compare__icon fas fa-balance-scale"></i>
                <div class="compare__count">
                    <span><?= CompareService::count(); ?></span>
                </div>
            </a>
        </div>

        <div class="basket-wrap">
            <a href="/basket/">
                <div class="basket-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="basket">
                    <div>Корзина</div>
                    <div class="basket__summary">
						<?= Yii::$app->i18n->format("{n, plural, =0{Корзина пуста} =1{В крзине # товар} one{В крзине # товар} few{В корзине # товара} many{В корзине # товаров} other{Корзина пуста}}", ['n' => Basket::count()], 'ru_RU'); ?>
                    </div>
                </div>
            </a>
        </div>
    </header>

    <div class="menu-wrap">
        <div class="menu-controller" onclick="ym(55089223, 'reachGoal', 'full-catalog');">
            <i class="fas fa-bars  show-drop"></i>
        </div>

        <ul class="menu">
			<?php foreach (Category::find()->where(['parent' => 0])->all() as $category): ?>
                <li class="menu__item"><a href="<?= $category->getDetail(); ?>"><?= $category->name; ?></a></li>
			<?php endforeach; ?>
        </ul>
        <div class="full-menu-wrap hide">
            <ul class="full-menu">
				<?php foreach (Category::find()->where(['parent' => 0])->all() as $category): ?>
                    <li class="full-menu-item">
                        <a href="<?= $category->detail; ?>" class="full-menu-link">
                            <div class="full-menu-title">
                                <img src="/upload/<?= $category->image; ?>" class="full-menu-image">
								<?= $category->name; ?>
                            </div>
                        </a>
						<?php if ($sub_categories = Category::find()->where(['parent' => $category->id])->all()): ?>
                            <ul class="full-menu-sub">
								<?php foreach ($sub_categories as $sub_category): ?>
                                    <li class="full-menu-item-sub">
                                        <a href="<?= $sub_category->detail; ?>" class="full-menu-link"><?= $sub_category->name; ?></a>
										<?php if ($sub_sub_categories = Category::find()->where(['parent' => $sub_category->id])->all()): ?>
                                            <ul class="full-menu-sub">
												<?php foreach ($sub_sub_categories as $sub_sub_category): ?>
                                                    <li class="full-menu-item-sub">
                                                        <a href="<?= $sub_sub_category->detail; ?>" class="full-menu-link"><?= $sub_sub_category->name; ?></a>
                                                    </li>
												<?php endforeach; ?>
                                            </ul>
										<?php endif; ?>
                                    </li>
								<?php endforeach; ?>
                            </ul>
						<?php endif; ?>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="breadcrumb-wrap">
		<?= Breadcrumbs::widget([
			'homeLink' => ['label' => 'Главная', 'url' => '/'],
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]); ?>
    </div>
    <div class="page-content">
		<?= $content; ?>
    </div>
    <footer class="footer">
        <div class="footer-wrap">
            <div class="footer-block">
                <h3 class="footer-menu__title">Продукция</h3>
                <ul class="footer-menu">

					<?php foreach (Category::find()->where(['parent' => '0'])->all() as $category): ?>
                        <li class="footer-menu__item">
                            <a href="<?= $category->detail; ?>"><?= $category->name ?></a>
                        </li>
					<?php endforeach; ?>

                </ul>
            </div>
            <div class="footer-block">
                <div class="subscribe-wrap">
                    <h2 class="subscribe-title">Будьте всегда вкурсе!</h2>
                    <div class="subscribe-description">Получай уведомления о новых акциях</div>
					<?php
					$model = new Subscribe();
					if (Yii::$app->request->isPost) {
						if ($model->load(Yii::$app->request->post())) {
							if ($model->validate()) {
								if ($model->save()) {
									Alert::setSuccessNotify("Вы успешно подписались на рассылку!");
									return Yii::$app->controller->refresh();
								}
							}
						}
					}
					$form = ActiveForm::begin(['options' => ['class' => 'subscribe-form']]);
					echo $form->field($model, 'email', ['template' => "{label}\n{input}"])->textInput([
						'class' => 'subscribe-form__input',
						'placeholder' => 'Ваш Email'
					])->label(false);
					echo Html::submitButton('Подписаться', ['class' => 'subscribe-form__submit']);
					ActiveForm::end();
					?>
                </div>
            </div>
            <div class="footer-block">
                <h3 class="footer-menu__title">Навигация</h3>
                <ul class="footer-menu">
                    <li class="footer-menu__item"><a href="/delivery/">Доставка</a></li>
                    <li class="footer-menu__item"><a href="/payment/">Оплата</a></li>
                    <li class="footer-menu__item"><a href="/contacts/">Контакты</a></li>
                    <li class="footer-menu__item"><a href="/about/">О компании</a></li>
                    <li class="footer-menu__item"><a href="/support/" rel="nofollow">Поддержка</a></li>
                    <li class="footer-menu__item"><a href="/vacancy/">Вакансии</a></li>
                    <li class="footer-menu__item"><a href="/profile/" rel="nofollow">Личный кабинет</a></li>
                    <li class="footer-menu__item"><a href="/news/">Новости</a></li>
                </ul>
            </div>
            <div class="footer-block">
                <ul class="footer-info">
                    <li class="footer-info__item footer-current-city">
						<?= GeoWidget::widget([
							'template' => 'footer'
						]); ?>
                    </li>
                    <li class="footer-info__item time-work">
                        Ежедневно с 08.00 до 23.00
                        <div><span class="phone_mask"><?= SiteSettings::getValueByCode('phone_1') ?></span></div>
                    </li>
                    <li class="footer-info__item contact-email">
                        Наша электронная почта
                        <div><?= SiteSettings::getValueByCode('email') ?></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-socials-wrap">
            <ul class="footer-socials">
                <li class="footer-socials__item">
                    <a rel="nofollow" href="<?= SiteSettings::getValueByCode('insta_link'); ?>" target="_blank" class="footer-socials__item__inst">
                        <i class="fab fa-instagram"></i>
                    </a>
                </li>
                <li class="footer-socials__item">
                    <a rel="nofollow" href="<?= SiteSettings::getValueByCode('vk_link'); ?>" target="_blank" class="footer-socials__item__vk">
                        <i class="fab fa-vk"></i>
                    </a>
                </li>
                <li class="footer-socials__item">
                    <a rel="nofollow" href="<?= SiteSettings::getValueByCode('ok_ru'); ?>" target="_blank" class="footer-socials__item__ok">
                        <i class="fab fa-odnoklassniki-square"></i>
                    </a>
                </li>
                <li class="footer-socials__item">
                    <a rel="nofollow" href="<?= SiteSettings::getValueByCode('twit'); ?>" target="_blank" class="footer-socials__item__twit">
                        <i class="fab fa-twitter-square"></i>
                    </a>
                </li>
                <li class="footer-socials__item">
                    <div class="copyring"><?= SiteSettings::getValueByCode('site_logo') ?> - <?= date("Y"); ?> ©</div>
                </li>
            </ul>
        </div>
    </footer>
</div>

<div class="requisites-wrap">
    <ul class="requisites">
        <li class="requisites___item">ИП Васин К.В.</li>
        <li class="requisites___item">ОГРН: 319222500105168</li>
        <li class="requisites___item">ИНН: 222261129226</li>
        <li class="requisites___item"><a rel="nofollow" href="https://www.rusprofile.ru/ip/319222500105168" target="_blank">(Проверить)</a></li>
    </ul>
</div>

<?= CookieWidget::widget(); ?>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
