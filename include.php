<?php

namespace Pkt\Main\Functions;

function uuid_v4() {
    $uuid = random_bytes(16);
    
    $uuid[8] = chr(ord($uuid[8]) & 0x0f | 0x40);
    $uuid[6] = chr(ord($uuid[6]) & 0x3f | 0x80);

    $uuid = bin2hex($uuid);

    $fields = [
        substr($uuid, 0, 8),
        substr($uuid, 8, 4),
        substr($uuid, 12, 4),
        substr($uuid, 16, 2),
        substr($uuid, 18, 2),
        substr($uuid, 20, 12),
    ];
    
    return vsprintf('%08s-%04s-%04s-%02s%02s-%012s', $fields);
}

function getPktCssPath($moduleName) {
    return '/local/css/' . $moduleName;
}

function getPktJsPath($moduleName) {
    return '/local/js/' . $moduleName;
}