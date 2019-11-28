<?php

namespace Letsrock\Lib\Models;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

/**
 * Class HLBlock
 *
 * @package Letsrock\Lib\Models
 */
class HLBlock
{
    private $hlblock;
    private $entity;
    private $entityClass;

    function __construct($id)
    {
        Loader::IncludeModule('highloadblock');
        $this->hlblock = HL\HighloadBlockTable::getById($id)->fetch(); // id highload блока
        $this->entity = HL\HighloadBlockTable::compileEntity($this->hlblock);
        $this->entityClass = $this->entity->getDataClass();
    }

    /**
     * @param $itemId
     *
     * @return array|bool|false
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    function getSingleItemById($itemId)
    {
        $res = $this->entityClass::getList([
            'select' => ['*'],
            'filter' => ['ID' => $itemId],
        ]);

        $item = $res->fetch();

        if (empty($item)) {
            return false;
        }

        return $item;
    }

    /**
     * @param array $filter
     * @param array $select
     *
     * @return array|bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    function get($filter = [], $select = ['*'])
    {
        $res = $this->entityClass::getList([
            'select' => $select,
            'filter' => $filter,
        ]);

        $list = [];

        while ($ob = $res->fetch()) {
            $list[] = $ob;
        }

        if (count($list) < 1) {
            return false;
        }

        return $list;
    }

    function add($params)
    {
        return $this->entityClass::add($params);
    }
}