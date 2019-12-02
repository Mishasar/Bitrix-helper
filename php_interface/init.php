<?

use Bitrix\Main\EventManager;
use \Bitrix\Main\Loader;

include $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/const/userConstants.php';
require $_SERVER["DOCUMENT_ROOT"] . '/local/vendor/autoload.php';
Loader::includeModule('letsrock.lib');
Loader::includeModule('letsrock.bonus');
Loader::includeModule('sale');

EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleStatusOrderChange',
    ['Letsrock\\Bonus\\Controller', 'orderBonusHandler']);

EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderBeforeSaved',
    ['Letsrock\\Bonus\\Controller', 'OnSaleOrderBeforeSavedHandler']);

//  Проверяем пришел ли email или login и если email авторизуем по нему
EventManager::getInstance()->addEventHandler(
    'main',
    'OnBeforeUserLogin',
    ['Letsrock\\Lib\\Controllers\\OrderController', 'DoBeforeUserLoginHandler']);