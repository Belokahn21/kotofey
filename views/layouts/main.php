<?

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\admin_panel\AdminPanel;
use app\models\entity\Category;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\models\entity\Basket;
use app\widgets\notification\Notify;
use app\widgets\Breadcrumbs;
use app\models\entity\SiteSettings;
use app\models\tool\Currency;
use yii\widgets\ActiveForm;
use app\models\entity\Subscribe;
use app\models\entity\Search;
use app\widgets\search\SearchWidget;

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
    <? endif; ?>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <? $this->head() ?>
</head>
<body>
<? $this->beginBody() ?>

<?= Notify::widget(); ?>
<?= AdminPanel::widget(); ?>

<div class="wrap-page">
    <div class="top-menu-wrap">
        <div class="current-city">
            Ваш город: <span>Барнаул</span>
        </div>
        <ul class="top-menu">
            <li class="top-menu__item"><a class="top-menu__link" href="/delivery/">Доставка</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/payment/">Оплата</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/contacts/">Контакты</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/about/">О компании</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/support/">Поддержка</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/">Вакансии</a></li>
            <li class="top-menu__item"><a class="top-menu__link" href="/profile/">Личный кабинет</a> <?= (Yii::$app->user->isGuest ? '' : ' (<a href="/logout/" class="top-menu__link">Выйти</a>)'); ?></li>
        </ul>
    </div>
    <header class="header">
        <div class="logo-wrap">
            <a href="/" class="logo-link">
                <div class="logo__image-wrap">
                    <img src="/web/upload/images/_logo.png" alt="Интернет магазин зоотоваров с доставкой на дом" title="Интернет магазин зоотоваров с доставкой на дом">
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
                        <a href="whatsapp://send?phone=<?= SiteSettings::getValueByCode('phone_1') ?>">
                            <img class="contact-block__wa" src="/web/upload/images/whatsapp.png">
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
        <div class="menu-controller">
            <i class="fas fa-bars  show-drop"></i>
        </div>

        <ul class="menu">
            <? foreach (Category::find()->where(['parent' => 0])->all() as $category): ?>
                <li class="menu__item"><a href="<?= $category->getDetail(); ?>"><?= $category->name; ?></a></li>
            <? endforeach; ?>
        </ul>
        <div class="full-menu-wrap hide">
            <ul class="full-menu">
                <?php foreach (Category::find()->where(['parent' => 0])->all() as $category): ?>
                    <li class="full-menu-item">
                        <a href="" class="full-menu-link">
                            <div class="full-menu-title">
                                <img src="/web/upload/<?= $category->image; ?>" class="full-menu-image">
                                <?= $category->name; ?>
                            </div>
                        </a>
                        <?php if ($sub_categories = Category::find()->where(['parent' => $category->id])->all()): ?>
                            <ul class="full-menu-sub">
                                <?php foreach ($sub_categories as $sub_category): ?>
                                    <li class="full-menu-item-sub">
                                        <a href="" class="full-menu-link"><?= $sub_category->name; ?></a>
                                        <?php if ($sub_sub_categories = Category::find()->where(['parent' => $sub_category->id])->all()): ?>
                                            <ul class="full-menu-sub">
                                                <?php foreach ($sub_sub_categories as $sub_sub_category): ?>
                                                    <li class="full-menu-item-sub">
                                                        <a href="" class="full-menu-link"><?= $sub_sub_category->name; ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <? endforeach; ?>
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

                    <? foreach (Category::find()->where(['parent' => '0'])->all() as $category): ?>
                        <li class="footer-menu__item">
                            <a href="<?= $category->detail; ?>"><?= $category->name ?></a>
                        </li>
                    <? endforeach; ?>

                </ul>
            </div>
            <div class="footer-block">
                <div class="subscribe-wrap">
                    <h2 class="subscribe-title">Будьте всегда вкурсе!</h2>
                    <div class="subscribe-description">Получай уведомления о новых акциях</div>
                    <?
                    $model = new Subscribe();
                    if (Yii::$app->request->isPost) {
                        if ($model->load(Yii::$app->request->post())) {
                            if ($model->validate()) {
                                if ($model->save()) {
                                    Notify::setSuccessNotify("Вы успешно подписались на рассылку!");
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
                    <li class="footer-menu__item"><a href="/support/">Поддержка</a></li>
                    <li class="footer-menu__item"><a href="/vacancy/">Вакансии</a></li>
                    <li class="footer-menu__item"><a href="/profile/">Личный кабинет</a></li>
                    <li class="footer-menu__item"><a href="/news/">Новости</a></li>
                </ul>
            </div>
            <div class="footer-block">
                <ul class="footer-info">
                    <li class="footer-info__item footer-current-city">
                        Ваш город
                        <div>Барнаул</div>
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

<? $this->endBody() ?>
</body>
</html>
<? $this->endPage() ?>
