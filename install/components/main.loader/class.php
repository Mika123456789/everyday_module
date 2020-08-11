<?php

use Local\BaseComponent;

use Bitrix\Main\Loader;

class PktMainLoader extends BaseComponent {
    public function run(){
        Loader::includeModule('pkt.main');
    }
}
