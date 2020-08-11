<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Web\Json;

$IBLOCK_ID = 7;

$site = ($_REQUEST["site"] <> '' ? $_REQUEST["site"] : ($_REQUEST["src_site"] <> '' ? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "FEEDBACK_FORM", "ACTIVE" => "Y");
if ($site !== false)
    $arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by = "ID", $order = "DESC", $arFilter);
while ($arType = $dbType->GetNext())
    $arEvent[$arType["ID"]] = "[" . $arType["ID"] . "] " . $arType["SUBJECT"];

$arFields = array();
if (CModule::IncludeModule("iblock")) {
    $rs = CIBlockProperty::GetList(array(), array('IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y'));
    while ($ar = $rs->GetNext()) {
        $arFields[$ar['CODE']] = $ar['NAME'];
    }
}

$arFieldsSort = array();
if (!empty($arCurrentValues['FIELDS'])) {
    foreach ($arFields as $code => $name) {
        if (in_array($code, $arCurrentValues['FIELDS'])) {
            $arFieldsSort[$code] = $name;
        }
    }
}

$arComponentParameters = array(
    "PARAMETERS" => array(
        "USE_CAPTCHA" => Array(
            "NAME" => GetMessage("MFP_CAPTCHA"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "BASE",
        ),
        "MESSAGE_TITLE" => Array(
            "NAME" => 'Заголовок в админке',
            "TYPE" => "STRING",
            "PARENT" => "BASE",
            "DEFAULT" => "Сообщение из формы обратной связи"
        ),
        "TITLE_TEXT" => Array(
            "NAME" => 'Заголовок',
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "MINITITLE_TEXT" => Array(
            "NAME" => 'Заголовок поменьше',
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "SUBTITLE_TEXT" => Array(
            "NAME" => 'Подзаголовок',
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "OK_TITLE" => Array(
            "NAME" => "Заголовок успешного сообщения",
            "TYPE" => "STRING",
            "DEFAULT" => GetMessage("MFP_OK_TEXT"),
            "PARENT" => "BASE",
        ),
        "OK_TEXT" => Array(
            "NAME" => GetMessage("MFP_OK_MESSAGE"),
            "TYPE" => "STRING",
            "DEFAULT" => GetMessage("MFP_OK_TEXT"),
            "PARENT" => "BASE",
        ),
        "EMAIL_TO" => Array(
            "NAME" => GetMessage("MFP_EMAIL_TO"),
            "TYPE" => "STRING",
            "DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")),
            "PARENT" => "BASE",
        ),
        "FIELDS" => array(
            "NAME" => GetMessage("MFP_FIELDS"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arFields,
            "DEFAULT" => "",
            "COLS" => 25,
            "SIZE" => 5,
            "PARENT" => "BASE",
            "REFRESH" => 'Y'
        ),
        'FIELDS_SORT' => array(
            'PARENT' => 'BASE',
            'NAME' => "Порядок следования полей",
            'TYPE' => 'CUSTOM',
            'JS_FILE' => \Bitrix\Iblock\Component\Base::getSettingsScript('/local/components/phpdevorg/feedback.form', 'dragdrop_order'),
            'JS_EVENT' => 'initDraggableOrderControl',
            'JS_DATA' => Json::encode($arFieldsSort),
        ),
        "REQUIRED_FIELDS" => Array(
            "NAME" => GetMessage("MFP_REQUIRED_FIELDS"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => array_merge($arFields, Array("NONE" => GetMessage("MFP_ALL_REQ"))),
            "DEFAULT" => "",
            "COLS" => 25,
            "SIZE" => 5,
            "PARENT" => "BASE",
        ),
        "EVENT_MESSAGE_ID" => Array(
            "NAME" => GetMessage("MFP_EMAIL_TEMPLATES"),
            "TYPE" => "LIST",
            "VALUES" => $arEvent,
            "DEFAULT" => "",
            "MULTIPLE" => "Y",
            "COLS" => 25,
            "PARENT" => "BASE",
        ),
        "AGREEMENT" => Array(
            "NAME" => 'Отображать согласие?',
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "BASE",
        ),
        "BTN_TEXT" => Array(
            "NAME" => 'Текст кнопки "Отправить"',
            "TYPE" => "STRING",
            "DEFAULT" => "Отправить",
            "PARENT" => "BASE",
        ),
        "FORM_CLASS" => Array(
            "NAME" => 'Идентификатор формы',
            "TYPE" => "STRING",
        ),
        "IBLOCK_ID" => Array(
            "HIDDEN" => 'Y',
            "NAME" => 'ID инфоблока',
            "TYPE" => "STRING",
            "DEFAULT" => $IBLOCK_ID
        ),
        'AJAX_MODE' => array()
    )
);


?>