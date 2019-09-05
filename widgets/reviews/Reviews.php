<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:09
 */

namespace app\widgets\reviews;

use app\models\entity\SiteReviews;
use yii\base\Widget;

class Reviews extends Widget
{

    public function run()
    {
        $reviews = SiteReviews::find()->limit(5)->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('default', [
            'reviews' => $reviews
        ]);
    }
}