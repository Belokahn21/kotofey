<?php

namespace app\widgets\inspector;


use yii\web\AssetBundle;

class InspectorAssets extends AssetBundle
{
	public $sourcePath;

	public $css = [
//		'css/style.css'
	];

	public $js = [
//		'js/script.js',
	];

	public $depends = [
		'yii\web\JqueryAsset',
	];

	public function init()
	{
		parent::init();
		$this->sourcePath = __DIR__ . '/assets';
	}
}