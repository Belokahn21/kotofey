<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 10:50
 */

namespace app\widgets\admin_panel;


use app\models\entity\Category;
use app\models\entity\Pages;
use app\models\entity\Product;
use app\models\entity\User;
use app\widgets\notification\Notify;

class AdminPanel extends \yii\base\Widget
{
    public function run()
    {
        if (User::isRole('Developer')) {
            $JS = <<<JS
setInterval(function () {
    $('.admin-panel-list__item-ts').text(Math.floor(Date.now() / 1000));
}, 1000);
JS;
            $CSS = <<<CSS
.admin-panel-wrap{width: 100%;}
    .admin-panel-list{list-style-type: none;margin: 0;padding: 0;overflow: hidden;background-color: #333;}
        .admin-panel-list__item{display: inline-block; float: left; }
        .admin-panel-list__item a{display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;}
            .admin-panel-list__item.link a:hover{background-color: #111;}
.actual-count{background: green; -webkit-border-radius: 0.3em;-moz-border-radius: 0.3em;border-radius: 0.3em;}
CSS;

            \Yii::$app->view->registerJs($JS);
            \Yii::$app->view->registerCss($CSS);

            $slug = \Yii::$app->request->get('id');
            $action = \Yii::$app->controller->action->id;

            if ($action === "product"){
                $model = Product::findBySlug($slug);
                $model->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            }


            if ($action === "article"){
                $model = Pages::findBySlug($slug);
                if($model instanceof Pages){
                    $model->scenario = Product::SCENARIO_UPDATE_PRODUCT;
                }
            }

            if(in_array($action, ['product', 'article'])){
                if (\Yii::$app->request->isPost) {
                    if ($model->load(\Yii::$app->request->post())) {
                        if ($model->validate()) {
                            if ($model->update()) {
                                Notify::setSuccessNotify("Элемент успешно обновлён");
                                \Yii::$app->controller->redirect($model->detail);
                            }
                        }
                    }
                }
            }

            return $this->render('default', [
                'slug' => $slug,
                'model' => $model,
            ]);
        }
    }
}