<?

namespace app\models\entity;


class Favorite
{
	const NAME_KEY_SESSION_FAVORITE = 'favorite';

	public function __construct()
	{
		\Yii::$app->session->open();
	}

	public static function getInstance()
	{
		return new Favorite();
	}


	public function add($product_id)
	{
		$_SESSION[self::NAME_KEY_SESSION_FAVORITE][$product_id] = $product_id;
	}

	public function delete($product_id)
	{
		unset($_SESSION[self::NAME_KEY_SESSION_FAVORITE][$product_id]);
	}

	public function clear()
	{
		\Yii::$app->session->remove(self::NAME_KEY_SESSION_FAVORITE);
	}

	public function exist($product_id)
	{
		if (array_key_exists(self::NAME_KEY_SESSION_FAVORITE, $_SESSION)) {
			if ($_SESSION[self::NAME_KEY_SESSION_FAVORITE][$product_id]) {
				return true;
			}
		}
		return false;
	}

	public static function findAll()
	{
		$items = array();
		if (\Yii::$app->session->get(self::NAME_KEY_SESSION_FAVORITE)) {
			foreach (\Yii::$app->session->get(self::NAME_KEY_SESSION_FAVORITE) as $product_id) {
				$items[] = Product::findOne($product_id);
			}
		}
		return $items;
	}

	// public function update(){}
}