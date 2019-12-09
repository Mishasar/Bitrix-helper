<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

\Bitrix\Main\Loader::includeModule('letsrock.bonus');

/**
 * Class ContactsComponent
 */
class BonusPageComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "MAIN" => $arParams["MAIN"],
            "BOTTOM_SECTION" => $arParams["BOTTOM_SECTION"],
            "TOP_SECTION" => $arParams["TOP_SECTION"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"] : 60,
        ];

        return $result;
    }

    /**
     * @return array|mixed
     */
    public function executeComponent()
    {
        if ($this->startResultCache()) {
            global $USER;
            $information = new \Letsrock\Bonus\Information($USER->GetID());
            $this->arResult['BONUS_COUNT'] = $information->getCountBonuses();
            $this->arResult['BONUS_STRUCTURE'] = $information->getBonusesStructure();

            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>