<?php
define('GOOGLE_MAP_API_KEY', COption::GetOptionString("fileman", "google_map_api_key"));

AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
function _Check404Error()
{
    if (defined('ERROR_404') && ERROR_404 == 'Y' || CHTTP::GetLastStatus() == "404 Not Found") {
        GLOBAL $APPLICATION;
        $APPLICATION->RestartBuffer();
        require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/404.php';
        require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
    }
}

function morph($n, $f1, $f2, $f5)
{
    $n = abs(intval($n)) % 100;
    if ($n > 10 && $n < 20) return $f5;
    $n = $n % 10;
    if ($n > 1 && $n < 5) return $f2;
    if ($n == 1) return $f1;
    return $f5;
}

function resizeImage($id, $width, $height, $type = 3)
{
    $arReturn = array();
    if (is_array($id)) {
        $arReturn["ALT"] = $id["ALT"];
        $arReturn["TITLE"] = $id["TITLE"];
    }
    $type = $type >= 1 && $type <= 3 ? $type : 3;
    $arTypeResize = array(
        1 => BX_RESIZE_IMAGE_EXACT,
        2 => BX_RESIZE_IMAGE_PROPORTIONAL,
        3 => BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
    );

    return array_merge($arReturn, array_change_key_case(CFile::ResizeImageGet(
        $id,
        array("width" => $width, "height" => $height),
        $arTypeResize[$type],
        true,
        false,
        false,
        100
    ),
        CASE_UPPER));
}

function getExtension($filename)
{
    return end(explode(".", $filename));
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' Гб';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' Мб';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' Кб';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' б';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' б';
    } else {
        $bytes = '0 б';
    }

    return $bytes;
}

if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}