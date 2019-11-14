<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arResult
 * @var array $arParam
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) {
        return;
    }
}
?>
<div class="pagination">
    <div class="pagination__list">

        <?
        $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
        $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
        ?>
        <?

        if ($arResult["NavPageNomer"] > 1):
            ?>
            <a class="pagination__prev"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"></a>
        <?
        endif;


        if ($arResult["NavPageNomer"] > 1):
            if ($arResult["nStartPage"] > 1):
                if ($arResult["bSavePage"]):
                    ?>
                    <a class="pagination__item"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1">
                        1
                    </a>
                <?
                else:
                    ?>
                <a class="pagination__item"
                   href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                        1
                    </a><?
                endif;

                if ($arResult["nStartPage"] > 2):
                    ?>
                <a class="pagination__points"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= round($arResult["nStartPage"] / 2) ?>">
                        ...
                    </a><?
                endif;
            endif;
        endif;

        do {
            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>
                <a class="pagination__item active" href="javascript:void(0);"><?= $arResult["nStartPage"] ?></a>
            <?
            elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                ?>
                <a class="pagination__item"
                   href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                    <?= $arResult["nStartPage"] ?>
                </a>
            <?
            else:
                ?>
            <a class="pagination__item"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>">
                <?= $arResult["nStartPage"] ?>
                </a><?
            endif;
            $arResult["nStartPage"]++;
        } while ($arResult["nStartPage"] <= $arResult["nEndPage"]);

        if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
            if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
                    ?>
                    <a class="pagination__points"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2) ?>">
                        ...
                    </a>
                <?
                endif;
                ?>
                <a class="pagination__item"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>">
                    <?= $arResult["NavPageCount"] ?>
                </a>
            <?
            endif;
        endif;

        ?>

        <? if (!$arResult["NavPageNomer"] < $arResult["NavPageCount"] + 1): ?>
            <a class="pagination__next"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"></a>
        <? endif; ?>

    </div>
</div>