<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if (!empty($arResult)): ?>


    <div class="menu-accordion__block js-menu-accordion">
        <div class="menu-accordion__mobile js-menu-accordion-mobile">Категории</div>
        <ul class="menu-accordion js-menu-accordion-list">
            <?
            $previousLevel = 0;
            foreach ($arResult

            as $arItem):
            ?>
            <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
                <?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
            <? endif ?>

            <? if ($arItem["IS_PARENT"]): ?>
            <li class="menu-accordion__item has-child <?= $arItem["CHILD_SELECTED"] ? "active is-open" : "" ?>">
                <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                <ul class="menu-accordion">
                    <? else: ?>
                        <li class="menu-accordion__item <?= $arItem["SELECTED"] ? "active" : "" ?>">
                            <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                        </li>
                    <? endif ?>

                    <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

                    <? endforeach ?>

                    <? if ($previousLevel > 1)://close last item tags?>
                        <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
                    <? endif ?>

                </ul>
    </div>

<? endif ?>
