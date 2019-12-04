<?php

namespace Letsrock\Lib\Controllers;

use Bitrix\Main\Loader;
use CFile;
use CIBlockElement;
use CSearch;
use Letsrock\Lib\Models\CatalogHelper;

Loader::includeModule("search");


/**
 * Class SearchController
 * Контроллер поиска
 */
class SearchController extends Controller
{
    /**
     * AJAX
     * Стандартный поиск и по артикулам
     *
     * @param $request
     */
    public static function search(array $request)
    {
        global $USER;
        $productsByArticles = self::getProducts(['ARTICLE' => $request['search']]);

        if (!$productsByArticles) {
            $productsByArticles = self::standartSearch($request['search']);
        }

        echo Controller::sendAnswer(['ITEMS' => $productsByArticles, 'AUTH' => $USER->IsAuthorized()]);
    }

    /**
     * Стандартный поиск. Не находит артикул
     *
     * @param string $query
     *
     * @return array
     */
    public static function standartSearch(string $query): array
    {
        $idsProducts = [];
        $arResult = [];

        $obSearch = new CSearch;
        //мы добавили еще этот параметр, чтобы не ругался на форматирование запроса
        $obSearch->SetOptions([
            'ERROR_ON_EMPTY_STEM' => false,
        ]);

        $obSearch->Search([
            'QUERY' => $query,
            'SITE_ID' => SITE_ID,
            'MODULE_ID' => 'iblock',
            'PARAM1' => 'catalog',
            'PARAM2' => IB_CATALOG
        ]);

        //делаем резапрос с отключенной морфологией
        if (!$obSearch->selectedRowsCount()) {
            $obSearch->Search([
                'QUERY' => $query,
                'SITE_ID' => SITE_ID,
                'MODULE_ID' => 'iblock',
                'PARAM1' => 'catalog',
                'PARAM2' => IB_CATALOG
            ], [], ['STEMMING' => false]);
        }

        while ($row = $obSearch->fetch()) {
            $idsProducts[] = $row['ITEM_ID'];
        }

        if (!empty($idsProducts)) {
            $arResult = self::getProducts(['IDS' => $idsProducts]);
        }

        return $arResult;
    }

    /**
     * Поиск по артиклу
     *
     * @param array $params Массив параметров
     *
     * @return array
     */
    private static function getProducts(array $params): array
    {

        $arFilter = ["IBLOCK_ID" => IntVal(IB_CATALOG)];

        if (!empty($params['IDS'])) {
            $arFilter['ID'] = $params['IDS'];
        }

        if (!empty($params['ARTICLE'])) {
            $arFilter['=PROPERTY_' . PROPERTY_ARTICLES] = $params['ARTICLE'];
        }

        $arResult = [];
        $arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM", 'PREVIEW_PICTURE', 'DETAIL_PAGE_URL'];
        $res = CIBlockElement::GetList([], $arFilter, false, ["nPageSize" => 10], $arSelect);

        while ($ob = $res->GetNextElement()) {
            $item = $ob->GetFields();
            $item['PICTURE'] = CFile::ResizeImageGet($item['PREVIEW_PICTURE'],
                ["width" => 150, "height" => 150], BX_RESIZE_IMAGE_PROPORTIONAL);
            $price = CatalogHelper::getElementPrice($item['ID']);

            if (!empty($price)) {
                $item['PRICE'] = CurrencyFormat((CatalogHelper::getElementPrice($item['ID']))['NORMAL_PRICE']['PRICE'],
                    "RUB");
            } else {
                $item['PRICE'] = '-';
            }

            $arResult[] = $item;
        }

        return $arResult;
    }

    /**
     * Возвращает массив ID для дальнейшего использования
     *
     * @param string $query
     *
     * @return array
     */
    public static function getIdsArrayByQuery(string $query): array
    {
        $ids = [];
        $arResult = self::getProducts(['ARTICLE' => $query]);

        if (!$arResult) {
            $arResult = self::standartSearch($query);
        }

        foreach ($arResult as $result) {
            $ids[] = $result['ID'];
        }

        return $ids;
    }
}