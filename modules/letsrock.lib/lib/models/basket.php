<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CFile;
use CIBlockElement;

Loader::includeModule('iblock');

/*
 * Class Basket
 * Класс для работы с товарами в корзине
 */

class Basket
{


    /**
     * Метод получения данных в корзине
     *
     * @param null $order
     * @param string $delay
     *
     * @return array
     */
    public static function getBasket(
        $order = null,
        $delay = 'N',
        $select = [
            'ID',
            'CALLBACK_FUNC',
            'MODULE',
            'PRODUCT_ID',
            'QUANTITY',
            'DELAY',
            'CAN_BUY',
            'PRICE',
            'WEIGHT'
        ],
        $sort = [
            'NAME' => 'ASC',
            'ID' => 'ASC'
        ]

    ) {
        $arBasketItems = [];
        $dbBasketItems = \CSaleBasket::GetList(
            $sort,
            [
                'FUSER_ID' => \CSaleBasket::GetBasketUserID(),
                'LID' => SITE_ID,
                'ORDER_ID' => $order,
                'DELAY' => $delay
            ],
            false,
            false,
            $select
        );
        $i = 0;
        $cartCount = null;
        $cartSum = null;
        while ($arItems = $dbBasketItems->Fetch()) {
            $arBasketItems[$i] = $arItems;
            $arBasketItems[$i]['ITEM'] = \CIBlockElement::GetByID($arItems['PRODUCT_ID'])->GetNext();
            $cartCount += $arItems['QUANTITY'];
            $cartSum += $arItems['PRICE'] * $arItems['QUANTITY'];
            $i++;
        }

        if (!empty($cartCount)) {
            $arBasketItems['COUNT'] = $cartCount;
        } else {
            $arBasketItems['COUNT'] = 0;
        }

        if (!empty($cartSum)) {
            $arBasketItems['SUM'] = $cartSum;
        } else {
            $arBasketItems['SUM'] = 0;
        }

        return $arBasketItems;

    }

    /**
     * Метод добавления товара в корзину
     *
     * @param int $productId
     * @param int $quantity
     *
     * @return bool
     */
    public static function add(
        $productId,
        $quantity = 1
    ) {

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(),
            \Bitrix\Main\Context::getCurrent()->getSite());

        $noExists = true;

        foreach ($basket as $basketItem) {
            if ($basketItem->getField('PRODUCT_ID') == $productId && !$basketItem->isDelay()) {
                $noExists = false;
                $basketItem->setField('QUANTITY', $basketItem->getQuantity() + $quantity);
            }
        }

        if ($noExists) {
            $item = $basket->createItem('catalog', $productId);
            $elementInfo = \CIBlockElement::GetByID($productId)->fetch();
            $item->setFields([
                'QUANTITY' => $quantity,
                'DELAY' => 'N',
                'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
                'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                'PRODUCT_XML_ID' => $elementInfo['EXTERNAL_ID'],
                'CATALOG_XML_ID' => $elementInfo['IBLOCK_EXTERNAL_ID']
            ]);
        }

        $basket->save();

        return true;

    }

    /**
     * Метод добавления добавления товара в отложенные
     *
     * @param int $productId
     *
     * @return bool
     */
    public static function delay($productId)
    {

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(),
            \Bitrix\Main\Context::getCurrent()->getSite());

        $item = $basket->createItem('catalog', $productId);
        $elementInfo = \CIBlockElement::GetByID($productId)->fetch();
        $item->setFields([
            'QUANTITY' => '1',
            'DELAY' => 'Y',
            'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
            'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
            'PRODUCT_XML_ID' => $elementInfo['EXTERNAL_ID'],
            'CATALOG_XML_ID' => $elementInfo['IBLOCK_EXTERNAL_ID']
        ]);

        $basket->save();

        return true;

    }

    /**
     * Метод добавления удаления товара из корзины
     *
     * @param int $productId
     *
     * @return bool
     */
    public static function delete($productId)
    {

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(),
            \Bitrix\Main\Context::getCurrent()->getSite());

        foreach ($basket as $basketItem) {
            if ($basketItem->getField('PRODUCT_ID') == $productId && !$basketItem->isDelay()) {
                $basket->getItemById($basketItem->getId())->delete();
            }
        }

        $basket->save();

        return true;

    }

    /**
     * Метод добавления удаления товара из отложенных
     *
     * @param int $productId
     *
     * @return bool
     */
    public static function deleteDelay($productId)
    {
        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(),
            \Bitrix\Main\Context::getCurrent()->getSite());

        foreach ($basket as $basketItem) {
            if ($basketItem->getField('PRODUCT_ID') == $productId && $basketItem->isDelay()) {
                $basket->getItemById($basketItem->getId())->delete();
            }
        }

        $basket->save();

        return true;

    }

    /**
     * Метод возвращает содержимое корзины разделённое по 2 складам
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function getBasketByStocks()
    {
        $arItems = [];
        $productIds = [];
        $arProducts = [];
        $common = [];
        $common['WEIGHT'] = 0;
        $common['VOLUME'] = 0;
        $common['COST'] = 0;

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
            \Bitrix\Sale\Fuser::getId(),
            \Bitrix\Main\Context::getCurrent()->getSite()
        );

        $basketItems = $basket->getBasketItems();

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
                "PROPERTY_VES_ZA_EDENITSU",
                "PROPERTY_OBEM_ZA_EDENITSU"
            ]
        );

        while ($item = $ob->GetNextElement()) {
            $arFields = $item->GetFields();
            $arFields['PREVIEW_PICTURE'] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"],
                ["width" => 64, "height" => 64], BX_RESIZE_IMAGE_PROPORTIONAL);
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

            //У каждого склада выводится цену, вес, стоимость
            $arStock['WEIGHT'] = $weight;
            $arStock['VOLUME'] = $volume;
            $arStock['COST'] = $cost;

            //Общие для корзины цены, вес, стоимость
            $common['WEIGHT'] += $weight;
            $common['VOLUME'] += $volume;
            $common['COST'] += $cost;
        }

        return [
            'STOCKS' => $arItems,
            'COMMON' => $common
        ];
    }


}