<?php
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        if (!empty($arItem['PROPERTIES']['LOGO']['VALUE'])) {
            $arItem['PROPERTIES']['LOGO']['SRC'] = CFile::GetPath($arItem['PROPERTIES']['LOGO']['VALUE']);
        }
        if (!empty($arItem['PROPERTIES']['IMG']['VALUE'])) {
            $arItem['PROPERTIES']['IMG']['SRC'] = CFile::GetPath($arItem['PROPERTIES']['IMG']['VALUE']);
        }
    }
}