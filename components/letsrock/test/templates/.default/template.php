<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if (empty($arResult['TOP']) && empty($arResult['TOP'])) {
    return 0;
}
?>
<section class="job">
    <div class="job__inner container">
        <h3 class="job__heading"><?= GetMessage('C_JOB_TITLE') ?></h3>
        <div class="job__circle job__circle_1"></div>
        <div class="job__circle job__circle_2"></div>
        <div class="job__top js-accordeon">
            <div class="job__image-block js-accordeon-image-block">
                <img class="job__notebook js-accordeon-image" src="" alt="">
            </div>
            <div class="job__links-block <?= ($arParams['MAIN'] == 'Y') ? 'job__links-block_main' : ''; ?>">
                <div class="job__accordeon js-accordeon-inner">
                    <div class="job__dot js-accordeon-dot"></div>
                    <? foreach ($arResult['TOP'] as $item): ?>
                        <div class="job__accordeon-item js-accordeon-item"
                             data-img="<?= $item['PREVIEW_PICTURE']['src'] ?>">
                            <a href="javascript:void(0);"
                               class="job__accordeon-title js-accordeon-link"><?= $item['NAME'] ?></a>
                            <div class="js-accordeon-hidden job__accordeon-hidden">
                                <p class="job__accordeon-text js-accordeon-text"><?= $item['PREVIEW_TEXT'] ?></p>
                                <div class="job__accordeon-image">
                                    <? if (!empty($item['PREVIEW_PICTURE']['src'])): ?>
                                        <img class="job__accordeon-img" src="<?= $item['PREVIEW_PICTURE']['src'] ?>"
                                             alt="<?= $item['NAME'] ?>">
                                    <? endif; ?>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
                <div class="btn job__btn js-btn">
                        <span class="btn__circle js-btn-effect">
                        </span>
                    <a href="<?= PRESENTATION_PATH ?>" target="_blank" class="btn__inner js-btn-inner">
                        <span class="btn__text"><?= GetMessage('C_JOB_PRESENTATION') ?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="job__bottom">
            <? foreach ($arResult['BOTTOM'] as $item): ?>
                <div class="job__cart">
                    <div class="job__cart-image">
                        <img src="<?= $item['PREVIEW_PICTURE']['src'] ?>" alt="<?= $item['NAME'] ?>">
                    </div>
                    <p class="job__cart-title"><?= $item['NAME'] ?></p>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</section>