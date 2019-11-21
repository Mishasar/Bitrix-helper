<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="personal-card">
    <div class="personal-card__head">
        <? if (!empty($arResult['IMAGE_SRC'])): ?>
            <div class="personal-card__avatar"><img src="<?= $arResult['IMAGE_SRC'] ?>" alt="<?= $arParams['NAME'] ?>">
            </div>
        <? endif; ?>
        <div class="personal-card__info">
            <div class="personal-card__name"><?= $arParams['NAME'] ?></div>
            <div class="personal-card__position"><?= $arParams['POSITION'] ?></div>
        </div>
    </div>
    <div class="personal-card__inner">
        <div class="personal-card__row">
            <div class="link-with-icon phone">
                <a class="link" href="tel:<?= $arParams['PHONE'] ?>"><?= $arParams['PHONE'] ?></a>
            </div>
        </div>
        <div class="personal-card__row">
            <div class="link-with-icon mail">
                <a class="link" href="mailto:<?= $arParams['EMAIL'] ?>"><?= $arParams['EMAIL'] ?></a>
            </div>
        </div>
    </div>
</div>