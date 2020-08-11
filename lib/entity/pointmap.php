<?php

namespace Pkt\Main\Entity;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;

class PointMapTable extends DataManager {

    public static function getTableName() {
        return 'pkt_main_point_map';
    }

    public static function getMap() {
        return [
            new Fields\IntegerField('ID', ['primary' => true, 'autocomplete' => true]),
            new Fields\StringField('NAME'),
            new Fields\StringField('COORDS')
        ];
    }

}
