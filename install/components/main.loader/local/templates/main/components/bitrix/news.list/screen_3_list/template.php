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
$this->setFrameMode(true);
?>

<? if (!empty($arResult["ITEMS"])) { ?>
    <div class="whywe-items-body">
        <? foreach ($arResult["ITEMS"] as $arItem) { ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="whywe-items__column" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="whywe-item">
                    <div class="whywe-item__icon">
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT']?>"/>
                    </div>
                    <div class="whywe-item__text">
                        <?= $arItem['PREVIEW_TEXT'] ?>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>