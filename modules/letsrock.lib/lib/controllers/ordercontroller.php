<?php

namespace Letsrock\Lib\Controllers;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Order;
use CFile;
use CIBlockElement;
use Letsrock\Lib\Models\CatalogHelper;

Loader::includeModule('sale');
Loader::includeModule("catalog");

/*
 * Class OrderController
 * Контроллер заказа
 */

class OrderController extends Controller
{
    /**
     * Возвращает слдержимое заказа по ID, группирует по складам
     * Группировка - задел на будущее
     *
     * @param $orderId
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentNullException
     */
    public static function getOrder($orderId)
    {
        $arItems = [];
        $productIds = [];
        $arProducts = [];
        $order = Order::load($orderId);
        $basket = $order->getBasket();
        $basketItems = $basket->getBasketItems();

        //Получаем статус текущего заказа
        $statuses = self::getOrdersStatuses();
        $orderStatus = $statuses[$order->getField('STATUS_ID')];

        foreach ($basketItems as &$item) {
            $basketPropertyCollection = $item->getPropertyCollection();
            $props = $basketPropertyCollection->getPropertyValues();

            if (!empty($props['STOCK']['VALUE'])) {
                $productId = $item->getField('PRODUCT_ID');
                $productIds[] = $productId;
                $arItems[$props['STOCK']['VALUE']][$productId] = [];

                //Складов всегда будет 2, поэтому без задела на будущее
                if ($props['STOCK']['VALUE'] == STORE_BARNAUL_ID) {
                    $arItems[$props['STOCK']['VALUE']]['STOCK_CITY'] = 'Барнаул';
                } else {
                    $arItems[$props['STOCK']['VALUE']]['STOCK_CITY'] = 'Москва';
                }

                $arItems[$props['STOCK']['VALUE']]['PRODUCTS'][$productId]['BASKET_PRODUCT'] = $item->getFields()->getValues();
            }
        }

        //Получаем дополнительные свойства товара для вывода в корзине
        $ob = CIBlockElement::GetList(
            $productIds,
            ['IBLOCK_ID' => IB_CATALOG, 'ID' => $productIds],
            false, false,
            [
                'ID',
                'IBLOCK_ID',
                'NAME',
                'PREVIEW_PICTURE',
                "DETAIL_PAGE_URL",
                PROPERTY_ARTICLES
            ]
        );

        while ($item = $ob->GetNextElement()) {
            $arFields = $item->GetFields();
            $arFields['PREVIEW_PICTURE'] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"],
                ["width" => 64, "height" => 64], BX_RESIZE_IMAGE_PROPORTIONAL);

            if (empty($arFields[PROPERTY_ARTICLES . '_VALUE'])) {
                $arFields['ARTICLE'] = $arFields[PROPERTY_ARTICLES . '_VALUE'];
            } else {
                $arFields['ARTICLE'] = false;
            }

            $arProducts[$arFields['ID']] = $arFields;
        }

        //Соединяем найденные товары и товары в корзине
        //Один товар может быть заказан с 2 складов
        foreach ($arItems as $stockId => &$arStock) {
            $weight = 0;
            $volume = 0;
            $cost = 0;

            foreach ($arStock['PRODUCTS'] as $productId => &$arProduct) {
                $product = $arProducts[$productId];
                $arProduct['PRODUCT_INFORMATION'] = $product;
                $arProduct['STOCK'] = current(CatalogHelper::getStoreAmount($productId, $stockId));
                $weight += $product['PROPERTY_VES_ZA_EDENITSU_VALUE'];
                $volume += $product['PROPERTY_OBEM_ZA_EDENITSU_VALUE'];
                $cost += $arProduct['BASKET_PRODUCT']['BASE_PRICE'] * $arProduct['BASKET_PRODUCT']['QUANTITY'];
            }
        }

        return [
            'ITEMS' => $arItems,
            'STATUS' => $orderStatus
        ];
    }

    /**
     * AJAX
     * Повторяет заказ по ID
     *
     * @param $request
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public static function repeat($request)
    {
        global $USER;
        $order_id = $request['ORDER_ID'];
        $siteId = Context::getCurrent()->getSite();
        $order = Order::loadByAccountNumber($order_id);
        $currencyCode = Option::get('sale', 'default_currency', 'RUB');
        $basket = $order->getBasket();
        $shipmentCollection = $order->getShipmentCollection();

        foreach ($shipmentCollection as $shipment) {
            if ($shipment->isSystem()) {
                continue;
            }
        }

        $orderNew = Order::create($siteId, $USER->GetID());
        $orderNew->setPersonTypeId(2);
        $basketNew = Basket::create($siteId);

        foreach ($basket as $key => $basketItem) {
            $item = $basketNew->createItem('catalog', $basketItem->getProductId());
            $basketPropertyCollection = $basketItem->getPropertyCollection();
            $basketProperties = $basketPropertyCollection->getPropertyValues();
            $itemPropertyCollection = $item->getPropertyCollection();

            $item->setFields([
                'QUANTITY' => $basketItem->getQuantity(),
                'CURRENCY' => $currencyCode,
                'LID' => $siteId,
                'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider'
            ]);

            $itemPropertyCollection->redefine([
                ['NAME' => 'Склад', 'CODE' => 'STOCK', 'VALUE' => $basketProperties['STOCK']['VALUE']],
            ]);

            $basketPropertyCollection->save();
        }

        $orderNew->setBasket($basketNew);
        $orderNew->setField('CURRENCY', $currencyCode);
        $orderNew->doFinalAction(true);
        $r = $orderNew->save();

        if (!$r->isSuccess()) {
            echo Controller::sendError(current($r->getErrorMessages()));
        } else {
            echo Controller::sendAnswer();
        }
    }

    /**
     * Возвращает список заказов по  текущего ползователя
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getOrders()
    {
        global $USER;
        return self::getOrdersByUser($USER->GetID());
    }

    /**
     * Возвращает список заказов по ID пользователя
     *
     * @param string $userId
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getOrdersByUser(string $userId)
    {
        $statuses = self::getOrdersStatuses();
        $orders = [];
        $arFilter = [
            "USER_ID" => $userId
        ];

        $dbRes = \Bitrix\Sale\Order::getList([
            'order' => ['DATE_INSERT' => 'DESC'],
            'filter' => $arFilter
        ]);

        while ($order = $dbRes->fetch()) {
            $order['STATUS'] = $statuses[$order['STATUS_ID']];
            $orders[] = $order;
        }

        return $orders;
    }

    /**
     * Возвращает статусы заказов
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getOrdersStatuses()
    {

        $statuses = [];

        $statusResult = \Bitrix\Sale\Internals\StatusLangTable::getList([
            'order' => ['STATUS.SORT' => 'ASC'],
            'filter' => ['STATUS.TYPE' => 'O', 'LID' => LANGUAGE_ID],
            'select' => ['STATUS_ID', 'NAME', 'DESCRIPTION'],
        ]);

        while ($status = $statusResult->fetch()) {
            $statuses[$status['STATUS_ID']] = $status;
        }

        return $statuses;
    }

    /**
     * Обработчик события смены статуса
     *
     * @param \Bitrix\Main\Event $event
     *
     * @return \Bitrix\Main\EventResult
     */
    public static function orderBonusHandler(\Bitrix\Main\Event $event) {
        $parameters = $event->getParameters();
        if ($parameters['VALUE'] === 'F') {
            /** @var \Bitrix\Sale\Order $order */
            $order = $parameters['ENTITY'];

        }

        return new \Bitrix\Main\EventResult(
            \Bitrix\Main\EventResult::SUCCESS
        );
    }
}