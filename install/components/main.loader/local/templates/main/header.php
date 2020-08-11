<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
use Bitrix\Main\Page\Asset;
?>
<?
define("SITE_SERVER_PROTOCOL", (CMain::IsHTTPS()) ? "https://" : "http://");
global $USER;
$currentPage = $APPLICATION->GetCurPage(false);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?$APPLICATION->ShowHead();?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/style.css');?>
    <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/custom.css');?>
    <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/jquery.fancybox.min.css');?>
    <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/phpdevorg.style.css');?>

    <?Asset::getInstance()->addJs('https://code.jquery.com/jquery-3.3.1.min.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/vendors.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/main.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/custom.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.fancybox.min.js');?>
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/phpdevorg.script.js');?>
    <link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH?>/favicon.ico">
    <!-- <meta name="robots" content="noindex, nofollow" /> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KZHW9WQ');</script>
<!-- End Google Tag Manager -->
<script type="text/javascript">
    // RocketCRM Analytics:
    (function(w, d, s, h, token) {w.RocketCRMToken = token; w.RocketCRMDomain = h;var p = "https://";var u = '/api/analytics/js?hash=' + token;var js = d.createElement(s); js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);})(window, document, 'script', 'b2b.rocketcrm.bz', '43f5c80d18');
</script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KZHW9WQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?$APPLICATION->ShowPanel()?>
<div class="wrapper">
    <header>
        <?$APPLICATION->IncludeComponent("bitrix:menu", "main_menu", Array(
            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
            "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
            "DELAY" => "N",	// Откладывать выполнение шаблона меню
            "MAX_LEVEL" => "1",	// Уровень вложенности меню
            "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                0 => "",
            ),
            "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "MENU_CACHE_TYPE" => "N",	// Тип кеширования
            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
            "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
            "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
        ),
            false
        );?>
        <div class="header-body">
            <div class="container">
                <div class="header-row">
                    <div class="header__column">
                        <a href="/" class="header__logo"><img src="<?= SITE_TEMPLATE_PATH?>/img/logo.svg" alt="" /><span><? $APPLICATION->IncludeFile(
                                    SITE_DIR . "/includes/logo_description.php",
                                    Array(),
                                    Array("MODE" => "html", "NAME" => "Текст")
                                ); ?></span></a>
                    </div>
                    <div class="header__column">
                        <div class="header-phone">
                            <? $phone = preg_replace("/[^0-9]/", '', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/includes/phone.php")); ?>
                            <a href="tel:+<?= $phone?>" class="header-phone__item">
                                <? $APPLICATION->IncludeFile(
                                    SITE_DIR . "/includes/phone.php",
                                    Array(),
                                    Array("MODE" => "text", "NAME" => "Телефон")
                                ); ?>
                            </a>
                            <div class="header-phone__label">
                                <? $APPLICATION->IncludeFile(
                                    SITE_DIR . "/includes/phone_description.php",
                                    Array(),
                                    Array("MODE" => "html", "NAME" => "Текст")
                                ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="header__column">
                        <div class="header-menu__icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <a href="#callback" class="header__btn btn-2 min pl"><? $APPLICATION->IncludeFile(
                                SITE_DIR . "/includes/callback_title.php",
                                Array(),
                                Array("MODE" => "text", "NAME" => "Текст")
                            ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mainpage pdb">