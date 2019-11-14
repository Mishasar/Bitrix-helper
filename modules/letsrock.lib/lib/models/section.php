<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;

Loader::includeModule('iblock');

/**
 * Класс для работы с разделами инфоблока
 * Class Section
 *
 * @package Letsrock\Lib\Models
 */
class Section
{

    /**
     * Метод для получения списка разделов инфоблока
     *
     * @param $iblock
     * @param array $select
     * @param $filter
     * @param array $order
     *
     * @return array
     */
    public static function getList(
        $iblock,
        $select = ['ID', 'NAME', 'CODE'],
        $filter = ['ACTIVE' => 'Y'],
        $order = ['SORT' => 'ASC']
    ) {

        $filter[] = ['IBLOCK_ID' => $iblock];

        $rsSect = \CIBlockSection::GetList($order, $filter, false, $select);
        $data = [];;
        while ($arSect = $rsSect->GetNext()) {
            $data[] = $arSect;
        }

        return $data;
    }
}
