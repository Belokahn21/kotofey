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
        $image = ProductHelper::getImageUrl($model);
        return "
        <tr style='display: block; width: 100%;'>
          <td style='width:15%; padding: 5px; font-size:16px; '><img src='{$image}' style='width: 100%; object-fit: contain;'></td>
          <td style='width:30%; padding: 5px; font-size:16px; '>{$model->name}</td>
          <td style='width:15%; padding: 5px;'>
              <div style='text-transform: uppercase; font-size: 10px; font-weight: bold;'>старая цена</div>
              <div style='font-size: 12px;'>{$model->price} {$cur_icon}</div>
            </td>
          <td style='width:15%; padding: 5px;'>
              <div style='text-transform: uppercase; font-size: 10px; font-weight: bold;'>Со скидкой</div>
              <div style='color:#ff1a4a;'>{$model->getDiscountPrice()} {$cur_icon}</div>
            </td>
          <td style='width:15%; padding: 5px;'>
          <a href='{$detail}' style='border:1px solid #ff1a4a; color:#ff1a4a; padding:5px; text-decoration:none!important; text-transform:uppercase; font-size:12px;'>Купить</a>
          </td>
        </tr>
        ";
    }
}