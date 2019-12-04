<?php

namespace Letsrock\Lib\Controllers;

use Bitrix\Main\Loader;
use CFile;
use CIBlockElement;
use CSearch;

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
        $productsByArticles = self::searchByArticle($request['search']);

        if ($productsByArticles) {
            echo Controller::sendAnswer(['ITEMS' => $productsByArticles]);
        } else {
            echo Controller::sendAnswer(['ITEMS' => self::standartSearch($request['search'])]);
        }
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
            $arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM", 'PREVIEW_PICTURE'];
            $arFilter = ["IBLOCK_ID" => IntVal(IB_CATALOG), 'ID' => $idsProducts];
            $res = CIBlockElement::GetList([], $arFilter, false, ["nPageSize" => 10], $arSelect);

            while ($ob = $res->GetNextElement()) {
                $item = $ob->GetFields();
                $item['PICTURE'] = CFile::ResizeImageGet($item['PREVIEW_PICTURE'],
                    ["width" => 150, "height" => 150], BX_RESIZE_IMAGE_PROPORTIONAL);
                $arResult[] = $item;
            }
        }

        return $arResult;
    }

    /**
     * Поиск по артиклу
     *
     * @param string $query
     *
     * @return array
     */
    public static function searchByArticle(string $query): array
    {
        $arResult = [];
        $arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM", 'PREVIEW_PICTURE'];
        $arFilter = ["IBLOCK_ID" => IntVal(IB_CATALOG), '=PROPERTY_' . PROPERTY_ARTICLES => $query];
        $res = CIBlockElement::GetList([], $arFilter, false, ["nPageSize" => 1], $arSelect);

        while ($ob = $res->GetNextElement()) {
            $item = $ob->GetFields();
            $item['PICTURE'] = CFile::ResizeImageGet($item['PREVIEW_PICTURE'],
                ["width" => 150, "height" => 150], BX_RESIZE_IMAGE_PROPORTIONAL);
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
        $arResult = self::searchByArticle($query);

        if (!$arResult) {
            $arResult = Controller::sendAnswer(['ITEMS' => self::standartSearch($query)]);
        }

        foreach ($arResult as $result) {
            $ids[] = $result['ID'];
        }

        return $ids;
    }
}