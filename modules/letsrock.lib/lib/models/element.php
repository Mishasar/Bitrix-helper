<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;

Loader::includeModule('iblock');



/*
 * Class Element
 * Класс для работы с элементами инфоблока
 */

class Element
{

    /**
     * Метод вывода списка элементов инфоблока
     * @param $iblock
     * @param array $select
     * @param array $filter
     * @param array $sort
     * @param bool $nav
     * @param bool $groupBy
     * @return array|string
     */
    public static function getList(
        $iblock,
        $select = array('*'),
        $filter = array('ACTIVE_DATE' => 'Y', 'ACTIVE' => 'Y'),
        $sort = array('SORT' => 'DESC'),
        $nav = false,
        $groupBy = false
    )
    {

        if (empty($iblock))
            return 'Ошибка! В вызове ' . __METHOD__ . ' отсутствует обязательный параметр iblock';

        $filter[] = array('IBLOCK_ID' => $iblock);

        if(!empty($nav) && is_int($nav))
            $nav = array('nPageSize'=>$nav);

        $res = \CIBlockElement::GetList($sort, $filter, $groupBy, $nav, $select);
        $data = array();
        while ($ob = $res->GetNextElement()) {
            $data[] = $ob->GetFields();
        }

        return $data;
    }

    /**
     * Метод получения элемента по ID
     * @param int $iblock
     * @param int $id
     * @param array $select
     * @param bool $props
     * @return array
     */
    public static function getById($iblock, $id, $select = array('*'), $props = false){

        if (empty($iblock) || empty($id))
            return 'Ошибка! В вызове ' . __METHOD__ . ' отсутствуют обязательные параметр iblock и/или id';

        $filter = Array("IBLOCK_ID" => $iblock, "ID" => $id);
        $res = \CIBlockElement::GetList(array(), $filter, false, array('nPageSize' => 1), $select);
        $ob = $res->GetNextElement();
        $data = $ob->GetFields();

        if($props)
           $data['PROPERTY'] = $ob->GetProperties();

        return $data;
    }

    /**
     * Метод-алиас getById
     * @param int $iblock
     * @param int $id
     * @param array $select
     * @param array $props
     * @return array
     */
    public static function getId($iblock, $id, $select, $props){
        return self::getById($iblock, $id, $select, $props);
    }

    /**
     * Метод добавления нового элемента инфоблока
     * @param int $iblock
     * @param array $array
     * @param bool $active
     * @return bool
     */
    public static function add($iblock, $name, $array = array(), $active = false){

        global $USER;

        if (empty($iblock) || empty($name))
            return 'Ошибка! В вызове ' . __METHOD__ . ' отсутствуют обязательные параметр iblock и/или name';

        $el = new \CIBlockElement;

        $data = Helper::dataFilter($array, false);

        $data['IBLOCK_ID'] = $iblock;
        $data['NAME'] = trim(strip_tags($name));
        $data['ACTIVE'] = $active ? 'Y' : 'N';
        $data['MODIFIED_BY'] = $USER->GetID();

        if(!empty($data["PROPERTY"]))
            $data['PROPERTY_VALUES'] = $data['PROPERTY'];

        if($productId = $el->Add($data))
            return $productId;
        else
            return false;


    }

}
