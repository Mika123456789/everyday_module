<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<footer>
    <div class='container'>
        <div class="footer-body">
            <div class="footer__column">
                <div class="footer__copy">
                    <? $APPLICATION->IncludeFile(
                        SITE_DIR . "/includes/copyright.php",
                        Array(),
                        Array("MODE" => "html", "NAME" => "Copyright")
                    ); ?>
                </div>
            </div>
            <div class="footer__column">
                <a href="#policy" class="footer__link pl">
                    <? $APPLICATION->IncludeFile(
                        SITE_DIR . "/includes/confidential_link_title.php",
                        Array(),
                        Array("MODE" => "text", "NAME" => "Текст")
                    ); ?>
                </a>
            </div>
            <div class="footer__column">
                <div class="footer__label">Разработка сайта:</div>
                <a href="http://insky.digital/" target="_blank" class="footer__dev">
                    <img src="<?= SITE_TEMPLATE_PATH?>/img/dev.svg" alt=""/>
                </a>
            </div>
        </div>
    </div>
</footer>
<!-- <div class="mainpage pdb"> -->
</div>

<div class="flyform-bodybutton">
    <a href="#sendplan" class="flyform-bodybutton__btn pl">
        <? $APPLICATION->IncludeFile(
            SITE_DIR . "/includes/flybtn_text.php",
            Array(),
            Array("MODE" => "text", "NAME" => "Текст")
        ); ?>
    </a>
</div>
<!-- <div class="wrapper"> -->
</div>
<!--<div class="popup popup-callback">
    <div class="popup-table table">
        <div class="cell">
            <div class="popup-content">
                <div class="popup-content-body">
                    <div class="popup-close"></div>
                    <div class="popup__title">Обратный звонок</div>
                    <div class="popup__txt">Оставьте ваши контактные данные и наши менеджеры перезвонят вам в ближайшее
                        время
                    </div>
                    <form data-ms="ms_1" action="#" class="popup-form form">
                        <div class="popup-form-input">
                            <div class="form__label">Ваше имя</div>
                            <div class="form-input">
                                <input autocomplete="off" type="text" name="form[]" data-value="" class="input req"/>
                            </div>
                        </div>
                        <div class="popup-form-input">
                            <div class="form__label">Ваш телефон</div>
                            <div class="form-input">
                                <input autocomplete="off" type="text" name="form[]" data-value="" class="input req"/>
                            </div>
                        </div>
                        <div class="popup-form-input">
                            <div class="check">Я даю свое согласие на обработку персональных данныхв соответствии с <a
                                    href="#policy" class="pl" target="_blank">Условиями</a><input type="checkbox"
                                                                                                  value="1" class="req"
                                                                                                  name="form[]"/></div>
                        </div>
                        <div class="form-button">
                            <button type="submit" class="form__btn btn fw">Перезвоните мне</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
<!--<div class="popup popup-sendplan">
    <div class="popup-table table">
        <div class="cell">
            <div class="popup-content">
                <div class="popup-content-body">
                    <div class="popup-close"></div>
                    <div class="popup-sendplan-form">
                        <div class="equipment-body__title">Просто поставьте нам задачу и мы выполним ее по стандартам
                            оснащения МинЗдрава
                        </div>
                        <form action="#" class="equipment-form-body">
                            <div class="equipment-form-row">
                                <div class="form__label">Что необходимо оснастить?</div>
                                <div class="form-input">
                                    <select multiple="multiple" name="form[]" class="form">
                                        <option value="" selected="selected">Выберите из списка</option>
                                        <option value="1">Нужна консультация</option>
                                        <option value="2">Клинику целиком</option>
                                        <option value="3">Кабинет гинекологии</option>
                                        <option value="4">Кабинет ЛОР</option>
                                        <option value="5">Кабинет УЗД</option>
                                        <option value="6">Рентген-кабинет</option>
                                        <option value="7">МРТ/КТ кабинет</option>
                                        <option value="8">ФГ кабинет</option>
                                        <option value="9">Операционная комната</option>
                                        <option value="10">Реанимация</option>
                                        <option value="11">Другое</option>
                                    </select>
                                </div>
                            </div>
                            <div class="equipment-form-row">
                                <div class="form__label">У вас уже есть планировка помещений?</div>
                                <div class="form-addfile">
                                    <div class="form-addfile-block">
                                        <div class="form-addfile-content">
                                            <span class="form-addfile__btn btn fw min">Выберите файл для загрузки</span>
                                            <div class="form-addfile__info">или перетащите их мышью</div>
                                        </div>
                                        <input class="form-addfile__input" multiple="multiple" type="file"/>
                                    </div>
                                    <ul class="form-addfile-list"></ul>
                                </div>
                            </div>
                            <div class="equipment-form-row">
                                <div class="form__label">Выберите бренд</div>
                                <div class="form-input">
                                    <select name="form[]" class="form">
                                        <option value="1" selected="selected">Доверяю профессионалам</option>
                                        <option value="2">Пункт №2</option>
                                        <option value="3">Пункт №3</option>
                                        <option value="4">Пункт №4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="equipment-form-row">
                                <div class="form__label">Ваш телефон</div>
                                <div class="form-input">
                                    <input autocomplete="off" type="text" name="form[]" data-value="+7 495 123 45 67"
                                           class="input req"/>
                                </div>
                            </div>
                            <div class="equipment-form-row">
                                <div class="form__label">Ваш email</div>
                                <div class="form-input">
                                    <input autocomplete="off" type="text" name="form[]" data-value="name@mail.ru"
                                           class="input req email"/>
                                </div>
                            </div>
                            <div class="equipment-form-button">
                                <button type="submit" class="equipment-form__btn btn fw">Рассчитать стоимость</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<!--<div class="popup popup-getprice">
    <div class="popup-table table">
        <div class="cell">
            <div class="popup-content">
                <div class="popup-content-body">
                    <div class="popup-close"></div>
                    <div class="popup__title">Узнать стоимость</div>
                    <div class="popup__txt">Оставьте ваши контактные данные и наши менеджеры перезвонят вам в ближайшее
                        время
                    </div>
                    <form data-ms="ms_1" action="#" class="popup-form form">
                        <div class="popup-form-input">
                            <div class="form__label">Ваше имя</div>
                            <div class="form-input">
                                <input autocomplete="off" type="text" name="form[]" data-value="" class="input req"/>
                            </div>
                        </div>
                        <div class="popup-form-input">
                            <div class="form__label">Ваш телефон</div>
                            <div class="form-input">
                                <input autocomplete="off" type="text" name="form[]" data-value="" class="input req"/>
                            </div>
                        </div>
                        <div class="popup-form-input">
                            <div class="form__label">Ваш email</div>
                            <div class="form-input">
                                <input autocomplete="off" type="text" name="form[]" data-value=""
                                       class="input email req"/>
                            </div>
                        </div>
                        <div class="popup-form-input">
                            <div class="check">Я даю свое согласие на обработку персональных данныхв соответствии с <a
                                    href="#policy" class="pl" target="_blank">Условиями</a><input type="checkbox"
                                                                                                  value="1" class="req"
                                                                                                  name="form[]"/></div>
                        </div>
                        <div class="form-button">
                            <button type="submit" class="form__btn btn fw">Перезвоните мне</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
<div class="popup popup--size_2 popup-recomendations">
    <div class="popup-table table">
        <div class="cell">
            <div class="popup-content">
                <div class="popup-content-body">
                    <div class="popup-close"></div>
                    <div class="popup__title">
                        <? $APPLICATION->IncludeFile(
                            SITE_DIR . "/includes/popup_recomendations_title.php",
                            Array(),
                            Array("MODE" => "html", "NAME" => "Текст")
                        ); ?>
                    </div>
                    <div class="popup__txt">
                        <? $APPLICATION->IncludeFile(
                            SITE_DIR . "/includes/popup_recomendations_subtitle.php",
                            Array(),
                            Array("MODE" => "html", "NAME" => "Текст")
                        ); ?>
                    </div>
                    <div class="popup-recomendations-body popup-content-scroll">
                        <div class="popup-content-scroll-list">
                            <div class="popup-recomendations__text">
                                <? $APPLICATION->IncludeFile(
                                    SITE_DIR . "/includes/popup_recomendations_text.php",
                                    Array(),
                                    Array("MODE" => "html", "NAME" => "Текст")
                                ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="popup-recomendations-footer">
                        <a href="#sendplan" class="popup-recomendations__btn btn pl">
                            <? $APPLICATION->IncludeFile(
                                SITE_DIR . "/includes/popup_recomendations_btn.php",
                                Array(),
                                Array("MODE" => "html", "NAME" => "Текст")
                            ); ?>
                        </a>
                        <!--
                        <div class="popup-recomendations-footer__column">
                            <a href="" class="popup-recomendations__btn btn fw pl">Проверить планировку бесплатно</a>
                        </div>
                        <div class="popup-recomendations-footer__column">
                            <a href="#" class="popup-recomendations__btn btn-3 fw sendplan">Заказать планировку клиники</a>
                        </div>
                         -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup popup--size_2 popup-policy">
    <div class="popup-table table">
        <div class="cell">
            <div class="popup-content">
                <div class="popup-content-body">
                    <div class="popup-close"></div>
                    <? $APPLICATION->IncludeFile(
                        SITE_DIR . "/includes/confidential_popup.php",
                        Array(),
                        Array("MODE" => "html", "NAME" => "Текст")
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup popup--size_2 popup-awards">
    <div class="popup-table table">
        <div class="cell">
            <div class="popup-content">
                <div class="popup-content-body popup-awards-body">
                    <div class="popup-close"></div>
                    <? $APPLICATION->IncludeFile(
                        SITE_DIR . "/includes/popup_awards.php",
                        Array(),
                        Array("MODE" => "html", "NAME" => "Текст")
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?$APPLICATION->IncludeComponent(
	"phpdevorg:feedback.form", 
	"popup_form", 
	array(
		"EMAIL_TO" => "insky.digital@gmail.com",
		"EVENT_MESSAGE_ID" => array(
			0 => "7",
		),
		"OK_TEXT" => "Мы получили вашу заявку и наши менеджеры свяжутся с вами в ближайшее время.",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "PHONE",
		),
		"TITLE_TEXT" => "Обратный звонок",
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "popup_form",
		"SUBTITLE_TEXT" => "Оставьте ваши контактные данные и наши менеджеры перезвонят вам в ближайшее время",
		"FIELDS" => array(
			0 => "NAME",
			1 => "PHONE",
		),
		"AGREEMENT" => "Y",
		"BTN_TEXT" => "Перезвоните мне",
		"FORM_CLASS" => "callback",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"IBLOCK_ID" => "7",
		"FIELDS_SORT" => "FILES,BRAND,NAME,LIST,PHONE,EMAIL",
		"OK_TITLE" => "Спасибо! <br/> Ваша заявка принята!",
		"MESSAGE_TITLE" => "Сообщение из формы \"Обратный звонок\"",
		"MINITITLE_TEXT" => ""
	),
	false
);?>
<?$APPLICATION->IncludeComponent(
	"phpdevorg:feedback.form", 
	"popup_form", 
	array(
		"EMAIL_TO" => "insky.digital@gmail.com",
		"EVENT_MESSAGE_ID" => array(
			0 => "7",
		),
		"OK_TEXT" => "Мы получили вашу заявку и наши менеджеры свяжутся с вами в ближайшее время.",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE",
			1 => "EMAIL",
		),
		"TITLE_TEXT" => "",
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "popup_form",
		"SUBTITLE_TEXT" => "",
		"FIELDS" => array(
			0 => "PHONE",
			1 => "BRAND",
			2 => "EMAIL",
			3 => "FILES",
			4 => "LIST",
		),
		"AGREEMENT" => "Y",
		"BTN_TEXT" => "Рассчитать стоимость",
		"FORM_CLASS" => "sendplan",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"IBLOCK_ID" => "7",
		"FIELDS_SORT" => "LIST,FILES,BRAND,PHONE,EMAIL",
		"OK_TITLE" => "Спасибо! <br/> Ваша заявка принята!",
		"MINITITLE_TEXT" => "Просто поставьте нам задачу и мы выполним ее по стандартам оснащения МинЗдрава",
		"MESSAGE_TITLE" => "Сообщение из формы \"Просто поставьте нам задачу\""
	),
	false
);?>
<?$APPLICATION->IncludeComponent(
	"phpdevorg:feedback.form", 
	"popup_form", 
	array(
		"EMAIL_TO" => "insky.digital@gmail.com",
		"EVENT_MESSAGE_ID" => array(
			0 => "7",
		),
		"OK_TEXT" => "Мы получили вашу заявку и наши менеджеры свяжутся с вами в ближайшее время.",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
		),
		"TITLE_TEXT" => "Узнать стоимость",
		"USE_CAPTCHA" => "Y",
		"COMPONENT_TEMPLATE" => "popup_form",
		"SUBTITLE_TEXT" => "Оставьте ваши контактные данные и наши менеджеры перезвонят вам в ближайшее время",
		"FIELDS" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
		),
		"AGREEMENT" => "Y",
		"BTN_TEXT" => "Перезвоните мне",
		"FORM_CLASS" => "getprice",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"IBLOCK_ID" => "7",
		"FIELDS_SORT" => "NAME,PHONE,EMAIL",
		"OK_TITLE" => "Спасибо! <br/> Ваша заявка принята!",
		"MINITITLE_TEXT" => "",
		"MESSAGE_TITLE" => "Сообщение из формы \"Узнать стоимость\""
	),
	false
);?>

<div class="popup popup-video">
    <div class="popup-table table">
        <div class="cell">
            <div class="popup-close"></div>
            <div class="popup-video__value"></div>
        </div>
    </div>
</div>

</body>
</html>
