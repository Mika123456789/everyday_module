<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);

?>
<script src="http://maps.google.com/maps/api/js?sensor=false&amp;key=<?= $arParams['API_KEY'] ?>"></script>
<?
$arAllMapOptions = array_merge(
    array(
        'ENABLE_SCROLL_ZOOM' => 'scrollwheel: #true#',
        'ENABLE_DBLCLICK_ZOOM' => 'disableDoubleClickZoom: #false#',
        'ENABLE_DRAGGING' => 'draggable: #true#',
        'ENABLE_KEYBOARD' => 'keyboardShortcuts: #true#'
    ),
    array(
        'TYPECONTROL' => 'mapTypeControl: #true#',
        'SMALL_ZOOM_CONTROL' => 'zoomControl: #true#',
        'SCALELINE' => 'scaleControl: #true#',
    )
);
$arMapOptions = array_merge($arParams['OPTIONS'], $arParams['CONTROLS']);
?>
<?
$arStyleParams = array();
if (!empty($arParams['MAP_HEIGHT'])) {
    $arStyleParams[] = 'height:' . $arParams['MAP_HEIGHT'];
}
if (!empty($arParams['MAP_WIDTH'])) {
    $arStyleParams[] = 'width:' . $arParams['MAP_WIDTH'];
}
?>
<? if (!empty($arStyleParams)) { ?>
    <style>
        @media (min-width: 1259px) {
            .contacts-map {
            <?= implode(';',$arStyleParams)?>
            }
        }
    </style>
<? } ?>
<div class="contacts-map" id="map"></div>
<div class="contacts-items">
    <div class="contacts-item contacts-item--1">
        <div class="contacts-item-content">
            <div class="contacts-item__title"><?= $arParams['POPUP_TITLE']?></div>
            <div class="contacts-item-body">
                <div class="contacts-item-block">
                    <div class="contacts-item__label">адрес:</div>
                    <div class="contacts-item__value">
                        <?= $arParams['ADDRESS']?>
                    </div>
                </div>
                <div class="contacts-item-block">
                    <div class="contacts-item__label">телефон:</div>
                    <a href="tel:+<?= preg_replace("/[^0-9]/", '', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/includes/phone.php"));?>" class="contacts-item__value"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/includes/phone.php")?></a>
                </div>
                <div class="contacts-item-block">
                    <div class="contacts-item__label">e-mail:</div>
                    <a href="mailto:<?= $arParams['EMAIL']?>" class="contacts-item__value"><?= $arParams['EMAIL']?></a>
                </div>
            </div>
            <div class="contacts-item-buttons">
                <div class="contacts-item-buttons__column">
                    <a href="#sendplan" class="contacts-item__btn btn pl fw"><?= $arParams['LEFT_BTN']?></a>
                </div>
                <div class="contacts-item-buttons__column">
                    <a href="#callback" class="contacts-item__btn btn-2 fw pl"><?= $arParams['RIGTH_BTN']?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var w = $(window).outerWidth();
    var h = $(window).outerHeight();
    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        }, BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        }, iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        }, Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        }, Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        }, any: function () {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    function map(n) {
        google.maps.Map.prototype.setCenterWithOffset = function (latlng, offsetX, offsetY) {
            var map = this;
            var ov = new google.maps.OverlayView();
            ov.onAdd = function () {
                var proj = this.getProjection();
                var aPoint = proj.fromLatLngToContainerPixel(latlng);
                aPoint.x = aPoint.x + offsetX;
                aPoint.y = aPoint.y + offsetY;
                map.panTo(proj.fromContainerPixelToLatLng(aPoint));
                //map.setCenter(proj.fromContainerPixelToLatLng(aPoint));
            };
            ov.draw = function () {
            };
            ov.setMap(this);
        };
        var markers = new Array();
        var infowindow = new google.maps.InfoWindow({
            //pixelOffset: new google.maps.Size(-230,250)
        });
        var locations = [
            [new google.maps.LatLng(<?= $arResult['POSITION']['google_lat']?>,<?= $arResult['POSITION']['google_lon']?>)],
        ];
        var options = {
            zoom: <?= $arResult['POSITION']['google_scale']?>,
            panControl: false,
            center: locations[0][0],
            mapTypeId: google.maps.MapTypeId.<?= $arParams['INIT_MAP_TYPE']?>,
            <?
            foreach ($arAllMapOptions as $option => $method) {

                echo "\t\t" . (
                    in_array($option, $arMapOptions)
                        ? str_replace(array('#true#', '#false#'), array('true', 'false'), $method)
                        : str_replace(array('#false#', '#true#'), array('true', 'false'), $method)
                    ) . ",\r\n";
            }
            ?>
        };
        var map = new google.maps.Map(document.getElementById('map'), options);
        var icon = {
            url: '/local/templates/main/components/bitrix/map.google.view/main_map/images/map.svg',
            scaledSize: new google.maps.Size(42, 56),
            anchor: new google.maps.Point(21, 28)
        };
        for (var i = 0; i < locations.length; i++) {
            var marker = new google.maps.Marker({
                icon: icon,
                position: locations[i][0],
                map: map,
            });
            if (w > 767) {
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        for (var m = 0; m < markers.length; m++) {
                            markers[m].setIcon(icon);
                        }
                        var cnt = i + 1;
                        infowindow.setContent($('.contacts-item--' + cnt).html());
                        infowindow.open(map, marker);
                        marker.setIcon(icon);
                        map.setCenterWithOffset(marker.getPosition(), 0, 0);
                        setTimeout(function () {
                            baloonstyle();
                        }, 10);
                    }
                })(marker, i));
                markers.push(marker);
            }
        }

        if (n && w > 767) {
            var nc = n - 1;
            setTimeout(function () {
                google.maps.event.trigger(markers[nc], 'click');
            }, 500);
        }
    }

    function baloonstyle() {
        $('.gm-style-iw').parent().addClass('baloon');
        $('.gm-style-iw').prev().addClass('baloon-style');
        $('.gm-style-iw').next().addClass('baloon-close');
        $('.gm-style-iw').addClass('baloon-content');
    }

    if ($("#map").length > 0) {
        map(1);
    }
</script>

