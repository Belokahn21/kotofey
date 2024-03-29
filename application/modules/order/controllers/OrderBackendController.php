<?php

namespace app\modules\order\controllers;

use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\delivery\models\repository\DeliveryRepository;
use app\modules\logger\models\service\LogService;
use app\modules\order\models\entity\OrderTracking;
use app\modules\order\models\repository\OrderStatusRepository;
use app\modules\order\models\service\GroupBuyDataService;
use app\modules\order\models\service\OrderService;
use app\modules\payment\models\repository\PaymentRepository;
use app\modules\payment\models\services\acquiring\auth\SberbankAuthBasic;
use app\modules\payment\models\services\acquiring\banks\Sberbank;
use app\modules\payment\models\services\acquiring\AcquiringTerminalService;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\System;
use app\modules\user\models\repository\UserRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\web\HttpException;
use yii\web\ForbiddenHttpException;
use app\widgets\notification\Alert;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderDate;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\search\OrderSearchForm;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\modules\site\controllers\MainBackendController;
use app\modules\site_settings\models\entity\SiteSettings;

class OrderBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\order\models\entity\Order';
    public $service;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = new OrderService();
    }

    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['report', 'export', 'payment-link', 'group'], 'roles' => ['Administrator']]
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $this->service->setModel($model);

        $itemsModel = new OrdersItems();
        $dateDelivery = new OrderDate();
        $searchModel = new OrderSearchForm();
        $trackForm = new OrderTracking();

        $users = $this->getUsers();
        $deliveries = $this->getDeliveries();
        $payments = $this->getPayments();
        $status = $this->getStatuses();

        $dataProvider = $searchModel->search(Yii::$app->request->get());


        try {
            if ($this->service->createOrder()) {
                Alert::setSuccessNotify('Заказ успешно создан');
                return $this->refresh();
            }
        } catch (\Exception $e) {
            Alert::setErrorNotify($e->getMessage());
            Debug::printFile($this->service->getErrors());
            return $this->refresh();
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
            'trackForm' => $trackForm,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Заказ не существует');

        $model->scenario = $this->modelClass::SCENARIO_CUSTOM;
        if (!$itemsModel = OrdersItems::find()->where(['order_id' => $model->id])->all()) {
            $itemsModel = new OrdersItems();
        }

        $users = $this->getUsers();
        $deliveries = $this->getDeliveries();
        $payments = $this->getPayments();
        $status = $this->getStatuses();

        $this->service->setModel($model);
        if (!$dateDelivery = OrderDate::findOneByOrderId($model->id)) $dateDelivery = new OrderDate();
        if (!$trackForm = OrderTracking::findByOrderId($model->id)) $trackForm = new OrderTracking();

        try {
            if ($this->service->updateOrder()) {
                Alert::setSuccessNotify('Заказ успешно обновлен');
                return $this->refresh();
            }
        } catch (\Exception $e) {
            Alert::setErrorNotify($e->getMessage());
            Debug::printFile($this->service->getErrors());
            return $this->refresh();
        }

        return $this->render('update', [
            'itemsModel' => $itemsModel,
            'dateDelivery' => $dateDelivery,
            'users' => $users,
            'model' => $model,
            'deliveries' => $deliveries,
            'payments' => $payments,
            'status' => $status,
            'trackForm' => $trackForm,
        ]);
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('removeOrder') and Yii::$app->user->id != 1) throw new ForbiddenHttpException('У вас нет разрешения на эту операцию');

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
        $sheet->setCellValue('A1', sprintf('Товарная накладная №%s от %s', $order->id, date('d.m.Y', $order->created_at)));
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Кто продал
        $sheet->setCellValue('A3', 'Продавец');
        $sheet->setCellValue('B3', 'ООО Интернет-зоомагазин Котофей');
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->setCellValue('B4', sprintf('Адрес г. Барнаул, ул. Весеняя, дом 4. Телефон: %s, Сайт %s', SiteSettings::getValueByCode('phone_1'), System::fullSiteUrl()));
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
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename={$file_name}");
        $writer->save('php://output');
        exit();
    }

    public function actionGroup()
    {
        $groupedData = GroupBuyDataService::getInstance()->load_data();
        return $this->render('group', [
            'groupedData' => $groupedData
        ]);
    }

    public function actionExport()
    {
        $delimiter = ";";
        $f = fopen('php://memory', 'w');
        $filename = date('dmYhis') . " - email-export.csv";

        $orders = Order::find()
            ->select(['id', 'email', 'created_at'])
            ->where(['!=', 'email', ''])
//            ->andWhere(['in', 'created_at', Order::find()->select('MAX(created_at)')->groupBy('email')])
//            ->andWhere(['<', 'created_at', strtotime('-2 month')])
            ->asArray(true);


        $orders = $orders->all();


        foreach ($orders as $order) {
//            echo $order['email'] . " - " . date('d.m.Y', $order['created_at']);
//            echo "<br>";
            fputcsv($f, [$order['email']], $delimiter);
        }

        fseek($f, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);
    }

    public function actionPaymentLink($id)
    {
        $order = Order::findOne($id);
        $module = \Yii::$app->getModule('acquiring');

//        $paters = AcquiringOrder::find()->where(['order_id' => $id])->all();
//        $uniq_key = count($paters) > 0 ? count($paters) : 1;

        if (AcquiringOrder::findOne(['order_id' => $id])) {
            Alert::setSuccessNotify('Ссылка на оплату уже существует. Удалите старую.');
            return $this->redirect(['update', 'id' => $id]);
        }

        //settings
        $login = "";
        $password = "";

        if ($module->mode != 'off' && YII_ENV == 'dev') {
            $login = $module->test_login;
            $password = $module->test_password;
        }

        if ($module->mode != 'off' && YII_ENV == 'prod') {
            $login = $module->real_login;
            $password = $module->real_password;
        }

        if ($module->mode == 'off') throw new \Exception('В настройках сайта отключена работа Эквайринга, измените значение mode_acquiring в настройках сайта.');

        $terminal = new AcquiringTerminalService(new Sberbank(new SberbankAuthBasic($login, $password)));
        $result = $terminal->reInitCreateOrder($order, 'reorder' . time());

        try {
            if (!isset($result['orderId']) || !isset($result['formUrl'])) return $result;
            $successSaveEquiring = $terminal->saveHistoryPaymentTransaction($order, $result['orderId']);
            if ($successSaveEquiring['status'] == 200) Alert::setSuccessNotify('Ссылка на оплату создана');
        } catch (\InvalidArgumentException $exception) {
            LogService::saveErrorMessage("Ошибка при создании ссылки оплаты для заказа #{$order->id}. Ответ Банка: " . print_r($result, true), 'payment-link');
            Alert::setErrorNotify('Не удалось создать ссылку. Посмотреть логи');
        }

        return $this->redirect(['update', 'id' => $order->id]);
    }

    private function getUsers()
    {
        return UserRepository::getAll();
    }

    private function getDeliveries()
    {
        return DeliveryRepository::getAll();
    }

    private function getPayments()
    {
        return PaymentRepository::getAll();
    }

    private function getStatuses()
    {
        return OrderStatusRepository::getAll();
    }
}
