<?php

/* @var $this \yii\web\View
 * @var $content string
 * @var $parentCategories ProductCategory[]
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\widgets\notification\Alert;
use app\modules\user\models\entity\User;
use app\widgets\notification\NotifyWidget;
use app\modules\basket\models\entity\Basket;
use app\modules\compare\models\entity\Compare;
use app\modules\site\widgets\PageUp\PageUpWidget;
use app\modules\search\widges\search\SearchWidget;
use app\modules\site\widgets\AdminPanel\AdminPanel;
use app\modules\site\widgets\PageInfo\PageInfoWidget;
use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\helpers\ProductCategoryHelper;
use app\modules\basket\widgets\MiniMobileCart\MiniMobileCartWidget;

if (Yii::$app->request->get('comeback')) {
    Yii::$app->response->cookies->add(new \yii\web\Cookie([
        'name' => 'comeback',
        'value' => Yii::$app->request->get('comeback'),
    ]));
}
//$mb = new Mobile_Detect();
//if ($mb->isMobile() && Yii::$app->request->cookies->getValue('comeback', 'N') !== 'Y') Yii::$app->controller->redirect('https://m.kotofey.store');


AppAsset::register($this);

$parentCategories = Yii::$app->cache->getOrSet('parent-cats', function () {
    return ProductCategory::find()->select(['id', 'name', 'slug'])->where(['parent_category_id' => 0])->all();
}, 3600 * 7 * 24);

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="2lxEu3cepZijbEYmJ7zv4H8lhUKvX89GhMA_ujLklmk"/>
    <script src="https://kit.fontawesome.com/33cf5fcfbe.js" crossorigin="anonymous" defer></script>
    <?php if (YII_ENV == 'prod'): ?>
        <?php echo $this->render('include/head/yandex/webmaster.php'); ?>
        <?php echo $this->render('include/head/google/google_metrika.php'); ?>
        <?php echo $this->render('include/head/regmarkets.php'); ?>
    <?php endif; ?>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= AdminPanel::widget(); ?>
<?php /*= NotifyWidget::widget([
    'message' => 'Дорогие клиенты, в период с 28.06.2021 по 05.07.2021 доставка заказов может увеличится по времени ожидания до 30 минут. Технические неполадки с курьерским ТС. Доставка временно осуществляется другим сервисом.'
]);*/ ?>

<?= $this->render('include/header', [
    'parentCategories' => $parentCategories
]); ?>

<div class="menu-wrapper">
    <div class="menu page-container">
        <div class="menu__item hamburger js-hamburger"><img alt="Показать меню" class="hamburger__icon" src="/images/hamburger.svg"></div>
        <div class="menu__item"><a class="menu__link" href="<?= Url::to(['/catalog/']); ?>">Зоотовары</a></div>
        <div class="menu__item"><a class="menu__link" href="<?= Url::to(['/promotion/']); ?>">Акции и скидки</a></div>
        <div class="menu__item">
            <?= SearchWidget::widget(); ?>
        </div>
        <div class="menu__item">
            <?php if (Yii::$app->user->isGuest): ?>
                <a class="menu__link profile" href="javascript:void(0);" data-toggle="modal" data-target="#signupModal">
                    <img class="profile__icon" src="/images/lock.png" alt="Регистрация"><span>Регистрация</span>
                </a>
            <?php else: ?>
                <a class="menu__link profile" href="<?= Url::to(['/user/profile/index']); ?>">
                    <div>
                        <img class="profile__icon" src="/images/lock.png" alt="Личный кабинет"><span>Личный кабинет</span>
                    </div>

                    <?php /* Вжух меню не вышло из-за ссылок
                    <div class="header-dropdown-menu">
                        <div class="header-dropdown-menu__item"><a class="header-dropdown-menu__link" href="#">Заказы</a></div>
                        <div class="header-dropdown-menu__item"><a class="header-dropdown-menu__link" href="#">Настройки</a></div>
                        <div class="header-dropdown-menu__item"><a class="header-dropdown-menu__link" href="#">Избранное</a></div>
                        <div class="header-dropdown-menu__item"><a class="header-dropdown-menu__link" href="#">Питомцы</a></div>
                        <div class="header-dropdown-menu__item"><a class="header-dropdown-menu__link" href="/logout/">Выход</a></div>
                    </div> */ ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="menu__item">
            <a class="menu__link basket" href="<?= Url::to(['/checkout/']) ?>">
                <img class="basket__icon" src="/images/basket.png" alt="Корзина">
                <div class="basket__counter<?= (Basket::count() > 0 ? '' : ' hidden'); ?>">
                    <span><?= Basket::count(); ?></span>
                </div>
            </a>
        </div>
        <div class="menu__item">
            <a class="menu__link compare" href="<?= Url::to(['/compare/']) ?>">
                <img class="compare__icon" src="/images/compare.png" alt="Сравнение товара">
                <div class="compare__counter<?= (count(Compare::getListId()) > 0 ? '' : ' hidden'); ?>">
                    <span><?= count(Compare::getListId()); ?></span>
                </div>
            </a>
        </div>
    </div>
    <div class="menu-full js-show-with-hamburger">
        <?php if ($parentCategories): ?>
            <?php foreach ($parentCategories as $parentCategory) : ?>
                <div class="block-menu">
                    <div class="block-menu__title"><?= $parentCategory->name; ?></div>
                    <?php if ($subsection = ProductCategoryHelper::getInstance()->getNavChain($parentCategory)): ?>
                        <ul class="block-menu-list">
                            <?php foreach ($subsection as $item): ?>
                                <li class="block-menu-list__item">
                                    <a class="block-menu-list__link" href="<?= ProductCategoryHelper::getDetailUrl($item); ?>"><?= $item->name; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


<?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'): ?>
    <?= $content; ?>
<?php else: ?>
    <div class="page-container">
        <?= $content; ?>
    </div>
<?php endif ?>

<?php if ($this->beginCache('main-footer', ['duration' => Yii::$app->params['cache_time']])): ?>
    <?= $this->render('include/footer'); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<?= PageUpWidget::widget(); ?>

<?php if (Yii::$app->user->isGuest) {
    $signinModel = new User(['scenario' => User::SCENARIO_LOGIN]);
    $signupModel = new User(['scenario' => User::SCENARIO_INSERT]);
    echo $this->render('include/auth', [
        'signin' => $signinModel,
        'signup' => $signupModel,
    ]);
} ?>

<?= $this->render('include/help-desk') ?>
<?= $this->render('include/yandex-map') ?>
<?= Alert::widget(); ?>
<?= PageInfoWidget::widget(); ?>
<?php /* <script src="/js/frontend-core.min.js"></script> */ ?>
<script src="/js/bundle.js"></script>
<?php $this->endBody(); ?>
<?php if (YII_ENV == 'prod'): ?>
    <?php echo $this->render('include/head/yandex/metrika.php'); ?>
    <!--    --><?php //echo $this->render('include/head/yandex/chat.php'); ?>
    <!--    --><?php //echo $this->render('include/head/fb/pixel.php'); ?>
    <?php echo $this->render('include/head/jivo.php'); ?>
<?php endif; ?>
</body>
<?= MiniMobileCartWidget::widget(); ?>
</html>
<?php $this->endPage(); ?>
