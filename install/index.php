<?php

use Local\BaseModule;

class pkt_main extends BaseModule {
    
    public function DoInstall() {
        parent::DoInstall();
        $this->APPLICATION->IncludeAdminFile($this->installTitle, __DIR__ . '/step.php');
    }

    public function DoUninstall() {
        parent::DoUninstall();        
        $this->APPLICATION->IncludeAdminFile($this->uninstallTitle, __DIR__ . '/unstep.php');
    }

}
