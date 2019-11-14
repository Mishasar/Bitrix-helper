<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

?>
    <section class="section-title">
        <div class="container">
            <h1 class="h1"><? $APPLICATION->ShowTitle() ?></h1>
        </div>
    </section>
<?
$APPLICATION->IncludeComponent("letsrock:sectionsGallery",
    ".default",
    ['HIDE_HEADING' => 'Y']
);
?>