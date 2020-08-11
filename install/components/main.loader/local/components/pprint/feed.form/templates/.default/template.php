<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
?>

<? if (!empty($arResult["ERROR_MESSAGE"])) {
    foreach ($arResult["ERROR_MESSAGE"] as $v)
        ShowError($v);
}
if (strlen($arResult["OK_MESSAGE"]) > 0) {
  
}
?>

