<?php

namespace Letsrock\Lib\Controllers;

use Bitrix\Main\Loader;
use CIBlockElement;
use Letsrock\Lib\Models\Helper;

Loader::includeModule('iblock');


/*
 * Class BonusController
 * Контроллер бонусов
 */

class BonusSystemController extends Controller
{
    protected $bonusSystemByMonth;

    public function __construct()
    {
        $this->bonusSystemByMonth = $this->getBonusesStructure();
    }

    /**
     * Возвращает количество бонусов по стоимости покупки
     *
     * @param $countMoney
     * @param $monthUser
     *
     * @return int
     */
    function getBonusCountByMoney($countMoney, $monthUser)
    {
        if (empty($countMoney) || empty($monthUser) || empty($this->bonusSystemByMonth)) {
            return 0;
        }

        $month = Helper::findLeftBorderInArray($this->bonusSystemByMonth, $monthUser);
        $bonusBorder = Helper::findLeftBorderInArray($this->bonusSystemByMonth[$month]['ELEMENTS'], $countMoney);

        if (!empty($this->bonusSystemByMonth[$month]['ELEMENTS'][$bonusBorder]['PROPERTY_COUNT_MONEY_VALUE'])) {
            return $this->bonusSystemByMonth[$month]['ELEMENTS'][$bonusBorder]['PROPERTY_COUNT_MONEY_VALUE'];
        } else {
            return 0;
        }
    }


    /**
     * Возвращает массив бонусов со структурой:
     *
     * 1(int, месяц) => [
     *      10000(int, минимальная сумма для покупки) => 500(int, бонусы за неё),
     *      ...
     * ],
     * ...
     *
     *
     * @return array
     */
    private function getBonusesStructure()
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

        while ($ob = $res->GetNextElement()) {
            $props = $ob->GetFields();
            $arFields[$props['IBLOCK_SECTION_ID']][(int)$props['PROPERTY_COUNT_MONEY_VALUE']] = $props;
        }

        $rsSect = \CIBlockSection::GetList(
            [],
            ['IBLOCK_ID' => IntVal(IB_BONUS_SYSTEM)],
            false,
            ['ID', 'NAME', 'CODE', 'UF_MONTH_NUMBER']);

        while ($arSect = $rsSect->GetNext()) {
            $section['ELEMENTS'] = $arFields[(int)$arSect['ID']];
            $section['SECTION_INFO'] = $arSect;
            $arResult[(int)$arSect['UF_MONTH_NUMBER']] = $section;
        }

        return $arResult;
    }
}