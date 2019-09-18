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

AppAsset::register($this);

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(55089223, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/55089223" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="2lxEu3cepZijbEYmJ7zv4H8lhUKvX89GhMA_ujLklmk"/>
    <meta name="yandex-verification" content="6defe1065025a471" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <? $this->head() ?>
    <script src="//code.jivosite.com/widget.js" data-jv-id="NPe6xOUckS" async></script>
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
            <li class="top-menu__item"><a href="/delivery/">Доставка</a></li>
            <li class="top-menu__item"><a href="/payment/">Оплата</a></li>
            <li class="top-menu__item"><a href="/contacts/">Контакты</a></li>
            <li class="top-menu__item"><a href="/about/">О компании</a></li>
            <li class="top-menu__item"><a href="/support/">Поддержка</a></li>
            <li class="top-menu__item"><a href="/">Вакансии</a></li>
            <li class="top-menu__item"><a href="/profile/">Личный кабинет</a></li>
        </ul>
    </div>
    <header class="header">
        <div class="logo-wrap">
            <a href="/">
                <img src="/web/upload/images/_logo.png" alt="Интернет магазин аксессуаров из натуральной кожи" title="Интернет магазин аксессуаров из натуральной кожи" class="logo__image">
                <div class="logo-title-wrap">
                    <h1 class="logo__title"><?= SiteSettings::getValueByCode('site_logo'); ?></h1>
                    <div>интернент магазин зоотоваров</div>
                </div>
            </a>
        </div>
        <div class="search-wrap">

            <?= \app\widgets\search\SearchWidget::widget(); ?>

        </div>
        <div class="contact-wrap">
            Ежедневно с 08:00 до 23:00
            <div><span class="phone_mask"><?= SiteSettings::getValueByCode('phone_1') ?></span> <span><a href="tel:<?= SiteSettings::getValueByCode('phone_1') ?>"><img style="display: inline;" width="20" src="https://image.flaticon.com/icons/svg/220/220236.svg"></a></span>
            </div>
        </div>
        <div class="contact-wrap">
            Информация по любым вопросам
            <div>
                <a href="mailto:<?= SiteSettings::getValueByCode('email') ?>"><?= SiteSettings::getValueByCode('email') ?></a>
            </div>
        </div>
        <div class="basket-wrap">
            <a href="/basket/">
                <div class="basket-image">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <div class="basket-title">
                    Корзина
                    <div class="basket-count"><?= Yii::$app->i18n->format("{n, plural, =0{Корзина пуста} =1{В крзине - # товар} one{В крзине - # товар} few{В корзине - # товара} many{В корзине - # товаров} other{dev -}}",
                            ['n' => Basket::count()], 'ru_RU'); ?></div>
                </div>
            </a>
            <? if (count((new Basket())->listItems()) > 0): ?>
                <div class="slide-down-basket">
                    <ul>
                        <? foreach ((new Basket())->listItems() as $item): ?>
                            <li class="slide-down-basket__item">
                                <img src="<?= $item->product->image ?>">
                                <a class="slide-down-basket__item-name" href=""><?= $item->product->name ?></a>
                                <div class="slide-down-basket__item-price"><?= $price = $item->product->price; ?><?= (new Currency())->show(); ?></div>
                                <div class="slide-down-basket__item-count"><?= $count = $item->count; ?></div>
                                <div class="slide-down-basket__item-summ"><?= $summ = $price * $count; ?><?= (new Currency())->show(); ?></div>
                            </li>
                        <? endforeach; ?>
                    </ul>
                    <a href="/checkout/" class="detail-product__buy">Оформить</a>
                </div>
            <? endif; ?>
        </div>
    </header>
    <div class="menu-wrap">
        <div class="menu-controller">
            <i class="fas fa-bars  show-drop"></i>
        </div>

        <ul class="menu">
            <? /* @var $category \app\models\entity\Category */ ?>
            <? foreach (\app\models\entity\Category::find()->where(['parent'=>0])->all() as $category): ?>
                <li class="menu__item"><a href="<?= $category->getDetail(); ?>"><?= $category->name; ?></a></li>
            <? endforeach; ?>
        </ul>


        <div class="drop-all-cats hide">
            <ul class="list-drop-items">
                <? /* @var $category Category */ ?>
                <? foreach (Category::find()->where(['parent'=>0])->all() as $category): ?>
                    <li class="drop-item">
                        <div class="drop-item-wrap">
                            <img src="<?= $category->image; ?>" class="drop-item__image" alt="<?= $category->name; ?>" title="<?= $category->name; ?>">
                            <span class="drop-item__name">
                                <a href="<?= $category->detail; ?>" class="drop-item__link">
                                    <?= $category->name; ?>
                                </a>
                            </span>
                        </div>

                        <ul class="sub-list-drop-items">
                            <? /* @var $category2 Category */ ?>
                            <? foreach (Category::find()->where(['parent' => $category->id])->all() as $category2): ?>
                                <li>
                                    <a href="<?= $category2->detail; ?>" class="drop-item__link">
                                        <?= $category2->name; ?>
                                    </a>
                                    <ul class="sub-list-drop-items">
                                        <? foreach (Category::find()->where(['parent' => $category2->id])->all() as $category3): ?>
                                        <li>
                                            <a class="drop-item__link" href="<?=$category3->detail;?>"><?=$category3->name;?></a>
                                        </li>
                                        <? endforeach; ?>
                                    </ul>
                                </li>
                            <? endforeach; ?>
                        </ul>
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

                    <? foreach (Category::find()->where(['parent'=>'0'])->all() as $category): ?>
                        <li class="footer-menu__item"><a href="<?= $category->detail; ?>"><?= $category->name ?></a>
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
                    <li class="footer-menu__item"><a href="/articles/">Статьи</a></li>
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
