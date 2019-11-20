<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult)) {
    return "";
}

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if (!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css)) {
    $strReturn .= '<link href="' . CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css") . '" type="text/css" rel="stylesheet" />' . "\n";
}

$strReturn .= '<section class="breadcrumbs-section" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList"><div class="container"><ul class="breadcrumbs"><li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Главная</a></li>';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
        $strReturn .= '
		    <li class="breadcrumbs__item" id="bx_breadcrumb_' . $index . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a class="breadcrumbs__link" href="' . $arResult[$index]["LINK"] . '" title="' . $title . '" itemprop="url">
					<span itemprop="name">' . $title . '</span>
				</a>
				<meta itemprop="position" content="' . ($index + 1) . '" />
			</li>';
    } else {
        $strReturn .= '
            <li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<span itemprop="name">' . $title . '</span>
				<meta itemprop="position" content="' . ($index + 1) . '" />
			</li>';
    }
}

$strReturn .= '</ul></div></section>';

return $strReturn;


?>