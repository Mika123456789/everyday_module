<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

if (!empty($arResult['SECTIONS'])) {
    CModule::IncludeModule("iblock");
    foreach ($arResult['SECTIONS'] as &$arSection) {
        $rs = CIBlockElement::GetList(array('SORT' => 'ASC'), array('IBLOCK_ID' => $arSection['IBLOCK_ID'], 'IBLOCK_SECTION_ID' => $arSection['ID'], 'ACTIVE' => 'Y'), false, false, array('ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_TYPE', 'PROPERTY_MANUFACTURER', 'PROPERTY_QUANTITY'));
        while ($ar = $rs->GetNext()) {
            $arSection['ITEMS'][] = $ar;
        }
    }
}