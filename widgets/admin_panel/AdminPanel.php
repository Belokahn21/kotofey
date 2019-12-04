<?

namespace app\widgets\admin_panel;


use app\models\entity\User;

class AdminPanel extends \yii\base\Widget
{
	public function run()
	{
		if (!User::isRole('Developer') and !User::isRole('Administrator')) {
			return false;
		}
		return $this->render('default');
	}
}