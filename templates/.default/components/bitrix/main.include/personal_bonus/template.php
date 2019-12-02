<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true); ?>
<div class="cabinet-head">
    <div class="cabinet-head__bonus">
        Бонусов:<b><?=$countBonuses?></b></div>
    <a class="cabinet-logout" href="/?logout=yes">Выйти</a>
</div>
<div class="cabinet-body">
    <div class="cabinet-bonus">
        <div class="cabinet-bonus__content">
           <?
           if($arResult["FILE"] <> '')
               include($arResult["FILE"]);
           ?>
        </div>
    </div>
</div>


