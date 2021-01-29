<?php

namespace app\modules\order\controllers;

use app\modules\bonus\models\helper\BonusHelper;
use app\modules\order\models\entity\OrderDate;
use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\tools\Debug;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\search\OrderSearchForm;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use app\modules\delivery\models\entity\Delivery;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderStatus;
use app\modules\payment\models\entity\Payment;
use app\modules\user\models\entity\User;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class OrderBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\order\models\entity\Order';

    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['report'], 'roles' => ['Administrator']]
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $itemsModel = new OrdersItems();
        $dateDelivery = new OrderDate();
        $users = User::find()->all();
        $deliveries = Delivery::find()->all();
        $payments = Payment::find()->all();
        $status = OrderStatus::find()->all();
        $searchModel = new OrderSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            $transaction = \Yii::$app->db->beginTransaction();

            if ($model->load(\Yii::$app->request->post())) {

                if ($model->validate()) {
                    if (!$model->save()) {
                        $transaction->rollBack();
                        return $this->refresh();
                    }
                }

                $count = count(Yii::$app->request->post('OrdersItems', []));

                $items = [new OrdersItems()];

                for ($i = 1; $i < $count; $i++) {
                    $items[] = new OrdersItems();
                }

                if (OrdersItems::loadMultiple($items, Yii::$app->request->post())) {

                    foreach ($items as $item) {

                        if (OrderHelper::isEmptyItem($item)) continue;

                        $item->order_id = $model->id;
                        if ($item->validate()) {
                            if (!$item->save()) {
                                $transaction->rollBack();
                                return $this->refresh();
                            }
                        }
                    }

                }


                if ($dateDelivery->load(Yii::$app->request->post())) {
                    $dateDelivery->order_id = $model->id;
                    if ($dateDelivery->validate()) {
                        $dateDelivery->save();
                    }
                }

                $transaction->commit();
                Alert::setSuccessNotify('Заказ успешно создан');
                return $this->refresh();
            }
        }
        return $this->render('index', [
            'itemsModel' => $itemsModel,
            'dateDelivery' => $dateDelivery,
            'users' => $users,
            'model' => $model,
            'deliveries' => $deliveries,
            'payments' => $payments,
            'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Заказ не существует');

        $model->scenario = $this->modelClass::SCENARIO_CUSTOM;
        if (!$itemsModel = OrdersItems::find()->where(['order_id' => $model->id])->all()) {
            $itemsModel = new OrdersItems();
        }
        $users = User::find()->all();
        $deliveries = Delivery::find()->all();
        $payments = Payment::find()->all();
        $status = OrderStatus::find()->all();
        if (!$dateDelivery = OrderDate::findOneByOrderId($model->id)) {
            $dateDelivery = new OrderDate();
        }

        if (\Yii::$app->request->isPost) {
            $transaction = \Yii::$app->db->beginTransaction();

            if ($model->load(\Yii::$app->request->post())) {

                if ($model->validate()) {
                    if (!$model->update()) {
                        $transaction->rollBack();
                        return $this->refresh();
                    }
                }

                OrdersItems::deleteAll(['order_id' => $model->id]);

                $count = count(Yii::$app->request->post('OrdersItems', []));

                $items = [new OrdersItems()];

                for ($i = 1; $i < $count; $i++) {
                    $items[] = new OrdersItems();
                }

                if (OrdersItems::loadMultiple($items, Yii::$app->request->post())) {

                    foreach ($items as $item) {

                        if (!empty($item->need_delete)) continue;

                        if (OrderHelper::isEmptyItem($item)) continue;

                        $item->order_id = $model->id;
                        if ($item->validate()) {
                            if (!$item->save()) {
                                $transaction->rollBack();
                                return $this->refresh();
                            }
                        }
                    }

                }

                if ($dateDelivery->isNewRecord) {
                    if ($dateDelivery->load(Yii::$app->request->post())) {
                        $dateDelivery->order_id = $model->id;
                        if ($dateDelivery->validate()) {
                            $dateDelivery->save();
                        }

                    }
                } else {
                    if ($dateDelivery->load(Yii::$app->request->post())) {
                        if ($dateDelivery->validate()) {
                            $dateDelivery->update();
                        }
                    }
                }

                // Добавляем пользователю бонусы
                if ($model->chargeBonus) BonusHelper::applyOrderBonus($model);

                $transaction->commit();
                Alert::setSuccessNotify('Заказ успешно обновлён');
                return $this->refresh();
            }
        }

        return $this->render('update', [
            'itemsModel' => $itemsModel,
            'dateDelivery' => $dateDelivery,
            'users' => $users,
            'model' => $model,
            'deliveries' => $deliveries,
            'payments' => $payments,
            'status' => $status,
        ]);
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('removeOrder')) throw new ForbiddenHttpException('У вас нет разрешения на эту операцию');

        if ($this->modelClass::findOne($id)->delete()) Alert::setSuccessNotify('Заказ успешно удалён');

        return $this->redirect(['index']);
    }

    public function actionReport($id)
    {
        if (!$order = $this->modelClass::findOne($id)) throw new HttpException(404, 'Запись не найдена');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $file_name = "order_{$order->id}.xlsx";

        // Размеры колонок
        $sheet->getColumnDimension('A')->setWidth('12');
        $sheet->getColumnDimension('B')->setWidth('70');
        $sheet->getColumnDimension('C')->setWidth('10');
        $sheet->getColumnDimension('D')->setWidth('8');
        $sheet->getColumnDimension('E')->setWidth('6');
        $sheet->getColumnDimension('F')->setWidth('8');
        $sheet->getColumnDimension('G')->setWidth('8');

        // Заголовок
        $sheet->setCellValue('A1', sprintf('Товарная наклданая №%s от %s', $order->id, date('d.m.Y', $order->created_at)));
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Кто продал
        $sheet->setCellValue('A3', 'Продавец');
        $sheet->setCellValue('B3', 'Интернет-зоомагазин Котофей (ИП Васин К.В.)');
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->setCellValue('B4', sprintf('Адрес г. Барнаул, ул. Весеняя, дом 4. Телефон: %s, Сайт https://kotofey.store/', SiteSettings::getValueByCode('phone_1')));
        $sheet->setCellValue('B5', sprintf('ИНН %s, ОГРН %s', SiteSettings::getValueByCode('inn'), SiteSettings::getValueByCode('ogrn')));
        $sheet->mergeCells('B3:G3');
        $sheet->mergeCells('B4:G4');
        $sheet->mergeCells('B5:G5');


        // Список товаров
        $items = OrdersItems::find()->where(['order_id' => $order->id])->all();

        $line = 8;
        $start_table = $line;
        $sheet->setCellValue("A{$line}", '№');
        $sheet->setCellValue("B{$line}", 'Товар');
        $sheet->setCellValue("C{$line}", 'Артикул');
        $sheet->setCellValue("D{$line}", 'Кол-во');
        $sheet->setCellValue("E{$line}", 'Ед.');
        $sheet->setCellValue("F{$line}", 'Цена');
        $sheet->setCellValue("G{$line}", 'Сумма');
        foreach ($items as $count => $item) {
            $line++;
            $sheet->setCellValue("A{$line}", ++$count);
            $sheet->setCellValue("B{$line}", $item->name);
            if ($item->product) {
                $sheet->setCellValue("C{$line}", $item->product->article);
            } else {
                $sheet->setCellValue("C{$line}", '');
            }
            $sheet->setCellValue("D{$line}", $item->count);
            $sheet->setCellValue("E{$line}", 'Шт.');
            $sheet->setCellValue("F{$line}", $item->price);
            $sheet->setCellValue("G{$line}", $item->count * $item->price);
        }

        // Рамка для таблицы
        $sheet->getStyle("A{$start_table}:G{$line}")->applyFromArray(
            array(
                'borders' => array(
                    'allBorders' => array(
                        'borderStyle' => Border::BORDER_THIN
                    )
                )
            )
        );

        $line++;

        $sheet->setCellValue("F{$line}", 'Итого');
        $sheet->setCellValue("G{$line}", OrderHelper::orderSummary($order));

        $line = $line + 2;
        $result = (new \MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => OrderHelper::orderSummary($order)]);
        $sheet->setCellValue("A{$line}", Yii::$app->i18n->format(sprintf("Всего отпущено на сумму %s {n, plural, =0{Пусто} =1{рубль} one{рубль} few{рублей} many{рублей} other{Ошибка}}", $result), ['n' => OrderHelper::orderSummary($order)], 'ru_RU'));
        $sheet->mergeCells("A{$line}:B{$line}");

        $line = $line + 2;
        $sheet->setCellValue("A{$line}", 'Отпустил        ________        Расшифровка       ________');
        $sheet->mergeCells("A{$line}:B{$line}");


        // save file
        $writer = new Xlsx($spreadsheet);
//		$writer->save("$file_name");

        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename={$file_name}");
//
        $writer->save('php://output');
    }
}
