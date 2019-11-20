<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;

Loader::includeModule('iblock');

class HLBlock {
    private $hlblock;
    private $entity;
    private $entityClass;

    function __construct($id) {
        Loader::IncludeModule('highloadblock');
        $this->hlblock = HL\HighloadBlockTable::getById($id)->fetch(); // id highload блока
        $this->entity = HL\HighloadBlockTable::compileEntity($this->hlblock);
        $this->entityClass = $this->entity->getDataClass();
    }

    function getSingleItemById($itemId) {
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

    function get($filter = [], $select = ['*']) {
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

    function add($params) {
        return $this->entityClass::add($params);
    }
}