<?php

namespace Letsrock\Lib\Controllers;

use Bitrix\Main\Loader;
use Letsrock\Lib\Models\Form;

Loader::includeModule('iblock');

/*
 * Class FormController
 * Контроллер форм
 */

class FormController
{
    public function formAuth($request)
    {
        $formModel = new Form(IB_REQUEST_MAIN);
        echo $formModel->addMainForm($request);
    }
}