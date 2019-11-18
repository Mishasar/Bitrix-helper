<?

use Bitrix\Main\EventManager;

include $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/const/userConstants.php';
require $_SERVER["DOCUMENT_ROOT"] . '/local/vendor/autoload.php';
\Bitrix\Main\Loader::includeModule('letsrock.lib');
\Bitrix\Main\Loader::includeModule('sale');

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleStatusOrderChange',
    ['Letsrock\\Lib\\Controllers\\OrderController', 'orderBonusHandler']);