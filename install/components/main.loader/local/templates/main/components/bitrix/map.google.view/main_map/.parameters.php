<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"POPUP_TITLE" => Array(
		"PARENT" => "VISUAL",
		"NAME" => 'Заголовок',
		"TYPE" => "STRING",
		"DEFAULT" => "Наш офис",
	),
	"ADDRESS" => Array(
        "PARENT" => "VISUAL",
		"NAME" => 'Адрес',
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
	"PHONE" => Array(
        "PARENT" => "VISUAL",
		"NAME" => 'Телефон',
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
	"EMAIL" => Array(
        "PARENT" => "VISUAL",
		"NAME" => 'E-mail',
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
	"LEFT_BTN" => Array(
        "PARENT" => "VISUAL",
		"NAME" => 'Текст левой кнопки',
		"TYPE" => "STRING",
		"DEFAULT" => "Получить КП",
	),
	"RIGTH_BTN" => Array(
        "PARENT" => "VISUAL",
		"NAME" => 'Текст правой кнопки',
		"TYPE" => "STRING",
		"DEFAULT" => "Обратный звонок",
	),
	"API_KEY" => Array(
        "HIDDEN" => 'Y',
	),
);
?>
