<?

namespace app\models\entity;


class Favorite
{
	private $name_key_favorite = 'favorite';

	public function __construct()
	{
	}

	public static function getInstance()
	{
		return new Favorite();
	}

	public function add($product_id)
	{
		\Yii::$app->session->open();
		$_SESSION[$this->name_key_favorite][$product_id] = $product_id;
	}

	public function delete($product_id)
	{
		\Yii::$app->session->open();
		unset($_SESSION[$this->name_key_favorite][$product_id]);
	}

	public function clear()
	{
		\Yii::$app->session->remove($this->name_key_favorite);
	}

	public function exist($product_id)
	{
		if ($_SESSION[$this->name_key_favorite][$product_id]) {
			return true;
		}
		return false;
	}

	// public function update(){}
}