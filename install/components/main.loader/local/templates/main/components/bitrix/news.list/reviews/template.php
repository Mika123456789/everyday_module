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
    <div class="advantages-reviews-items gallery">
        <? foreach ($arResult["ITEMS"] as $arItem) { ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="advantages-reviews__column" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="advantages-review">
                    <div class="advantages-review__name"><?= $arItem['NAME']?></div>
                    <? if (!empty($arItem['PROPERTIES']['LOGO']['SRC'])) { ?>
                        <div class="advantages-review__image">
                            <img src="<?= $arItem['PROPERTIES']['LOGO']['SRC']?>" alt="<?= $arItem['NAME']?>"/>
                        </div>
                    <? } ?>
                    <div class="advantages-review__text">
                        <?= $arItem['PREVIEW_TEXT']?>
                    </div>
                    <? if (!empty($arItem['PROPERTIES']['IMG']['SRC'])) { ?>
                        <a href="<?= $arItem['PROPERTIES']['IMG']['SRC']?>" class="advantages-review__btn btn-2 fw fancybox-preview">
                            <?= $arItem['PROPERTIES']['BTN_TEXT']['VALUE']?>
                        </a>
                    <? } ?>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>