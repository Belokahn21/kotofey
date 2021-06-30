<?php

namespace app\modules\mailer\models\helpers;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\models\tools\Currency;

class PromotionHtmlHelper
{
    public static function renderProduct(Product $model)
    {
        $detail = ProductHelper::getDetailUrl($model);
        $cur_icon = Currency::getInstance()->show();
        return "
        <tr style='display: block; width: 100%;'>
          <td style='width:45%; padding: 5px; font-size:16px; '>{$model->name}</td>
          <td style='width:15%; padding: 5px;'>{$model->price} {$cur_icon}</td>
          <td style='width:15%; padding: 5px;'>{$model->discount_price} {$cur_icon}</td>
          <td style='width:15%; padding: 5px;'>
          <a href='{$detail}' style='border:1px solid #ff1a4a; color:#ff1a4a; padding:5px; text-decoration:none!important; text-transform:uppercase; font-size:12px;'>Купить</a>
          </td>
        </tr>
        ";
    }
}