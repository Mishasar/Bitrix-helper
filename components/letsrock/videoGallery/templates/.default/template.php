<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<section class="section slider-video__section">
    <div class="container">
        <div class="slider-video">
            <a class="slider-video__logo" href="<?= $arResult['CHANNEL_URL'] ?>"
               target="_blank" title="Канал на YouTube - DIODTRADE Светотехника">
                <div class="slider-video__logo-youtube"></div>
                <div class="slider-video__logo-youtube-text"></div>
                <div class="slider-video__logo-esk"></div>
            </a>
            <div class="slider-video__block">
                <div class="slider-video__list js-slider-video">
                    <? foreach ($arResult['ITEMS'] as $item): ?>
                        <div class="slider-video__item">
                            <div class="slider-video__item-video">
                                <iframe class="embed-player slide-media"
                                        width="890" height="523"
                                        src="<?= $item['URL'] ?>"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </div>
                            <div class="slider-video__title"><?= $item['NAME'] ?></div>
                        </div>
                    <? endforeach; ?>
                </div>
                <div class="slider-video__controls">
                    <div class="slider-video-button prev js-slider-video-prev"></div>
                    <div class="slider-video-button next js-slider-video-next"></div>
                </div>
            </div>
        </div>
    </div>
</section>