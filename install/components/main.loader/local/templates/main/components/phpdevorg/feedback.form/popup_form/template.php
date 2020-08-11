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

<?
if (!empty($arResult["ERROR_MESSAGE"])) { ?>
    <script>
        $('.popup.popup-<?= $arParams['FORM_CLASS']?>').addClass('active').fadeIn(1);
        FormsOb.forms(1);
    </script>
<? }

if (strlen($arResult["OK_MESSAGE"]) > 0) { ?>
    <div class="popup popup-message ms_1<?= $arParams['FORM_CLASS']?>">
        <div class="popup-table table">
            <div class="cell">
                <div class="popup-content">
                    <div class="popup-content-body">
                        <div class="popup-close"></div>
                        <div class="popup__title"><?= html_entity_decode($arParams["OK_TITLE"]) ?></div>
                        <div class="popup__txt">
                            <?= html_entity_decode($arParams["OK_TEXT"]) ?>
                        </div>
                        <div class="popup-message-body">
                            <a href="javascript:void(0)" class="popup-message__btn btn popup__close">Ок</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.popup').hide();
        $('.popup-message.ms_1<?= $arParams['FORM_CLASS']?>').addClass('active').fadeIn(300);
        FormsOb.forms(1);
    </script>
<? } ?>

<div class="popup popup-<?= $arParams['FORM_CLASS']?>">
    <div class="popup-table table">
        <div class="cell">
            <div class="popup-content">
                <div class="popup-content-body">
                    <div class="popup-close"></div>
                    <? if (!empty($arParams['TITLE_TEXT'])) { ?>
                        <div class="popup__title"><?= $arParams['TITLE_TEXT'] ?></div>
                    <? } ?>
                    <? if (!empty($arParams['MINITITLE_TEXT'])) { ?>
                        <div class="equipment-body__title"><?= $arParams['MINITITLE_TEXT'] ?></div>
                    <? } ?>
                    <? if (!empty($arParams['SUBTITLE_TEXT'])) { ?>
                        <div class="popup__txt"><?= $arParams['SUBTITLE_TEXT'] ?></div>
                    <? } ?>

                    <?
                    if (!empty($arResult["ERROR_MESSAGE"])) { ?>
                        <div class="popup__txt">
                            <? foreach ($arResult["ERROR_MESSAGE"] as $v) {
                                ShowError($v);
                            } ?>
                        </div>
                    <? } ?>

                    <form data-ms="ms_1" action="<?= POST_FORM_ACTION_URI ?>" class="popup-form form"
                          enctype="multipart/form-data" method="post">
                        <?= bitrix_sessid_post() ?>

                        <? if (!empty($arResult['ITEMS'])) { ?>
                            <? foreach ($arResult['ITEMS'] as $arItem) { ?>
                                <?
                                if (empty($arItem))
                                    continue;
                                ?>
                                <div class="popup-form-input">
                                    <div class="form__label"><?= $arItem['NAME'] ?></div>
                                    <? switch ($arItem['PROPERTY_TYPE']) {
                                        case "F": // файл
                                            $id = rand(1, 99999);
                                            ?>
                                            <div class="form-addfile">
                                                <div class="form-addfile-block">
                                                    <div class="form-addfile-content">
                                                        <span class="form-addfile__btn btn fw min">Выберите файл для загрузки</span>
                                                        <div class="form-addfile__info">или перетащите их мышью</div>
                                                    </div>
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                                                    <input class="form-addfile__input<?= !empty($arItem['REQUIRED_FIELD']) ? ' req' : '' ?>"
                                                           type="file"
                                                           data-container="input_files_<?= $id?>"
                                                           name="<?= $arItem['CODE'] ?>[]" id="popup_file<?= rand(1, 20)?>"/>
                                                </div>
                                                <ul class="form-addfile-list"></ul>
                                            </div>
                                            <div style="display: none;" id="input_files_<?= $id?>"></div>
                                            <? break;
                                        case "L": // список
                                            if ($arItem['MULTIPLE'] === 'Y') { ?>
                                                <div class="form-input">
                                                    <select multiple="multiple" name="<?= $arItem['CODE'] ?>[]"
                                                            class="form<?= !empty($arItem['REQUIRED_FIELD']) ? ' req' : '' ?>">
                                                        <?
                                                        $i = 0;
                                                        if (!empty($arResult[$arItem['CODE']])) {
                                                            foreach ($arResult[$arItem['CODE']] as $val) {
                                                                if (!empty($val))
                                                                    $i++;
                                                            }
                                                        } ?>
                                                        <option value="0"<?= empty($i) ? ' selected="selected"' : ''?>>Выберите из списка</option>
                                                        <? if (!empty($arItem['VALUE_LIST'])) { ?>
                                                            <? foreach ($arItem['VALUE_LIST'] as $id => $value) { ?>
                                                                <option value="<?= $id ?>"<?= in_array($id, $arResult[$arItem['CODE']]) ? ' selected="selected"' : ''?>><?= $value ?></option>
                                                            <? } ?>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                            <? } else { ?>
                                                <div class="form-input">
                                                    <select name="<?= $arItem['CODE'] ?>"
                                                            class="form<?= !empty($arItem['REQUIRED_FIELD']) ? ' req' : '' ?>">
                                                        <option value="0"<?= empty($arResult[$arItem['CODE']]) ? ' selected="selected"' : ''?>>Выберите из списка</option>
                                                        <? if (!empty($arItem['VALUE_LIST'])) { ?>
                                                            <? foreach ($arItem['VALUE_LIST'] as $id => $value) { ?>
                                                                <option value="<?= $id ?>"<?= $id == $arResult[$arItem['CODE']] ? ' selected="selected"' : ''?>><?= $value ?></option>
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
                                                            class="form<?= !empty($arItem['REQUIRED_FIELD']) ? ' req' : '' ?>">
                                                        <?
                                                        $i = 0;
                                                        if (!empty($arResult[$arItem['CODE']])) {
                                                            foreach ($arResult[$arItem['CODE']] as $val) {
                                                                if (!empty($val))
                                                                    $i++;
                                                            }
                                                        } ?>
                                                        <option value="0"<?= empty($i) ? ' selected="selected"' : ''?>>Доверяю профессионалам
                                                        </option>
                                                        <? if (!empty($arItem['VALUE_LIST'])) { ?>
                                                            <? foreach ($arItem['VALUE_LIST'] as $id => $value) { ?>
                                                                <option value="<?= $id ?>"<?= in_array($id, $arResult[$arItem['CODE']]) ? ' selected="selected"' : ''?>><?= $value ?></option>
                                                            <? } ?>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                            <? } else { ?>
                                                <div class="form-input">
                                                    <select name="<?= $arItem['CODE'] ?>"
                                                            class="form<?= !empty($arItem['REQUIRED_FIELD']) ? ' req' : '' ?>">
                                                        <option value="0"<?= empty($arResult[$arItem['CODE']]) ? ' selected="selected"' : ''?>>Доверяю профессионалам
                                                        </option>
                                                        <? if (!empty($arItem['VALUE_LIST'])) { ?>
                                                            <? foreach ($arItem['VALUE_LIST'] as $id => $value) { ?>
                                                                <option value="<?= $id ?>"<?= $id == $arResult[$arItem['CODE']] ? ' selected="selected"' : ''?>><?= $value ?></option>
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
                                                       data-value="" value="<?= $arResult[$arItem['CODE']]?>"
                                                       class="input<?= !empty($arItem['REQUIRED_FIELD']) ? ' req' : '' ?><?= $arItem['CODE'] == 'EMAIL' ? ' email' : '' ?>"/>
                                            </div>
                                        <? } ?>
                                </div>
                            <? } ?>
                        <? } ?>

                        <? if ($arParams["USE_CAPTCHA"] == "Y") { ?>
                            <div class="popup-form-input">
                                <div class="form__label"><?= GetMessage("MFT_CAPTCHA_CODE") ?></div>
                                <div class="form-input">
                                    <input type="hidden" name="captcha_sid" value="<?= $arResult["capCode"] ?>">
                                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["capCode"] ?>"
                                         class="img-captcha" alt="CAPTCHA">
                                    <input type="text" name="captcha_word" class="input-captcha req" size="30"
                                           maxlength="50" value="">
                                </div>
                            </div>
                        <? } ?>
                        <? if (!empty($arParams['AGREEMENT']) && $arParams['AGREEMENT'] == 'Y') { ?>
                            <div class="popup-form-input">
                                <div class="check active">
                                    <? $APPLICATION->IncludeFile(
                                        $arResult['TEMPLATE_PATH'] . "/agreement.php",
                                        Array(),
                                        Array("MODE" => "html", "NAME" => "Соглашение")
                                    ); ?>
                                    <input type="checkbox" checked="checked" value="1" class="req" name="AGREEMENT"/>
                                </div>
                            </div>
                        <? } ?>

                        <div class="form-button">
                            <input type="submit" name="submit" class="form__btn btn fw" value="<?= !empty($arParams['BTN_TEXT']) ? $arParams['BTN_TEXT'] : GetMessage("MFT_SUBMIT") ?>">
                        </div>
                        <input type="hidden" name="PARAMS_HASH" value="<?= $arResult["PARAMS_HASH"] ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
