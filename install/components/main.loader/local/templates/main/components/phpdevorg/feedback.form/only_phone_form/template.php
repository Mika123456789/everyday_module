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
        FormsOb.forms(1);
    </script>
<? } ?>
<? if (strlen($arResult["OK_MESSAGE"]) > 0) { ?>
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


<form data-ms="ms_1" action="<?= POST_FORM_ACTION_URI ?>" class="mainblock-form" method="post">
    <?= bitrix_sessid_post() ?>
    <? if (!empty($arParams['TITLE_TEXT'])) { ?>
        <div class="mainblock-form__title">
            <?= $arParams['TITLE_TEXT'] ?>
        </div>
    <? } ?>
    <div class="mainblock-form-body">
        <input autocomplete="off" type="text" name="PHONE" placeholder="<?= $arParams['PLACEHOLDER'] ?>"
               class="mainblock-form__input input req min"/>
        <input type="submit" name="submit" class="mainblock-form__btn btn-2 min"
               value="<?= !empty($arParams['BTN_TEXT']) ? $arParams['BTN_TEXT'] : GetMessage("MFT_SUBMIT") ?>">
    </div>
    <input type="hidden" name="PARAMS_HASH" value="<?= $arResult["PARAMS_HASH"] ?>">
</form>
