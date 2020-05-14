<?php

if ($model->owner) {
	$address = null;


	if ($model->owner->billing && $model->owner->billing->city) {
		$address .= "город {$model->owner->billing->city}, ";
	}
	if ($model->owner->billing && $model->owner->billing->street) {
		$address .= "улица {$model->owner->billing->street}, ";
	}
	if ($model->owner->billing && $model->owner->billing->home) {
		$address .= "дом {$model->owner->billing->home}";
	}

	if (!is_null($address)) {


		$url = "https://geocode-maps.yandex.ru/1.x/?";
		$params = [
			'apikey' => Yii::$app->params['yandex']['geocode'],
			'format' => 'json',
			'geocode' => $address,
		];
		$response = null;
		$xyPoints = null;

		$options = array(
			"http" => array(
				"header" => "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
			)
		);

		$context = stream_context_create($options);
		$response = file_get_contents($url . http_build_query($params), false, $context);

		if ($response) {
			$response = \yii\helpers\Json::decode($response);
			$xyPoints = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
		}

		?>

		<h4>Место на карте</h4>
		<div id="map" style="width: 600px; height: 400px"></div>
		<script type="text/javascript">

			ymaps.ready(init);

			function init() {
				// Создание карты.
				var myMap = new ymaps.Map('map', {
						center: [<?=implode(',', array_reverse(explode(' ', $xyPoints)));?>],
						zoom: 17
					}, {
						searchControlProvider: 'yandex#search'
					}),

					// Создаём макет содержимого.
					MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
						'<div style="color: #fff; font-weight: bold;">$[properties.iconContent]</div>'
					),

					myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
						hintContent: 'Собственный значок метки',
						balloonContent: 'Это красивая метка'
					}, {
						// Опции.
						// Необходимо указать данный тип макета.
						// iconLayout: 'default#image',
						// Своё изображение иконки метки.
						// iconImageHref: 'images/myIcon.gif',
						// Размеры метки.
						// iconImageSize: [30, 42],
						// Смещение левого верхнего угла иконки относительно
						// её "ножки" (точки привязки).
						// iconImageOffset: [-5, -38]
					});

				myMap.geoObjects
					.add(myPlacemark);
			}
		</script>
	<?php } ?>
<?php } ?>