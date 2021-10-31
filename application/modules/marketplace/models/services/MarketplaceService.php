<?php

namespace app\modules\marketplace\models\services;

use app\modules\marketplace\models\entity\Marketplace;
use app\modules\marketplace\models\entity\MarketplaceProduct;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MarketplaceService
{
    public function getTemplateStockOut()
    {
        $marketplace = Marketplace::findOne(['slug' => 'ozon']);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $file_name = time() . ".xlsx";
        $line = 1;


        foreach (MarketplaceProduct::findAll(['marketplace_id' => $marketplace->id]) as $item) {
//            $sheet->setCellValue("A{$line}", $marketplace->shop_id);
            $sheet->setCellValue("A{$line}", 'Склад Котофей (22215334034000)');
            $sheet->setCellValue("B{$line}", $item->product->article);
            $sheet->setCellValue("C{$line}", $item->product->name);
            $sheet->setCellValue("D{$line}", $item->product->count);
            $line++;
        }


        // save file
        $writer = new Xlsx($spreadsheet);
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename={$file_name}");
        $writer->save('php://output');
        exit();
    }
}