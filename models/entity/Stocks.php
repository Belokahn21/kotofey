<?

namespace app\models\entity;


use app\models\tool\Debug;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Stocks model
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $time_start
 * @property integer $time_end
 * @property integer $created_at
 * @property integer $updated_at
 */
class Stocks extends ActiveRecord
{

    public $hour_start;
    public $minute_start;
    public $hour_end;
    public $minute_end;

    public function rules()
    {
        return [

            [['name', 'address','city_id'], 'required', 'message' => '{attribute} обязательно'],

            [['name', 'address'], 'string'],

            [['time_start', 'time_end','city_id'], 'integer'],

            [['hour_start', 'minute_start', 'hour_end', 'minute_end'], 'integer'],

        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'address' => 'Адрес',
            'time_start' => 'Время открытия',
            'time_end' => 'Время закрытия',
            'sort' => 'Сортировка',
            'active' => 'Активность',
            'city_id' => 'Город',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',

            'hour_start' => 'Часы',
            'minute_start' => 'Минуты',
            'hour_end' => 'Часы',
            'minute_end' => 'Минуты',
        ];
    }

    public function create()
    {
        if ($this->load(\Yii::$app->request->post())) {

            $this->setUnixTime();

            if ($this->validate()) {
                if ($this->save()) {
                    return true;
                }
            }
        }
    }

    public function edit()
    {
        if ($this->load(\Yii::$app->request->post())) {

            $this->setUnixTime();

            if ($this->validate()) {
                if ($this->save()) {
                    return true;
                }
            }
        }
    }

    public function setUnixTime()
    {
        $this->time_start = intval(strtotime($this->hour_start . ":" . $this->minute_start));
        $this->time_end = intval(strtotime($this->hour_end . ":" . $this->minute_end));
    }
}