<?

use yii\db\Migration;

class m190710_063738_create_selling_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('selling', [
            'id' => $this->primaryKey(),
            'summ'=>$this->integer(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('selling');
    }
}
