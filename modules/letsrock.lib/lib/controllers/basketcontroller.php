<?php

namespace Letsrock\Lib\Controllers;

use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Order;

Loader::includeModule('sale');
Loader::includeModule("catalog");

/*
 * Class BasketController
 * Контроллер корзины
 */

class BasketController extends Controller
{
    /**
     * AJAX
     * Добавляет товар в корзину
     * Возвращает рендер компонента складов
     *
     * @param $request
     *
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public function addByStore($request)
    {
        $stockCode = [];
        ob_start();
        global $APPLICATION;
        $APPLICATION->IncludeComponent("letsrock:store",
            ".default",
            [
                'PRODUCT_ID' => $request['PRODUCT_ID'],
                'CACHE_TIME' => 0
            ]
        );
        $stockCode['STOCK_HTML'] = ob_get_contents();
        ob_end_clean();

        self::add($request, $stockCode);
    }

    /**
     * AJAX
     * Добавляет товар в корзину
     *
     * @param $request
     * @param bool $additionalFields
     *
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public static function add($request, $additionalFields = false)
    {
        $quantity = $request['QUANTITY'];
        $productId = $request['PRODUCT_ID'];
        $stock = $request['STOCK_ID'];
        $fields = [
            'PRODUCT_ID' => $productId,
            'QUANTITY' => $quantity,
            'PROPS' => [
                ['NAME' => 'Склад', 'CODE' => 'STOCK', 'VALUE' => $stock],
            ],

        ];

        $result = \Bitrix\Catalog\Product\Basket::addProduct($fields);

        if (!$result->isSuccess()) {
            echo Controller::sendError($result->getErrorMessages());
        } else {
            if ($additionalFields) {
                echo Controller::sendAnswer($additionalFields);
            } else {
                echo Controller::sendAnswer();
            }
        }
    }

    /**
     * AJAX
     * Устанавливает количество товара
     *
     * @param $request
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\NotSupportedException
     */
    public static function setQuantity($request)
    {
        $quantity = $request['QUANTITY'];
        $basketId = $request['BASKET_ID'];
        $type = $request['TYPE'];

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(),
            \Bitrix\Main\Context::getCurrent()->getSite());

        $basket->getItemById($basketId)->setFields(["QUANTITY" => $quantity]);
        $basket->save();

        self::getRenderBasket($type);
    }

    /**
     * AJAX
     * Удаляет элемент корзины
     *
     * @param $request
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public static function removeItem($request)
    {
        $type = $request['TYPE'];
        $basketId = $request['BASKET_ID'];
        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(),
            \Bitrix\Main\Context::getCurrent()->getSite());
        $basket->getItemById($basketId)->delete();
        $basket->save();

        self::getRenderBasket($type);
    }

    /**
     * Отдаёт рендеренную корзину
     *
     * @param $type
     */
    public static function getRenderBasket($type)
    {
        $template = '.default';

        switch ($type) {
            case 'order' :
                $template = 'order';
        }

        $stockCode = [];
        ob_start();
        global $APPLICATION;
        $APPLICATION->IncludeComponent("letsrock:basket",
            $template,
            ['CACHE_TIME' => 0]
        );
        $stockCode['BASKET_HTML'] = ob_get_contents();
        ob_end_clean();

        echo Controller::sendAnswer($stockCode);
    }

    /**
     * AJAX
     * Оформление заказа
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
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function order($request)
    {
        global $USER;

        if ($USER->isAuthorized()) {
            $comment = $request["comment"];
            $siteId = Context::getCurrent()->getSite();
            $currencyCode = CurrencyManager::getBaseCurrency();

            // Создаём новый заказ
            $order = Order::create($siteId, $USER->GetID());
            $order->setPersonTypeId(2);
            $order->setField('CURRENCY', $currencyCode);

            if ($comment) {
                $order->setField('USER_DESCRIPTION', $comment);
            }

            $basket = Basket::loadItemsForFUser($USER->GetID(), $siteId);
            $order->setBasket($basket);

            // Устанавливаем свойства
            $propertyCollection = $order->getPropertyCollection();

            foreach ($propertyCollection->getGroups() as $group) {
                foreach ($propertyCollection->getPropertiesByGroupId($group['ID']) as $property) {
                    $prop = $property->getProperty();

                    switch ($prop["CODE"]) {
                        case "COMPANY":
                            $property->setValue($request['company']);
                            break;

                        case "CITY":
                            $property->setValue($request['city']);
                            break;

                        case "ADDRESS":
                            $property->setValue($request['address']);
                            break;

                        case "CONTACT_PERSON":
                            $property->setValue($request['name']);
                            break;

                        case "INN":
                            $property->setValue($request['inn-passport']);
                            break;
                    }
                }
            }

            // Сохраняем
            $order->doFinalAction(true);
            $result = $order->save();
            $orderId = $order->getId();

            if (!$result->isSuccess()) {
                echo Controller::sendError(current($result->getErrorMessages()));
            } else {
                echo Controller::sendAnswer([
                    'ORDER_ID' => $orderId
                ]);
            }
        }
    }
}