<?

use app\models\tool\seo\Title;
use app\models\entity\User;

$this->title = Title::showTitle("О зоомагазине");
$this->params['breadcrumbs'][] = ['label' => 'О зоомагазине', 'url' => ['/about/']]; ?>
<section class="about page-content">
    <h2>О зоомагазине</h2>
    <p align="justify">
        Мы молодой и развивающийся интернет-магазин зоотоваров <b>Котофей</b>.
    </p>
    <h2>Наша история появления</h2>
    <p align="justify">
        На создание магазина повлияло два события. Первое событие это опыт работы в розничном магазине зоотоваров <a
                href="">Демарис</a>. Нам очень нравилось видеть счастливые лица клиентов, когда мы обслуживали их. К
        сожалению его судьба закрылась и нам пришлось искать другую работу. А
        второе событие это появление в нашем доме кота. Нашего главного начальника зовут Лестер, ему
        сейчас <?= User::calcCurrentAge("28-04-2018"); ?>.<br/><br/>

    </p>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <img src="/web/upload/images/lester.jpg" alt="Наш главный начальник" title="Главный руковдитель" align="middle" width="200">
        <div style="color: grey; font-weight: 600; font-size: 14px; font-style: italic;">Главный дегустатор</div>
    </div>
    <p align="justify">Нас объединяют несколько направлений. Желание продавать и любовь к животным. В связи с этим мы решили продавать
        зоотовары поскольку у нас есть зверушка ради которой это хочется делать. Возможно это звучит странно :)</p>
    <p align="justify">
        Наша цель это лояльное и доброе обслуживание наших клиентов, чтобы видеть снова улыбки и понимать, что нам рады
        и готовы вернутся в наш магазин снова и снова
    </p>
    <p>
        В нашем магазине продаются товары различных компаний, всегда свежие и в наличии:
    </p>
    <ul>
        <li>
            <a href="https://www.royal-canin.ru/" target="_blank" rel="nofollow">Royal Canin</a>
        </li>
        <li>
            <a href="http://mnyams.ru/" target="_blank" rel="nofollow">Мнямс</a>
        </li>
        <li>
            <a href="http://www.monge.ru/" target="_blank" rel="nofollow">Monge</a>
        </li>
    </ul>
</section>
