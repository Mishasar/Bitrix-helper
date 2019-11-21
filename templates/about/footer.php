<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

    </div>
    </div>
    </div>
    </section>
    <section class="section personal-card__section">
        <div class="container">
            <? $APPLICATION->IncludeComponent("letsrock:managerList", ".default", []); ?>
        </div>
    </section>
<?
require_once(dirname(__FILE__) . '/../../include/templates/footer.php');
?>