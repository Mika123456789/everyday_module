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

<? if (!empty($arResult['SECTIONS'])) { ?>
    <div class="examples-slider">
        <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
            <div class="examples-slide" data-id="<?= $arSection['ID'] ?>">
                <div class="examples-slide-content">
                    <div class="examples-slide-content__title"><?= $arSection['NAME'] ?></div>
                    <a href="#getprice" class="examples-slide-content__btn btn pl"
                       data-id="<?= $arSection['ID'] ?>"><?= !empty($arSection['UF_BTN_NAME']) ? $arSection['UF_BTN_NAME'] : 'Узнать стоимость' ?></a>
                </div>
                <div class="examples-slide__bg ibg">
                    <img src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?= $arSection['PICTURE']['ALT'] ?>"/>
                </div>
            </div>
        <? } ?>
    </div>

    <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
        <div class="popup popup--size_2 popup-info" id="info_popup_<?= $arSection['ID'] ?>">
            <div class="popup-table table">
                <div class="cell">
                    <div class="popup-content">
                        <div class="popup-content-body">
                            <div class="popup-close"></div>
                            <div class="popup__title"><?= !empty($arSection['UF_POPUP_TITLE']) ? $arSection['UF_POPUP_TITLE'] : $arSection['NAME'] ?></div>
                            <div class="popup-info-body popup-content-scroll">
                                <div class="popup-content-scroll-list">
                                    <div class="popup-info-content">
                                        <? if (!empty($arSection['ITEMS'])) { ?>
                                            <table class="popup-info-table">
                                                <? foreach ($arSection['ITEMS'] as $arItem) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="popup-info__label"><?= GetMessage('CT_BCSL_TABLE_CELL_1')?></div>
                                                            <div class="popup-info__value"><?= $arItem['PROPERTY_TYPE_VALUE']?></div>
                                                        </td>
                                                        <td>
                                                            <div class="popup-info__label"><?= GetMessage('CT_BCSL_TABLE_CELL_2')?></div>
                                                            <div class="popup-info__value text-center"><?= empty($arItem['PROPERTY_QUANTITY_VALUE']) ? '&nbsp;' : $arItem['PROPERTY_QUANTITY_VALUE']?></div>
                                                        </td>
                                                        <td>
                                                            <div class="popup-info__label"><?= GetMessage('CT_BCSL_TABLE_CELL_3')?></div>
                                                            <div class="popup-info__value"><?= $arItem['PROPERTY_MANUFACTURER_VALUE']?></div>
                                                        </td>
                                                        <td>
                                                            <div class="popup-info__label"><?= GetMessage('CT_BCSL_TABLE_CELL_4')?></div>
                                                            <div class="popup-info__value"><?= $arItem['NAME']?></div>
                                                        </td>
                                                    </tr>
                                                <? } ?>
                                            </table>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="popup-info-footer">
                                <a href="#sendplan" class="popup-info__btn btn pl" data-id="<?= $arSection['ID'] ?>">
                                    <?= !empty($arSection['UF_POPUP_BTN']) ? $arSection['UF_POPUP_BTN'] : 'Мне это подходит! Узнать стоимость' ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>