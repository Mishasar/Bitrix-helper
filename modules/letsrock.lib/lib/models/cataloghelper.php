<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CIBlockProperty;
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
     * @param array $arProps
     *
     * @return array
     */
    public static function sortProperties(array $arProps): array
    {
        $arResult = [];
        $arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'] = $arProps;

        foreach (PROPERTIES_SECTION as $key => $section) {
            foreach ($section['FIELDS'] as $fieldCode) {
                if (!in_array($fieldCode, INVISIBLE_PROPS)) {
                    if (array_key_exists($fieldCode, $arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'])) {
                        $arResult['VIEW']['WITH_SECTION'][$key]['FIELDS'][$fieldCode] = $arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'][$fieldCode];
                        unset($arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'][$fieldCode]);

                        if (empty($arResult['VIEW']['WITH_SECTION'][$key]['NAME'])) {
                            $arResult['VIEW']['WITH_SECTION'][$key]['NAME'] = $section['NAME'];
                        }
                    }
                } else {
                    $arResult['HIDDEN']['FIELDS'][$fieldCode] = $arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'][$fieldCode];
                    unset($arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'][$fieldCode]);
                }
            }
        }

        foreach ($arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'] as $fieldCode => $fieldValue) {
            if (in_array($fieldCode, INVISIBLE_PROPS)) {
                $arResult['HIDDEN']['FIELDS'][$fieldCode] = $arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'][$fieldCode];
                unset($arResult['VIEW']['WITHOUT_SECTION'][0]['FIELDS'][$fieldCode]);
            }
        }

        return $arResult;
    }

    /**
     * Убирает точку в названии свойства
     *
     * @param $propName
     *
     * @return mixed
     */
    public static function getClearName(string $propName): string
    {
        if ($propName{0} == ".") {
            $propName{0} = "";
        }

        return $propName;
    }

    /**
     * Возвращает цвет свечения в процентах для построения шкалы
     *
     * @param string $propValue
     *
     * @return int
     */
    public static function getLightPosition(string $propValue): int
    {
        if (empty($propValue)) {
            return 0;
        }

        $lightDeg = intval($propValue);
        $lightDeg = $lightDeg - COLOR_LIGHT_LEFT_BORDER_DEG;

        return (int)(($lightDeg / (COLOR_LIGHT_RIGHT_BORDER_DEG - COLOR_LIGHT_LEFT_BORDER_DEG)) * 100);
    }

    /**
     * Возвращает артикул по ИД товара
     *
     * @param array $propsArray
     *
     * @return string
     */
    public static function getArticles(array $propsArray): string
    {
        return $propsArray['HIDDEN']['FIELDS'][PROPERTY_ARTICLES]['VALUE'][2];
    }

    /**
     * Возвращает прикреплённые продукты
     *
     * @param array $propsArray
     *
     * @return array
     */
    public static function getAssociatedProducts(array $propsArray): array
    {
        if (!empty($propsArray['HIDDEN']['FIELDS'][PROPERTY_ASSOCIATED_PRODUCTS]['VALUE'])) {
            return explode(',', $propsArray['HIDDEN']['FIELDS'][PROPERTY_ASSOCIATED_PRODUCTS]['VALUE']);
        }

        return [];
    }

    /**
     * Возвращает значение свойства новоинка
     *
     * @param array $propsArray
     *
     * @return bool
     */
    public static function productIsNew(array $propsArray): bool
    {
        if (!empty($propsArray['HIDDEN']['FIELDS'][PROPERTY_NEW])) {
            return (bool)$propsArray['HIDDEN']['FIELDS'][PROPERTY_NEW]['VALUE'];
        }

        return false;
    }

    /**
     * Возвращает презентацию для раздела
     *
     * @param $sectionId
     *
     * @return string|null
     */
    public static function getPresentation($sectionId)
    {
        $rsSect = \CIBlockSection::GetList([],
            ['IBLOCK_ID' => IB_CATALOG, 'ID' => $sectionId],
            false,
            ['ID', 'NAME', 'CODE', 'UF_PRESENTATION']);

        $data = $rsSect->GetNext();

        return \CFile::GetPath($data['UF_PRESENTATION']);
    }

    /**
     * Возвращает коды нужных свойств (начинающихся с точки)
     *
     * @return array
     */
    public static function getAvailableProps(): array
    {
        $foundProps = [];
        $properties = CIBlockProperty::GetList([],
            ["ACTIVE" => "Y", "IBLOCK_ID" => IB_CATALOG]);
        while ($prop = $properties->GetNext()) {
            if ($prop["NAME"][0] == '.') {
                $foundProps[] = $prop["CODE"];
            }
        }

        $foundProps = array_merge($foundProps, INVISIBLE_PROPS);

        return $foundProps;
    }
}



