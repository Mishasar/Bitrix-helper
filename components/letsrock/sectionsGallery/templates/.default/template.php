<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if (count($arResult['ITEMS']) != 7) {
    return null;
}
?>
<section class="section">
    <div class="container">
        <? if ($arParams['HIDE_HEADING']): ?>
            <h2 class="h1">Каталог</h2>
        <? endif; ?>
        <div class="catalog-main">
            <a class="catalog-main__item vertical" href="<?= $arResult['ITEMS'][0]['SECTION_PAGE_URL'] ?>">
                <div class="catalog-main__title"><?= $arResult['ITEMS'][0]['NAME'] ?></div>
                <div class="catalog-main__pic">
                    <img src="<?= $arResult['ITEMS'][0]['PICTURE']['src'] ?>"
                         alt="<?= $arResult['ITEMS'][0]['NAME'] ?>">
                </div>
            </a>
            <div class="catalog-main__group group-horizontal">
                <a class="catalog-main__item" href="<?= $arResult['ITEMS'][1]['SECTION_PAGE_URL'] ?>">
                    <div class="catalog-main__title"><?= $arResult['ITEMS'][1]['NAME'] ?></div>
                    <div class="catalog-main__pic">
                        <img src="<?= $arResult['ITEMS'][1]['PICTURE']['src'] ?>"
                             alt="<?= $arResult['ITEMS'][1]['NAME'] ?>">
                    </div>
                </a><a class="catalog-main__item" href="<?= $arResult['ITEMS'][2]['SECTION_PAGE_URL'] ?>">
                    <div class="catalog-main__title"><?= $arResult['ITEMS'][2]['NAME'] ?></div>
                    <div class="catalog-main__pic">
                        <img src="<?= $arResult['ITEMS'][2]['PICTURE']['src'] ?>"
                             alt="<?= $arResult['ITEMS'][2]['NAME'] ?>">
                    </div>
                </a>
                <a class="catalog-main__item horizontal" href="<?= $arResult['ITEMS'][3]['SECTION_PAGE_URL'] ?>">
                    <div class="catalog-main__title"><?= $arResult['ITEMS'][3]['NAME'] ?></div>
                    <div class="catalog-main__pic">
                        <img src="<?= $arResult['ITEMS'][3]['PICTURE']['src'] ?>"
                             alt="<?= $arResult['ITEMS'][3]['NAME'] ?>">
                    </div>
                </a>
            </div>
            <div class="catalog-main__group group-vertical">
                <a class="catalog-main__item banner"
                   style="background-image: url('<?= $arResult['BANNER']['PICTURE']['src'] ?>')"
                   href='<?= $arResult['BANNER']['LINK'] ?>'>
                    <div class="catalog-main__title"><?= $arResult['BANNER']['TEXT'] ?></div>
                </a>
                <a class="catalog-main__item vertical" href="<?= $arResult['ITEMS'][4]['SECTION_PAGE_URL'] ?>">
                    <div class="catalog-main__title"><?= $arResult['ITEMS'][4]['NAME'] ?></div>
                    <div class="catalog-main__pic">
                        <img src="<?= $arResult['ITEMS'][4]['PICTURE']['src'] ?>"
                             alt="<?= $arResult['ITEMS'][4]['NAME'] ?>">
                    </div>
                </a>
            </div>
            <a class="catalog-main__item horizontal" href="<?= $arResult['ITEMS'][5]['SECTION_PAGE_URL'] ?>">
                <div class="catalog-main__title"><?= $arResult['ITEMS'][5]['NAME'] ?></div>
                <div class="catalog-main__pic">
                    <img src="<?= $arResult['ITEMS'][5]['PICTURE']['src'] ?>"
                         alt="<?= $arResult['ITEMS'][5]['NAME'] ?>">
                </div>
            </a><a class="catalog-main__item" href="<?= $arResult['ITEMS'][6]['SECTION_PAGE_URL'] ?>">
                <div class="catalog-main__title"><?= $arResult['ITEMS'][6]['NAME'] ?></div>
                <div class="catalog-main__pic">
                    <img src="<?= $arResult['ITEMS'][6]['PICTURE']['src'] ?>"
                         alt="<?= $arResult['ITEMS'][6]['NAME'] ?>">
                </div>
            </a>
        </div>
    </div>
</section>