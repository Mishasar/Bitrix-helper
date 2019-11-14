<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CPrice;

Loader::includeModule('iblock');
Loader::includeModule('catalog');

/*
 * Class CatalogHelper
 * Класс-помощник
 */

class CatalogHelper
{

    /**
     * Возвращает наименьшую и скидочную цены
     *
     * @param $productId
     *
     * @return array
     */
    public static function getElementPrice($productId)
    {
        $minimumPrice = null;
        $resultPriceArray = [];
        $arPrices = [];

        $priceResult = CPrice::GetList(
            [],
            [
                "PRODUCT_ID" => $productId,
            ]
        );

        while ($arPrices[] = $priceResult->Fetch()) {
        } //FetchAll

        foreach ($arPrices as $price) {
            if ($price['CATALOG_GROUP_ID'] != SALE_PRICE_ID) { //Цену со скидкой возвращаем отдельно
                if ($price['CAN_BUY'] == "Y") {
                    if (empty($minimumPrice)) {
                        $minimumPrice = $price['PRICE'];
                        $resultPriceArray['NORMAL_PRICE'] = $price;
                    }

                    if ($minimumPrice > $price['PRICE']) {
                        $minimumPrice = $price['PRICE'];
                        $resultPriceArray['NORMAL_PRICE'] = $price;
                    }

                }
            } else {
                $resultPriceArray['SALE_PRICE'] = $price;
            }
        }

        return $resultPriceArray;
    }

    /**
     * Возвращает наличие на 2 складах
     *
     * @param $productId
     *
     * @return array
     */
    public static function getStoreAmount($productId, $storeIds = [])
    {
        $arStore = [];
        $storeRes = \CCatalogStoreProduct::GetList(
            ["SORT" => "ASC"],
            [
                "PRODUCT_ID" => $productId,
                "STORE_ID" => $storeIds
            ],
            false,
            false,
            ["*"]
        );


        while ($store = $storeRes->Fetch()) {
            $arStore[$store['STORE_ID']] = $store;
        }; //FetchAll

        return $arStore;
    }

    /**
     * Возвращает величину скидки
     *
     * @param $price
     * @param $priceSale
     *
     * @return int
     */
    public static function getSale($price, $priceSale)
    {
        return (int)(($price / $priceSale) * 100);
    }

    /**
     * Возвращает отсортированные по шаблону свойства
     *
     * @param $arProps
     *
     * @return array
     */
    public static function sortProperties($arProps)
    {
        $arResult = [];
        $arResult['WITHOUT_SECTION'][0]['FIELDS'] = $arProps;

        foreach (PROPERTIES_SECTION as $key => $section) {
            foreach ($section['FIELDS'] as $fieldCode) {
                if (array_key_exists($fieldCode, $arResult['WITHOUT_SECTION'][0]['FIELDS'])) {
                    $arResult['WITH_SECTION'][$key]['FIELDS'][$fieldCode] = $arResult['WITHOUT_SECTION'][0]['FIELDS'][$fieldCode];
                    unset($arResult['WITHOUT_SECTION'][0]['FIELDS'][$fieldCode]);

                    if (empty($arResult['WITH_SECTION'][$key]['NAME'])) {
                        $arResult['WITH_SECTION'][$key]['NAME'] = $section['NAME'];
                    }
                }
            }
        }

        return $arResult;
    }

    public static function getPresentation($sectionId)
    {
        $rsSect = \CIBlockSection::GetList([],
            ['IBLOCK_ID' => IB_CATALOG, 'ID' => $sectionId],
            false,
            ['ID', 'NAME', 'CODE', 'UF_PRESENTATION']);

        $data = $rsSect->GetNext();

        return \CFile::GetPath($data['UF_PRESENTATION']);
    }
}



