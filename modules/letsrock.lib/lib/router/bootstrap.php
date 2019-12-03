<?php

namespace Letsrock\Lib\Models;
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use FastRoute;

\Bitrix\Main\Loader::includeModule('letsrock.lib');

/*
 * Router
 */

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute(['POST'], '/ajax-virtual/forms/auth/', 'Letsrock\Lib\Controllers\AuthController/auth');
    $r->addRoute(['POST'], '/ajax-virtual/basket/add/', 'Letsrock\Lib\Controllers\BasketController/addByStore');
    $r->addRoute(['POST'], '/ajax-virtual/basket/remove/', 'Letsrock\Lib\Controllers\BasketController/removeItem');
    $r->addRoute(['POST'], '/ajax-virtual/basket/quantity/', 'Letsrock\Lib\Controllers\BasketController/setQuantity');
    $r->addRoute(['POST'], '/ajax-virtual/catalog/getModal/', 'Letsrock\Lib\Controllers\CatalogController/getRenderModal');
    $r->addRoute(['POST'], '/ajax-virtual/basket/order/', 'Letsrock\Lib\Controllers\BasketController/order');
    $r->addRoute(['POST'], '/ajax-virtual/order/repeat/', 'Letsrock\Lib\Controllers\OrderController/repeat');
    $r->addRoute(['POST'], '/ajax-virtual/basket/addBonusProduct/', 'Letsrock\Lib\Controllers\BasketController/addBonusProduct');
});

//___________________________

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $vars['POST'] = $_POST;
        list($class, $method) = explode("/", $handler, 2);
        call_user_func_array(array(new $class, $method), $vars);
        break;
}
