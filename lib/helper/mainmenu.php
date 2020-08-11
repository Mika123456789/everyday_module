<?php

namespace Pkt\Main\Helper;

use Bitrix\Main\Config\Option;

class MainMenu {

    private $items;
    private $moduleId = 'intranet';
    private $paramName = 'left_menu_items_to_all_s1';
    private $siteId = 's1';

    public function __construct() {
        $items = unserialize(Option::get($this->moduleId, $this->paramName, 'a:0:{}', $this->siteId));
        $this->items = array_column($items, null, 'ID');
    }

    public function getItems() {
        return array_values($this->items);
    }

    public function add($itemId, $text, $link) {
        $this->items[$itemId] = [
            'TEXT' => $text,
            'LINK' => $link,
            'ID' => $itemId
        ];
        $this->save();
    }

    public function delete($itemId) {
        unset($this->items[$itemId]);
        $this->save();
    }

    private function save() {
        $items = array_values($this->items);
        Option::set($this->moduleId, $this->paramName, serialize($items), $this->siteId);
    }

}
