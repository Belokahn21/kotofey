<?php

namespace app\modules\news\models\tools;


use app\modules\news\models\entity\News;
use yii\helpers\Url;

class NewsHelper
{
	public static function getDetailUrl(News $model)
	{
		return Url::to(['/news/news/view', 'id' => $model->slug]);
	}

	public static function getPreviewImageUrl(News $model)
	{
		return "/upload/" . $model->preview_image;
	}
}