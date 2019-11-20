<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
use Letsrock\Lib\Models\Property; ?>
<section class="section">
    <div class="container">
        <div class="contacts__info">
            <div class="contacts__info-inner">
                <div class="link-with-desc phone"><a class="link" href="tel:<?= Letsrock\Lib\Models\Property::getText('MAIN_PHONE') ?>"><?= Letsrock\Lib\Models\Property::getText('MAIN_PHONE') ?></a><span class="desc">бесплатно</span></div>
            </div>
            <div class="contacts__info-inner">
                <div class="link-with-desc mail"><a class="link" href="mailto:<?= Letsrock\Lib\Models\Property::getText('MAIN_EMAIL') ?>"><?= Letsrock\Lib\Models\Property::getText('MAIN_EMAIL') ?> </a><span class="desc">написать письмо</span></div>
            </div>
        </div>
        <div class="contacts__address">
            <div class="content-half">
                <div class="content-half__box">
                    <div class="contacts__address-title">Региональный склад в Барнауле</div>
                    <div class="contacts__address-location">ул. Попова , 242</div>
                    <div class="contacts__address-map">
                        <div class="map">
                            <div class="map__inner" id="map-barnaul"></div>
                        </div>
                    </div>
                </div>
                <div class="content-half__box">
                    <div class="contacts__address-title">Региональный склад в Москве</div>
                    <div class="contacts__address-location">Коровинское шоссе 35 стр.2</div>
                    <div class="contacts__address-map">
                        <div class="map">
                            <div class="map__inner" id="map-moscow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>