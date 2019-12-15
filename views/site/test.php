<?php


//$explode = explode(' ', 'купить машину');
//$sql = "";
//foreach ($explode as $search_phrase) {
//	$sql .= sprintf("`name` like '%%%s%%' and ", $search_phrase);
//}
//$sql = substr($sql, 0, -5);
//echo $sql;

//\app\models\tool\Debug::p(file_get_contents('http://lukasn.ru/catalog/12807.html'));


//use app\models\tool\parser\page\Page;
//
//
//$url = 'http://lukasn.ru/catalog/12807.html';
//$page = new Page('http://lukasn.ru/Module_User/enter/', [
//	'login' => 'info@kotofey.store',
//	'pass' => '123456',
//], true);
//$html = $page->content($url);
//
//echo $html;
?>

<?php
//$res  = Yii::$app->mailer->compose()
//	->setFrom('sale@kotofey.store')
//	->setTo('rusengo@yandex.ru')
////	->setTo('popugau@gmail.com')
//	->setSubject('Тема сообщения')
//	->setTextBody('Текст сообщения')
////	->setHtmlBody('<b>текст сообщения в формате HTML</b>')
//	->send();
//
//
//var_dump($res);
?>
<?php


$ns = new \app\models\services\NotifyService();
$ns->sendEmailClient(1);


?>
