<?php

namespace Pkt\Main\Handler\Main;

use Local\BaseHandler;

class OnProlog extends BaseHandler{
    static public function run(&...$args){
        global $APPLICATION;
        $APPLICATION->IncludeComponent('pkt:main.loader', '.default');
    }
}
