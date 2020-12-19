<?php

namespace app\models\tool\export;


use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class YandexCatalogExport implements Export
{
    public function create()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'id');
        $sheet->setCellValue('B1', 'Статус товара');
        $sheet->setCellValue('C1', 'Доставка');
        $sheet->setCellValue('D1', 'Название');
        $sheet->setCellValue('E1', 'Категория');
        $sheet->setCellValue('F1', 'Цена');
        $sheet->setCellValue('G1', 'Валюта');
        $sheet->setCellValue('H1', 'Описание');
        $sheet->setCellValue('I1', 'Ссылка на товар на сайте магазина');
        $sheet->setCellValue('J1', 'Ссылка на картинку');
        $sheet->setCellValue('K1', 'Страна происхождения');

        $products = Product::find()->all();
        if ($products) {
            $row = 2;
            foreach ($products as $product) {
                $sheet->setCellValue('A' . $row, $product->id);
                $sheet->setCellValue('B' . $row, 'В наличии');
                $sheet->setCellValue('C' . $row, 'Есть');
                $sheet->setCellValue('D' . $row, $product->name);
                $sheet->setCellValue('E' . $row, 'Товары для животных');
//                $sheet->setCellValue('E' . $row, $product->category->name);
                $sheet->setCellValue('F' . $row, $product->price);
                $sheet->setCellValue('G' . $row, 'RUB');
                $sheet->setCellValue('H' . $row, $product->description);
                $sheet->setCellValue('I' . $row, 'https://kotofey.store/' . $product->detail);
                if ($product->image) {
                    $sheet->setCellValue('J' . $row, 'https://kotofey.store/upload/' . $product->image);
                }

                $country = SaveInformersValues::findOne(['id' => SaveProductPropertiesValues::findOne(['product_id' => $product->id, 'property_id' => 6])]);
                if ($country) {
                    $sheet->setCellValue('K' . $row, $country->name);
                }

                $row++;
            }
        }


        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');
    }
}