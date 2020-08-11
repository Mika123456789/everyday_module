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
    ?>
    <div class="mf-ok-text"><?= $arResult["OK_MESSAGE"] ?></div><?
}
?>



<? if (!empty($arParams['TITLE_TEXT'])) { ?>
    <div class="popup__title"><?= $arParams['TITLE_TEXT'] ?></div>
<? } ?>
<? if (!empty($arParams['SUBTITLE_TEXT'])) { ?>
    <div class="popup__txt"><?= $arParams['SUBTITLE_TEXT'] ?></div>
<? } ?>

<form data-ms="ms_1" action="<?= POST_FORM_ACTION_URI ?>" class="popup-form form"
      enctype="multipart/form-data">
    <?= bitrix_sessid_post() ?>

    <? if (!empty($arResult['ITEMS'])) { ?>
        <? foreach ($arResult['ITEMS'] as $arItem) { ?>
            <div class="popup-form-input">
                <div class="form__label"><?= $arItem['NAME'] ?></div>
                <? switch ($arItem['PROPERTY_TYPE']) {
                    case "F": // файл
                        ?>
                        <div class="form-addfile">
                            <div class="form-addfile-block">
                                <div class="form-addfile-content">
                                    <span class="form-addfile__btn btn fw min">Выберите файл для загрузки</span>
                                    <div class="form-addfile__info">или перетащите их мышью</div>
                                </div>
                                <input class="form-addfile__input" multiple="multiple" type="file"
                                       name="<?= $arItem['CODE'] ?>"/>
                            </div>
                            <ul class="form-addfile-list"></ul>
                        </div>
                        <? break;
                    case "L": // список
                        if ($arItem['MULTIPLE'] === 'Y') { ?>
                            <div class="form-input">
                                <select multiple="multiple" name="<?= $arItem['CODE'] ?>[]"
                                        class="form">
                                    <option value="" selected="selected">Выберите из списка</option>
                                    <? if (!empty($arItem['VALUE_LIST'])) { ?>
                                        <? foreach ($arItem['VALUE_LIST'] as $id => $value) { ?>
                                            <option value="<?= $id ?>"><?= $value ?></option>
                                        <? } ?>
                                    <? } ?>
                                </select>
                            </div>
                        <? } else { ?>
                            <div class="form-input">
                                <select name="<?= $arItem['CODE'] ?>" class="form">
                                    <option value="" selected="selected">Выберите из списка</option>
                                    <? if (!empty($arItem['VALUE_LIST'])) { ?>
                                        <? foreach ($arItem['VALUE_LIST'] as $id => $value) { ?>
                                            <option value="<?= $id ?>"><?= $value ?></option>
                                        <? } ?>
                                    <? } ?>
                                </select>
                            </div>
                        <? }
                        break;
                    case "E": // привязка к элементу
                        if ($arItem['MULTIPLE'] === 'Y') { ?>
                            <div class="form-input">
                                <select multiple="multiple" name="<?= $arItem['CODE'] ?>[]"
                                        class="form">
                                    <option value="" selected="selected">Выберите из списка</option>
                                    <? if (!empty($arItem['VALUE_LIST'])) { ?>
                                        <? foreach ($arItem['VALUE_LIST'] as $id => $value) { ?>
                                            <option value="<?= $id ?>"><?= $value ?></option>
                                        <? } ?>
                                    <? } ?>
                                </select>
                            </div>
                        <? } else { ?>
                            <div class="form-input">
                                <select name="<?= $arItem['CODE'] ?>" class="form">
                                    <option value="" selected="selected">Выберите из списка</option>
                                    <? if (!empty($arItem['VALUE_LIST'])) { ?>
                                        <? foreach ($arItem['VALUE_LIST'] as $id => $value) { ?>
                                            <option value="<?= $id ?>"><?= $value ?></option>
                                        <? } ?>
                                    <? } ?>
                                </select>
                            </div>
                        <? }
                        break;
                    default: // строка
                        ?>
                        <div class="form-input">
                            <input autocomplete="off" type="text" name="<?= $arItem['CODE'] ?>"
                                   data-value=""
                                   class="input<?= !empty($arItem['REQUIRED_FIELD']) ? ' req' : '' ?>"/>
                        </div>
                    <? } ?>
            </div>
        <? } ?>
    <? } ?>

    <? if ($arParams["USE_CAPTCHA"] == "Y") { ?>
        <div class="mf-captcha">
            <div class="mf-text"><?= GetMessage("MFT_CAPTCHA") ?></div>
            <input type="hidden" name="captcha_sid" value="<?= $arResult["capCode"] ?>">
            <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["capCode"] ?>" width="180"
                 height="40" alt="CAPTCHA">
            <div class="mf-text"><?= GetMessage("MFT_CAPTCHA_CODE") ?><span class="mf-req">*</span>
            </div>
            <input type="text" name="captcha_word" size="30" maxlength="50" value="">
        </div>
    <? } ?>
    <? if (!empty($arParams['AGREEMENT'])) { ?>
        <div class="popup-form-input">
            <div class="check">
                Я даю свое согласие на обработку персональных данныхв соответствии с <a
                        href="#policy" class="pl" target="_blank">Условиями</a>
                <input type="checkbox" value="1" class="req" name="form[]"/>
            </div>
        </div>
    <? } ?>

    <div class="form-button">
        <button type="submit" name="submit"
                class="form__btn btn fw"><?= !empty($arParams['BTN_TEXT']) ? $arParams['BTN_TEXT'] : 'Отправить' ?></button>
    </div>
    <input type="hidden" name="PARAMS_HASH" value="<?= $arResult["PARAMS_HASH"] ?>">
</form>

