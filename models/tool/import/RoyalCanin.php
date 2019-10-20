<?php

namespace app\models\tool\import;


use app\models\entity\Product;
use yii\helpers\ArrayHelper;

class RoyalCanin
{
    private $rows;
    private $csv_file_path;

    public function __construct()
    {
        $this->csv_file_path = \Yii::getAlias('@app') . "/tmp/royal.csv";

        $this->getCSVDataFromFile();


        $articles = array();
        foreach ($this->rows as $row) {

            if (count($row) == 1) {
                $row = iconv('cp1251', 'utf-8', $row[0]);
                $row_elements = explode(';', $row);

                if (is_numeric($row_elements[0])) {
                    $articles[$row_elements[0]] = $row_elements[3];
                }


            }
            echo "\n";
        }

        $product_id_list = array();
        $query = Product::find()->select(['id'])->where(['code' => array_keys($articles)])->all();
//        $product_id_list = ArrayHelper::getColumn($query, 'id');


        foreach ($query as $product) {
            var_dump($articles[$product->code] == $product->purchase);
            echo "\n";
        }


//        print_r($product_id_list);
//        print_r($product_id_list);

    }

    private function getCSVDataFromFile()
    {
        $this->rows = array_map('str_getcsv', file($this->csv_file_path));
    }
}