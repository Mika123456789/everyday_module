<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

if (!$this->InitComponentTemplate())
    return;

$template = &$this->GetTemplate();
$templatePath = $template->GetFile();
$templateFolder = $template->GetFolder();

$arResult['TEMPLATE_PATH'] = $templateFolder;

if (!empty($arParams['FIELDS'])) {
    if (CModule::IncludeModule("iblock")) {
        $arResult['ITEMS'] = array();

        $tmp = explode(',', $arParams['FIELDS_SORT']);
        foreach ($tmp as $k) {
            $arResult['ITEMS'][$k] = '';
        }

        $rs = CIBlockProperty::GetList(array(), array('IBLOCK_ID' => (int)$arParams['IBLOCK_ID'], 'ACTIVE' => 'Y'));
        while ($ar = $rs->GetNext()) {
            if (in_array($ar['CODE'], $arParams['FIELDS'])) {
                if (!empty($arParams['REQUIRED_FIELDS']) && in_array($ar['CODE'], $arParams['REQUIRED_FIELDS'])) {
                    $ar['REQUIRED_FIELD'] = 'Y';
                }
                if ($ar['PROPERTY_TYPE'] == 'L') {
                    $rsL = CIBlockProperty::GetPropertyEnum($ar['CODE'], Array('sort' => 'asc'), Array("IBLOCK_ID" => (int)$arParams['IBLOCK_ID']));
                    while ($arL = $rsL->GetNext()) {
                        $ar['VALUE_LIST'][$arL['ID']] = $arL['VALUE'];
                    }
                }
                if ($ar['PROPERTY_TYPE'] == 'E') {
                    $rsL = CIBlockElement::GetList(Array('SORT' => 'ASC'), Array("IBLOCK_ID" => (int)$ar['LINK_IBLOCK_ID'], 'ACTIVE' => 'Y'), false, false, array('ID', 'IBLOCK_ID', 'NAME'));
                    while ($arL = $rsL->GetNext()) {
                        $ar['VALUE_LIST'][$arL['ID']] = $arL['NAME'];
                    }
                }
                $arResult['ITEMS'][$ar['CODE']] = $ar;
            }
        }
    }
}

$arResult["PARAMS_HASH"] = md5(serialize($arParams) . $this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if ($arParams["EVENT_NAME"] == '')
    $arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if ($arParams["EMAIL_TO"] == '')
    $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if ($arParams["OK_TEXT"] == '')
    $arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"])) {
    $arResult["ERROR_MESSAGE"] = array();
    if (check_bitrix_sessid()) {
        if (!empty($arParams['FIELDS']) && (empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))) {
            foreach ($arParams['FIELDS'] as $code) {
                if (in_array($code, $arParams["REQUIRED_FIELDS"]) && empty($_POST[$code])) {
                    $arResult["ERROR_MESSAGE"][] = 'Заполните все обязательные поля';
                    break;
                }
            }
        }
        if (is_numeric(stripos("@", $_POST["EMAIL"]))) {
            if (strlen($_POST["EMAIL"]) > 1 && !check_email($_POST["EMAIL"])) {
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");
            }
        }

        if ($arParams["USE_CAPTCHA"] == "Y") {
            include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/classes/general/captcha.php");
            $captcha_code = $_POST["captcha_sid"];
            $captcha_word = $_POST["captcha_word"];
            $cpt = new CCaptcha();
            $captchaPass = COption::GetOptionString("main", "captcha_password", "");
            if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0) {
                if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
            } else
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");

        }
        if (empty($arResult["ERROR_MESSAGE"])) {
            $arFields = Array(
                'TEXT' => '',
                'EMAIL_TO' => $arParams['EMAIL_TO']
            );

            if (CModule::IncludeModule("iblock")) {
                $el = new CIBlockElement;

                $arLoadProductArray = array();
                $arUploadFiles = array();

                $PROP = array();
                if (!empty($arParams['FIELDS'])) {
                    foreach ($arParams['FIELDS'] as $code) {
                        if (!empty($_POST[$code]))
                            $PROP[$code] = $_POST[$code];
                    }
                }

                if (!empty($_FILES)) {
                    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload/tmp/';
                    $filesCode = array_key_first($_FILES);
                    $arAllFiles = array();
                    foreach ($_FILES[$filesCode]['name'] as $key => $file) {
                        if (!empty($_POST['DELETE_FILES']) && in_array($file, $_POST['DELETE_FILES']))
                            continue;

                        $uploadFile = $uploadDir . basename($file);
                        move_uploaded_file($_FILES[$filesCode]['tmp_name'][$key], $uploadFile);
                        $tt = CFile::MakeFileArray($uploadFile);
                        $arAllFiles[] = $tt;

                    }

                    if (!empty($arAllFiles))
                        $PROP[$filesCode] = $arAllFiles;
                }

                $arLoadProductArray = Array(
                    "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                    "PROPERTY_VALUES" => $PROP,
                    "NAME" => !empty($arParams['MESSAGE_TITLE']) ? html_entity_decode($arParams['MESSAGE_TITLE']) : "Сообщение из формы обратной связи",
                    "ACTIVE_FROM" => date('d.m.Y H:i:s'),
                    "ACTIVE" => "Y",
                );

                if ($ID = $el->Add($arLoadProductArray)) {
                    if (!empty($arAllFiles)) {
                        $rs = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $ID), false, false, array('ID', 'IBLOCK_ID', 'PROPERTY_FILES'));
                        if ($ar = $rs->GetNext()) {
                            $arUploadFiles = $ar['PROPERTY_FILES_VALUE'];
                        }
                    }
                }
            }

            if (!empty($arResult['ITEMS'])) {
                $text = !empty($arParams['MESSAGE_TITLE']) ? "<h2>" . $arParams['MESSAGE_TITLE'] . "</h2>" : "";
                foreach ($arResult['ITEMS'] as $code => $arField) {
                    if (!empty($_POST[$code])) {
                        if ($arField['PROPERTY_TYPE'] == 'L' || $arField['PROPERTY_TYPE'] == 'E') {
                            if (is_array($_POST[$code])) {
                                $arTmp = array();
                                foreach ($_POST[$code] as $id) {
                                    if (!empty($id))
                                        $arTmp[] = $arField['VALUE_LIST'][$id];
                                }
                                if (!empty($arTmp))
                                    $text .= "<p><strong>" . $arField['NAME'] .": </strong>" . implode(', ', $arTmp) . "</p>";
                            } else {
                                $text .= "<p><strong>" . $arField['NAME'] .": </strong>" . $arField['VALUE_LIST'][$_POST[$code]] . "</p>";
                            }
                        } else {
                            $text .= "<p><strong>" . $arField['NAME'] .": </strong>" . $_POST[$code] . "</p>";
                        }
                    }
                }
                $arFields['TEXT'] = $text;
            }

            if (!empty($arParams["EVENT_MESSAGE_ID"])) {
                foreach ($arParams["EVENT_MESSAGE_ID"] as $v)
                    if (IntVal($v) > 0)
                        CEvent::SendImmediate($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v), $arUploadFiles);
            } else
                CEvent::SendImmediate($arParams["EVENT_NAME"], SITE_ID, $arFields, "Y", "", $arUploadFiles);

            $post = $_POST;
			unset($post['bxajaxid']);
			unset($post['AJAX_CALL']);
			unset($post['sessid']);
			unset($post['MAX_FILE_SIZE']);
	        unset($post['PARAMS_HASH']);
			/*unset($post['BRAND']);
			unset($post['AGREEMENT']);
	        unset($post['FILES']);
	        unset($post['LIST']);*/
	        $this->sendToAmoCRM($post);

            LocalRedirect($APPLICATION->GetCurPageParam("success=" . $arResult["PARAMS_HASH"], Array("success")));
        }

        if (!empty($arParams['FIELDS'])) {
            foreach ($arParams['FIELDS'] as $code) {
                if (is_array($_POST[$code])) {
                    $arResult[$code] = $_POST[$code];
                } else {
                    $arResult[$code] = htmlspecialcharsbx($_POST[$code]);
                }
            }
        }

    } else
        $arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
} elseif ($_REQUEST["success"] == $arResult["PARAMS_HASH"]) {
    $arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if (empty($arResult["ERROR_MESSAGE"])) {
    if ($USER->IsAuthorized()) {
        $arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
    } else {
        if (strlen($_SESSION["MF_NAME"]) > 0)
            $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
        if (strlen($_SESSION["MF_EMAIL"]) > 0)
            $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
    }
}

if ($arParams["USE_CAPTCHA"] == "Y")
    $arResult["capCode"] = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

if (!empty($_POST['user_phone']))
    $arResult["AUTHOR_PHONE"] = $_POST['user_phone'];

if (!empty($_POST['MESSAGE']))
    $arResult['AUTHOR_MESSAGE'] = $_POST['MESSAGE'];

$this->IncludeComponentTemplate();
