<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<section class="section">
    <div class="container">
        <div class="content-sidebar">
            <div class="content__box">
                <div class="slider-main">
                    <div class="slider-main__list js-slider-main">
                        <? foreach ($arResult as $item): ?>
                            <div class="slider-main__item"
                                 style="background-image: url(<?= $item['PREVIEW_PICTURE']['src'] ?>)">
                                <div class="slider-main__info">
                                    <div class="slider-main__title"><?= $item['NAME'] ?></div>
                                    <? if (!empty($item['PROPERTY_LINK_VALUE'] && !empty($item['PROPERTY_LINK_TEXT_VALUE']))): ?>
                                        <a class="btn btn-yellow" href="<?=$item['PROPERTY_LINK_VALUE']?>"><?=$item['PROPERTY_LINK_TEXT_VALUE']?></a>
                                    <? endif; ?>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                    <div class="slider-main__controls">
                        <div class="slider-button prev js-slider-main-prev"></div>
                        <div class="slider-main__counter">
                            <div class="slider-main__counter-min js-slider-main-min"></div>
                            <div class="slider-main__counter-max js-slider-main-max"></div>
                        </div>
                        <div class="slider-button next js-slider-main-next"></div>
                    </div>
                </div>
            </div>
            <div class="sidebar__box">
                <div class="sidebar-links">
                    <a class="sidebar-links__item" href="/catalog/">
                        <div class="sidebar-links__inner">
                            <div class="sidebar-links__title">Каталог</div>
                            <div class="sidebar-links__go-over">перейти</div>
                        </div>
                    </a>
                    <a class="sidebar-links__item" href="/catalog/new-products/">
                        <div class="sidebar-links__inner">
                            <div class="sidebar-links__title">Новые поступления</div>
                            <div class="sidebar-links__go-over">перейти</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>