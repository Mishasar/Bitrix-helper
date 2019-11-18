<?php

namespace Letsrock\Lib\Controllers;

use Bitrix\Main\Loader;
use CIBlockElement;

Loader::includeModule('iblock');


/*
 * Class BonusController
 * Контроллер бонусов
 */

class BonusController extends Controller
{
    protected $bonusSystemByMonth;

    public function __construct()
    {
        $arFields = [];
        $arResult = [];
        $section = [];
        $arSelect = [
            "ID",
            "NAME",
            "PROPERTY_COUNT_MONEY",
            "PROPERTY_COUNT_BONUSES",
            "IBLOCK_SECTION_ID"
        ];

        $arFilter = ["IBLOCK_ID" => IntVal(IB_BONUS_SYSTEM), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"];
        $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, ["nPageSize" => 50], $arSelect);
        $arFields = [];

        while ($ob = $res->GetNextElement()) {
            $props = $ob->GetFields();
            $arFields[$props['IBLOCK_SECTION_ID']][$props['PROPERTY_COUNT_MONEY_VALUE']] = $props;
        }

        $rsSect = \CIBlockSection::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => IntVal(IB_BONUS_SYSTEM)],
            false,
            ['ID', 'NAME', 'CODE', 'UF_MONTH_NUMBER']);

        while ($arSect = $rsSect->GetNext()) {
            $section['ELEMENTS'] = $arFields[$arSect['ID']];
            $section['SECTION_INFO'] = $arSect;
            $arResult[$arSect['UF_MONTH_NUMBER']] = $section;
        }

        $this->bonusSystemByMonth = $arResult;
    }

    function getBonusCountByMoney($countMoney)
    {

    }
}