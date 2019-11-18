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

class Handler
{
    function OnSaleStatusOrderChange($event)
    {
        $parameters = $event->getParameters();
        if ($parameters['VALUE'] === 'F') {
            /** @var \Bitrix\Sale\Order $order */
            $order = $parameters['ENTITY'];
            /**
             *
             * Your code is here
             *
             */
        }

        return new \Bitrix\Main\EventResult(
            \Bitrix\Main\EventResult::SUCCESS
        );
    }
}