//@prepros-append jq-start.js
//@prepros-append scroll.js
//@prepros-append sliders.js
//@prepros-append responsive.js
//@prepros-append map.js
//@prepros-append forms.js
//@prepros-append script.js
//@prepros-append jq-end.js

FormsOb = {
    w: $(window).outerWidth(),
    h: $(window).outerHeight(),
    ua: window.navigator.userAgent,
    msie: window.navigator.userAgent.indexOf("MSIE "),
    isMobile: {
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
            return (FormsOb.isMobile.Android() || FormsOb.isMobile.BlackBerry() || FormsOb.isMobile.iOS() || FormsOb.isMobile.Opera() || FormsOb.isMobile.Windows());
        }
    },

    //FORMS
    forms: function (onlyInit = 0) {
        /*var forms = document.querySelectorAll('form');
        Array.prototype.forEach.call(forms, function (form) {
            ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(function (event) {
                form.addEventListener(event, function (e) {
                    // preventing the unwanted behaviours
                    e.preventDefault();
                    e.stopPropagation();
                });
            });
            if ($(form).find('input[type=file]').length > 0) {
                form.addEventListener( 'drop', function( e )
                {
                    e.preventDefault();
                    // $(form).find("input[type='file']").prop("files", e.dataTransfer.files).trigger('change');

// $(form).find("input[type='file']").setAttributes('files', e.dataTransfer.files);
                    document.getElementById($(form).find("input[type='file']").attr('id')).files = e.dataTransfer.files;
                    // document.getElementById($(form).find("input[type='file']").attr('id')).setAttribute('files', e.dataTransfer.files);

                    $(form).find("input[type='file']").trigger('change');
                    console.log(123, e.dataTransfer.files, document.getElementById($(form).find("input[type='file']").attr('id')), document.getElementById($(form).find("input[type='file']").attr('id')).files);
                });
            }
        });*/
        //SELECT
        if ($('select').length > 0) {
            function selectscrolloptions() {
                var scs = 100;
                var mss = 50;
                if (FormsOb.isMobile.any()) {
                    scs = 10;
                    mss = 1;
                }
                var opt = {
                    cursorcolor: "#a5a5a5",
                    cursorwidth: "4px",
                    background: "#efefef",
                    autohidemode: false,
                    bouncescroll: false,
                    cursorborderradius: "5px",
                    scrollspeed: scs,
                    mousescrollstep: mss,
                    directionlockdeadzone: 0,
                    cursorborder: "0px solid #fff",
                };
                return opt;
            }

            function select() {
                $.each($('select'), function (index, val) {
                    var ind = index;
                    $(this).hide();
                    if ($(this).parent('.select-block').length == 0) {
                        $(this).wrap("<div class='select-block " + $(this).attr('class') + "-select-block'></div>");
                    } else {
                        $(this).parent('.select-block').find('.select').remove();
                    }
                    var milti = '';
                    var check = '';
                    var sblock = $(this).parent('.select-block');
                    var soptions = "<div class='select-options'><div class='select-options-scroll'><div class='select-options-list'>";
                    if ($(this).attr('multiple') == 'multiple') {
                        milti = 'multiple';
                        check = 'check';
                    }
                    $.each($(this).find('option'), function (index, val) {
                        if ($(this).attr('value') != '' && $(this).attr('value') != 0) {
                            soptions = soptions + "<div data-value='" + $(this).attr('value') + "' class='select-options__value_" + ind + " select-options__value value_" + $(this).val() + " " + $(this).attr('class') + " " + check + ($(this).attr('selected') ? ' active ' : '') +"'>" + $(this).html() + "</div>";
                        } else if ($(this).parent().attr('data-label') == 'on') {
                            if (sblock.find('.select__label').length == 0) {
                                sblock.prepend('<div class="select__label">' + $(this).html() + '</div>');
                            }
                        }
                    });
                    soptions = soptions + "</div></div></div>";
                    if ($(this).attr('data-type') == 'search') {
                        sblock.append("<div data-type='search' class='select_" + ind + " select" + " " + $(this).attr('class') + "__select " + milti + "'>" +
                            "<div class='select-title'>" +
                            "<div class='select-title__arrow ion-ios-arrow-down'></div>" +
                            "<input data-value='" + $(this).find('option[selected="selected"]').html() + "' class='select-title__value value_" + $(this).find('option[selected="selected"]').val() + "' />" +
                            "</div>" +
                            soptions +
                            "</div>");
                        $('.select_' + ind).find('input.select-title__value').jcOnPageFilter({
                            parentSectionClass: 'select-options_' + ind,
                            parentLookupClass: 'select-options__value_' + ind,
                            childBlockClass: 'select-options__value_' + ind
                        });
                    } else {
                        sblock.append("<div class='select_" + ind + " select" + " " + $(this).attr('class') + "__select " + milti + "'>" +
                            "<div class='select-title'>" +
                            "<div class='select-title__arrow ion-ios-arrow-down'></div>" +
                            "<div class='select-title__value value_" + $(this).find('option[selected="selected"]').val() + "'>" + $(this).find('option[selected="selected"]').html() + "</div>" +
                            "</div>" +
                            soptions +
                            "</div>");
                    }
                    if ($(this).find('option[selected="selected"]').val() != '') {
                        sblock.find('.select').addClass('focus');
                    }
                    if ($(this).attr('data-req') == 'on') {
                        $(this).addClass('req');
                    }
                    $(".select_" + ind + " .select-options-scroll").niceScroll('.select-options-list', selectscrolloptions());
                });
            }

            select();

            if (onlyInit == 0) {
                $('body').on('keyup', 'input.select-title__value', function () {
                    $('.select').not($(this).parents('.select')).removeClass('active').find('.select-options').slideUp(50);
                    $(this).parents('.select').addClass('active');
                    $(this).parents('.select').find('.select-options').slideDown(50, function () {
                        $(this).find(".select-options-scroll").getNiceScroll().resize();
                    });
                    $(this).parents('.select-block').find('select').val('');
                });

                $('body').on('click', '.select', function () {
                    if (!$(this).hasClass('disabled')) {
                        $('.select').not(this).removeClass('active').find('.select-options').slideUp(50);
                        $(this).toggleClass('active');
                        $(this).find('.select-options').slideToggle(50, function () {
                            $(this).find(".select-options-scroll").getNiceScroll().resize();
                        });

                        //	var input=$(this).parent().find('select');
                        //removeError(input);

                        if ($(this).attr('data-type') == 'search') {
                            if (!$(this).hasClass('active')) {
                                FormsOb.searchselectreset();
                            }
                            $(this).find('.select-options__value').show();
                        }
                    }
                });
                $('body').on('click', '.select-options__value', function () {
                    if ($(this).parents('.select').hasClass('multiple')) {
                        if (!$(this).hasClass('active')) {
                            if ($(this).parents('.select').find('.select-title__value span').length > 0) {
                                $(this).parents('.select').find('.select-title__value').append('<span data-value="' + $(this).data('value') + '">, ' + $(this).html() + '</span>');
                            } else {
                                $(this).parents('.select').find('.select-title__value').data('label', $(this).parents('.select').find('.select-title__value').html());
                                $(this).parents('.select').find('.select-title__value').html('<span data-value="' + $(this).data('value') + '">' + $(this).html() + '</span>');
                            }
                            $(this).parents('.select-block').find('select').find('option').eq($(this).index() + 1).prop('selected', true);
                            $(this).parents('.select').addClass('focus');
                        } else {
                            $(this).parents('.select').find('.select-title__value').find('span[data-value="' + $(this).data('value') + '"]').remove();
                            if ($(this).parents('.select').find('.select-title__value span').length == 0) {
                                $(this).parents('.select').find('.select-title__value').html($(this).parents('.select').find('.select-title__value').data('label'));
                                $(this).parents('.select').removeClass('focus');
                            }
                            $(this).parents('.select-block').find('select').find('option').eq($(this).index() + 1).prop('selected', false);
                        }
                        return false;
                    }

                    if ($(this).parents('.select').attr('data-type') == 'search') {
                        $(this).parents('.select').find('.select-title__value').val($(this).html());
                        $(this).parents('.select').find('.select-title__value').attr('data-value', $(this).html());
                    } else {
                        $(this).parents('.select').find('.select-title__value').attr('class', 'select-title__value value_' + $(this).data('value'));
                        $(this).parents('.select').find('.select-title__value').html($(this).html());

                    }

                    $(this).parents('.select-block').find('select').find('option').removeAttr("selected");
                    if ($.trim($(this).data('value')) != '') {
                        $(this).parents('.select-block').find('select').val($(this).data('value'));
                        $(this).parents('.select-block').find('select').find('option[value="' + $(this).data('value') + '"]').attr('selected', 'selected');
                    } else {
                        $(this).parents('.select-block').find('select').val($(this).html());
                        $(this).parents('.select-block').find('select').find('option[value="' + $(this).html() + '"]').attr('selected', 'selected');
                    }


                    if ($(this).parents('.select-block').find('select').val() != '') {
                        $(this).parents('.select-block').find('.select').addClass('focus');
                    } else {
                        $(this).parents('.select-block').find('.select').removeClass('focus');

                        $(this).parents('.select-block').find('.select').removeClass('err');
                        $(this).parents('.select-block').parent().removeClass('err');
                        $(this).parents('.select-block').removeClass('err').find('.form__error').remove();
                    }
                    if (!$(this).parents('.select').data('tags') != "") {
                        if ($(this).parents('.form-tags').find('.form-tags__item[data-value="' + $(this).data('value') + '"]').length == 0) {
                            $(this).parents('.form-tags').find('.form-tags-items').append('<a data-value="' + $(this).data('value') + '" href="" class="form-tags__item">' + $(this).html() + '<span class="fa fa-times"></span></a>');
                        }
                    }
                    $(this).parents('.select-block').find('select').change();

                    if ($(this).parents('.select-block').find('select').data('update') == 'on') {
                        select();
                    }
                });
                $(document).on('click touchstart', function (e) {
                    if (!$(e.target).is(".select *") && !$(e.target).is(".select") && !$(e.target).is(".select-options")) {
                        $('.select').removeClass('active');
                        $('.select-options').slideUp(50, function () {
                        });
                        FormsOb.searchselectreset();
                    }
                    ;
                });
            }
        }

        //FIELDS
        $('input,textarea').focus(function () {
            if ($(this).val() == $(this).attr('data-value')) {
                $(this).addClass('focus');
                $(this).parent().addClass('focus');
                if ($(this).attr('data-type') == 'pass') {
                    $(this).attr('type', 'password');
                }
                ;
                $(this).val('');
            }
            ;
            FormsOb.removeError($(this));
        });
        $('input[data-value], textarea[data-value]').each(function () {
            if (this.value == '' || this.value == $(this).attr('data-value')) {
                this.value = $(this).attr('data-value');
                if ($(this).hasClass('l') && $(this).parent().find('.form__label').length == 0) {
                    $(this).parent().append('<div class="form__label">' + $(this).attr('data-value') + '</div>');
                }
            }
            if (this.value != $(this).attr('data-value') && this.value != '') {
                $(this).addClass('focus');
                $(this).parent().addClass('focus');
                if ($(this).hasClass('l') && $(this).parent().find('.form__label').length == 0) {
                    $(this).parent().append('<div class="form__label">' + $(this).attr('data-value') + '</div>');
                }
            }

            if (onlyInit == 0) {
                $(this).click(function () {
                    if (this.value == $(this).attr('data-value')) {
                        if ($(this).attr('data-type') == 'pass') {
                            $(this).attr('type', 'password');
                        }
                        ;
                        this.value = '';
                    }
                    ;
                });
                $(this).blur(function () {
                    if (this.value == '') {
                        this.value = $(this).attr('data-value');
                        $(this).removeClass('focus');
                        $(this).parent().removeClass('focus');
                        if ($(this).attr('data-type') == 'pass') {
                            $(this).attr('type', 'text');
                        }
                        ;
                    }
                    ;
                });
            }
        });
        if (onlyInit == 0) {
            $('.form-input__viewpass').click(function (event) {
                if ($(this).hasClass('active')) {
                    $(this).parent().find('input').attr('type', 'password');
                } else {
                    $(this).parent().find('input').attr('type', 'text');
                }
                $(this).toggleClass('active');
            });
        }
        //$('textarea').autogrow({vertical: true, horizontal: false});


        //MASKS//
        //'+7(999) 999 9999'
        //'+38(999) 999 9999'
        //'+375(99)999-99-99'
        //'a{3,1000}' только буквы минимум 3
        //'9{3,1000}' только цифры минимум 3
        $.each($('input.phone'), function (index, val) {
            $(this).attr('type', 'tel');
            $(this).focus(function () {
                $(this).inputmask('+7(999) 999 9999', {
                    clearIncomplete: true, clearMaskOnLostFocus: true,
                    "onincomplete": function () {
                        maskclear($(this));
                    }
                });
                $(this).addClass('focus');
                $(this).parent().addClass('focus');
                $(this).parent().removeClass('err');
                $(this).removeClass('err');
            });
        });
        $('input.phone').focusout(function (event) {
            maskclear($(this));
        });
        $.each($('input.num'), function (index, val) {
            $(this).focus(function () {
                $(this).inputmask('9{1,1000}', {
                    clearIncomplete: true,
                    placeholder: "",
                    clearMaskOnLostFocus: true,
                    "onincomplete": function () {
                        maskclear($(this));
                    }
                });
                $(this).addClass('focus');
                $(this).parent().addClass('focus');
                $(this).parent().removeClass('err');
                $(this).removeClass('err');
            });
        });
        $('input.num').focusout(function (event) {
            maskclear($(this));
        });


        //CHECK
        $.each($('.check'), function (index, val) {
            if ($(this).find('input').prop('checked') == true) {
                $(this).addClass('active');
            }
        });
        if (onlyInit == 0) {
            $('body').off('click', '.check', function (event) {
            });
            $('body').on('click', '.check', function (event) {
                if (!$(this).hasClass('disable')) {
                    var target = $(event.target);
                    if (!target.is("a")) {
                        $(this).toggleClass('active');
                        if ($(this).hasClass('active')) {
                            $(this).find('input').prop('checked', true);
                        } else {
                            $(this).find('input').prop('checked', false);
                        }
                    }
                }
            });
        }

        //OPTION
        $.each($('.option.active'), function (index, val) {
            $(this).find('input').prop('checked', true);
        });
        if (onlyInit == 0) {
            $('.option').click(function (event) {
                if (!$(this).hasClass('disable')) {
                    if ($(this).hasClass('active') && $(this).hasClass('order')) {
                        $(this).toggleClass('orderactive');
                    }
                    $(this).parents('.options').find('.option').removeClass('active');
                    $(this).toggleClass('active');
                    $(this).children('input').prop('checked', true);
                }
            });
        }
        //RATING
        $('.rating.edit .star').hover(function () {
            var block = $(this).parents('.rating');
            block.find('.rating__activeline').css({width: '0%'});
            var ind = $(this).index() + 1;
            var linew = ind / block.find('.star').length * 100;
            setrating(block, linew);
        }, function () {
            var block = $(this).parents('.rating');
            block.find('.star').removeClass('active');
            var ind = block.find('input').val();
            var linew = ind / block.find('.star').length * 100;
            setrating(block, linew);
        });
        $('.rating.edit .star').click(function (event) {
            var block = $(this).parents('.rating');
            var re = $(this).index() + 1;
            block.find('input').val(re);
            var linew = re / block.find('.star').length * 100;
            setrating(block, linew);
        });
        $.each($('.rating'), function (index, val) {
            var ind = $(this).find('input').val();
            var linew = ind / $(this).parent().find('.star').length * 100;
            setrating($(this), linew);
        });

        function setrating(th, val) {
            th.find('.rating__activeline').css({width: val + '%'});
        }

        //QUANTITY
        if (onlyInit == 0) {
            $('.quantity__btn').click(function (event) {
                var n = parseInt($(this).parent().find('.quantity__input').val());
                if ($(this).hasClass('dwn')) {
                    n = n - 1;
                    if (n < 1) {
                        n = 1;
                    }
                } else {
                    n = n + 1;
                }
                $(this).parent().find('.quantity__input').val(n);
                return false;
            });
        }
        //RANGE
        if ($("#range").length > 0) {
            $("#range").slider({
                range: true,
                min: 0,
                max: 5000,
                values: [0, 5000],
                slide: function (event, ui) {
                    $('#rangefrom').val(ui.values[0]);
                    $('#rangeto').val(ui.values[1]);
                    $(this).find('.ui-slider-handle').eq(0).html('<span>' + ui.values[0] + '</span>');
                    $(this).find('.ui-slider-handle').eq(1).html('<span>' + ui.values[1] + '</span>');
                },
                change: function (event, ui) {
                    if (ui.values[0] != $("#range").slider("option", "min") || ui.values[1] != $("#range").slider("option", "max")) {
                        $('#range').addClass('act');
                    } else {
                        $('#range').removeClass('act');
                    }
                }
            });
            $('#rangefrom').val($("#range").slider("values", 0));
            $('#rangeto').val($("#range").slider("values", 1));

            $("#range").find('.ui-slider-handle').eq(0).html('<span>' + $("#range").slider("option", "min") + '</span>');
            $("#range").find('.ui-slider-handle').eq(1).html('<span>' + $("#range").slider("option", "max") + '</span>');

            $("#rangefrom").bind("change", function () {
                if ($(this).val() * 1 > $("#range").slider("option", "max") * 1) {
                    $(this).val($("#range").slider("option", "max"));
                }
                if ($(this).val() * 1 < $("#range").slider("option", "min") * 1) {
                    $(this).val($("#range").slider("option", "min"));
                }
                $("#range").slider("values", 0, $(this).val());
            });
            $("#rangeto").bind("change", function () {
                if ($(this).val() * 1 > $("#range").slider("option", "max") * 1) {
                    $(this).val($("#range").slider("option", "max"));
                }
                if ($(this).val() * 1 < $("#range").slider("option", "min") * 1) {
                    $(this).val($("#range").slider("option", "min"));
                }
                $("#range").slider("values", 1, $(this).val());
            });
            $("#range").find('.ui-slider-handle').eq(0).addClass('left');
            $("#range").find('.ui-slider-handle').eq(1).addClass('right');
        }

        //ADDFILE
        $(document).on('change', '.form-addfile__input', function (e) {
            // if ($(this).val() != '') {
            var $this = $(this),
                $clone = $this.clone(),
                containerId = $this.data('container');
            $this.after($clone).appendTo("#"+containerId);

            var ts = $clone;//$(this);
            // ts.parents('.form-addfile').find('ul.form-addfile-list').html('');


            var fileName = $(this).val().replace("C:\\fakepath\\", "");
            ts.parents('.form-addfile').find('ul.form-addfile-list').append('<li>' + fileName + '<span data-container="'+containerId+'" class="remove-file" data-filename="' + fileName + '"></span></li>');
            $clone.val("");
            /*$('#'+containerId+' input[type=file]').each(function (e) {
                var files = $(this).prop('files');

                for (var i = 0, f; f = files[i]; i++) {
                    ts.parents('.form-addfile').find('ul.form-addfile-list').append('<li>' + files[i].name + '<span data-container="'+containerId+'" class="remove-file" data-filename="' + files[i].name + '"></span></li>');
                }
            });*/

            /*var ts = $(this);
            ts.parents('.form-addfile').find('ul.form-addfile-list').html('');
            $.each(e.target.files, function (index, val) {
                if (ts.parents('.form-addfile').find('ul.form-addfile-list>li:contains("' + e.target.files[index].name + '")').length == 0) {
                    ts.parents('.form-addfile').find('ul.form-addfile-list').append('<li>' + e.target.files[index].name + '<span class="remove-file" data-filename="' + e.target.files[index].name + '"></span></li>');
                }
            });
            $('input[name*=DELETE_FILES]').remove();
            */


        });
        //REMOVEFILE
        if (onlyInit == 0) {
            $(document).on('click', '.remove-file', function (e) {
                // $('.form-addfile__input').after('<input type="hidden" name="DELETE_FILES[]" value="'+$(this).data('filename')+'">');
                var filename = $(this).data('filename');

                var parent = $(this).parent(),
                    containerId = $(this).data('container');
                var lengthinputs = $('#'+containerId+' input[type=file]').length;
                $('#'+containerId+' input[type=file]').each(function (e) {
                    /*var fileOb = $(this), files = $(this).prop('files');

                    for (var i = 0, f; f = files[i]; i++) {
                        if (file_name == files[i].name) {
                            console.log(i, fileOb.prop('files'), files)
                            delete fileOb.prop('files')[i];// = 0;
                            delete files[i];// = 0;
                            console.log(i, fileOb.prop('files'), files)
                        }
                    }

                    console.log(fileOb.prop('files'));*/
                    if($(this).val().indexOf(filename) + 1){
                        var index = $(this).index();
                        if(index+1 == lengthinputs){
                            var elem = $('#'+containerId+' input[type=file]')[index-1];
                            $('.form-addfile-block input[type=file]').val("");
                        }
                        $(this).remove();
                        parent.remove();
                    }
                });

                return false;
            });
        }
    },
    removeError: function (input) {
        input.removeClass('err');
        input.parent().removeClass('err');
        input.parent().find('.form__error').remove();

        if (input.parents('.select-block').length > 0) {
            input.parents('.select-block').parent().removeClass('err');
            input.parents('.select-block').find('.select').removeClass('err').removeClass('active');
            //input.parents('.select-block').find('.select-options').hide();
        }
    },
    searchselectreset: function () {
        $.each($('.select[data-type="search"]'), function (index, val) {
            var block = $(this).parent();
            var select = $(this).parent().find('select');
            if ($(this).find('.select-options__value:visible').length == 1) {
                $(this).addClass('focus');
                $(this).parents('.select-block').find('select').val($('.select-options__value:visible').data('value'));
                $(this).find('.select-title__value').val($('.select-options__value:visible').html());
                $(this).find('.select-title__value').attr('data-value', $('.select-options__value:visible').html());
            } else if (select.val() == '') {
                $(this).removeClass('focus');
                block.find('input.select-title__value').val(select.find('option[selected="selected"]').html());
                block.find('input.select-title__value').attr('data-value', select.find('option[selected="selected"]').html());
            }
        });
    }

}

$(document).ready(function () {
if (window.navigator.userAgent.indexOf("Edge") > -1) {
    $('.form-addfile__info').hide();
}


    var w = $(window).outerWidth();
    var h = $(window).outerHeight();
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
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

    function isIE() {
        ua = navigator.userAgent;
        var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;
        return is_ie;
    }

    if (isIE()) {
        $('body').addClass('ie');
    }
    if (isMobile.any()) {
        $('body').addClass('touch');
    }
    sectors($(this).scrollTop());
    $(window).scroll(function (event) {
        var scr = $(this).scrollTop();
        sectors(scr);
    });

    function sectors(scr) {
        var w = $(window).outerWidth();
        var h = $(window).outerHeight();
        var headerheight = 80;
        if (w < 768) {
            headerheight = 50;
        }
        if (scr > 45) {
            //$('header').addClass('scroll');
        } else {
            $('header').removeClass('scroll');
        }
        if (scr > h) {
            $('#up').fadeIn(300);
        } else {
            $('#up').fadeOut(300);
        }
        $.each($('.sector'), function (index, val) {
            var th = $(this).outerHeight();
            var tot = $(this).offset().top;
            if (scr >= tot && scr <= tot + th - h) {
                $('.sector.scroll').removeClass('scroll');
                $(this).addClass('scroll');
            }
            if ($(this).hasClass('scroll')) {
                if (scr >= tot && scr <= tot + th - h) {
                    if ($(this).hasClass('normalscroll')) {
                        $('body').addClass('scroll');
                    } else {
                        $('body').removeClass('scroll');
                    }
                } else {
                    if ($(this).hasClass('normalscroll')) {
                        $('body').removeClass('scroll');
                    }
                }
            }
            if (scr > tot - h / 1.5 && scr < tot + th) {
                if ($('.dotts').length > 0) {
                    dotts(index, 0);
                }
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
            if (scr > tot - h && scr < tot + th) {
                $(this).addClass('view');
                if ($(this).hasClass('padding')) {
                    var ps = 100 - (tot - scr) / h * 100;
                    var p = headerheight / 100 * ps;
                    if (p >= headerheight) {
                        p = headerheight;
                    }
                    $(this).css({paddingTop: p});
                }
            } else {
                $(this).removeClass('view');
            }
        });
        /*
        $.each($('.lz').not('.load'), function(index, val) {
                var img=$(this).data('image');
            if(scr>tot-h && scr<tot+th){
                $(this).html('<img src="'+img+'" alt="" />');
                $(this).addClass('load');
            }
        });
        */
    }

    function dotts(ind, init) {
        if (init == true) {
            $.each($('.sector'), function (index, val) {
                $('.dotts-list').append('<li></li>');
            });
        }
        $('.dotts-list li').removeClass('active').eq(ind).addClass('active');
    }

    $('body').on('click', '.dotts-list li', function (event) {
        var n = $(this).index() + 1;
        var offset = 0;
        $('body,html').animate({scrollTop: $('.sector-' + n).offset().top + offset}, 800, function () {
        });
    });
//SLIDERS
    if ($('.examples').length > 0) {
        $('.examples-slider').slick({
            //autoplay: true,
            //infinite: false,
            dots: true,
            arrows: true,
            fade: true,
            accessibility: false,
            slidesToShow: 1,
            autoplaySpeed: 3000,
            //asNavFor:'',
            //appendDots:
            //appendArrows:$('.mainslider-arrows .container'),
            nextArrow: '<button type="button" class="slick-next"></button>',
            prevArrow: '<button type="button" class="slick-prev"></button>',
            responsive: [{
                breakpoint: 768,
                settings: {}
            }]
        });
    }
    if ($('.advantages').length > 0) {
        $('.advantages-brands-slider').slick({
            //autoplay: true,
            //infinite: false,
            dots: false,
            arrows: true,
            //fade:true,
            accessibility: false,
            slidesToShow: 4,
            autoplaySpeed: 3000,
            //asNavFor:'',
            //appendDots:
            //appendArrows:$('.mainslider-arrows .container'),
            nextArrow: '<button type="button" class="slick-next"></button>',
            prevArrow: '<button type="button" class="slick-prev"></button>',
            responsive: [{
                breakpoint: 992,
                settings: {slidesToShow: 3}
            }, {
                breakpoint: 630,
                settings: {slidesToShow: 2}
            }, {
                breakpoint: 479,
                settings: {slidesToShow: 1}
            }]
        });
    }


//SLICK FIX
    if ($('.objects-slider').length > 0) {
        var slider = $('.objects-slider');
        slider.slick({
            //autoplay: true,
            //infinite: false,
            infinite: true,
            dots: true,
            arrows: true,
            accessibility: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplaySpeed: 3000,
            speed: 500,
            waitForAnimate: false,
            //asNavFor:'',
            //appendDots:
            appendDots: $('.objects-controls'),
            appendArrows: $('.objects-controls'),
            nextArrow: '<button type="button" class="slick-next"></button>',
            prevArrow: '<button type="button" class="slick-prev"></button>',
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }]
        });
        var sltoshow = slider.get(0).slick.options.slidesToShow;
        var all = slider.find('.slick-slide').length;
        var allactive = slider.find('.slick-slide').not('.slick-cloned').length;
        slider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            if (nextSlide == 0) {
                var ind = all - allactive;
                if (sltoshow == 1) {
                    slider.find('.slick-slide').eq(ind).addClass('active');
                } else {
                    sliderfix(slider, ind);
                }
            }
            if (nextSlide == allactive - 1) {
                if (sltoshow == 1) {
                    slider.find('.slick-slide').eq(0).addClass('active');
                } else {
                    sliderfix(slider, sltoshow - 1);
                }
            }
        });
        slider.on('afterChange', function (event, slick, currentSlide) {
            slider.find('.slick-slide').removeClass('active');
        });

        function sliderfix(slider, v) {
            for (var i = 0; i < sltoshow; i++) {
                var n = v + i;
                slider.find('.slick-slide').eq(n).addClass('active');
            }
        }
    }

    if ($('.newsmodule-slider').length > 0) {
        $('.newsmodule-slider').slick({
            //autoplay: true,
            //infinite: false,
            fade: true,
            dots: false,
            arrows: false,
            accessibility: false,
            slidesToShow: 1,
            autoplaySpeed: 3000,
            //asNavFor:'',
            //appendDots:
            //appendArrows:$('.mainslider-arrows .container'),
            nextArrow: '<button type="button" class="slick-next fa fa-angle-right"></button>',
            prevArrow: '<button type="button" class="slick-prev fa fa-angle-left"></button>',
            responsive: [{
                breakpoint: 768,
                settings: {}
            }]
        });
        //Опция
        $('.newsmodule-slider').get(0).slick.options.slidesToShow

        $('.newsmodule-items-item').click(function (event) {
            $('.newsmodule-items-item').removeClass('active');
            $(this).addClass('active');
            $('.newsmodule-slider').slick('goTo', $(this).index());
        });
        $('.newsmodule-navigator-info span').eq(1).html($('.newsmodule-items-item').length);

        $('.newsmodule-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            $('.newsmodule-navigator-info span').eq(0).html(currentSlide + 1);
        });
        $('.newsmodule-slider').on('afterChange', function (event, slick, currentSlide) {
            $('.newsmodule-navigator-info span').eq(0).html(currentSlide + 1);
        });
        $('.newsmodule-navigator__arrow.fa-angle-left').click(function (event) {
            $('.newsmodule-slider').slick('slickPrev');
        });
        $('.newsmodule-navigator__arrow.fa-angle-right').click(function (event) {
            $('.newsmodule-slider').slick('slickNext');
        });
    }

//Adaptive functions
    $(window).resize(function (event) {
        adaptive_function();
    });

    function adaptive_header() {
        var w = $(window).outerWidth();
        var headerMenu = $('.header-menu');
        var headerContacts = $('.header-phone');
        var headerBtn = $('.header__btn');
        if (w < 767) {
            if (!headerContacts.hasClass('done')) {
                headerContacts.addClass('done').appendTo(headerMenu);
            }
            if (!headerBtn.hasClass('done')) {
                headerBtn.addClass('done').appendTo(headerMenu);
            }
        } else {
            if (headerContacts.hasClass('done')) {
                headerContacts.removeClass('done').appendTo($('.header__column').eq(1));
            }
            if (headerBtn.hasClass('done')) {
                headerBtn.removeClass('done').appendTo($('.header__column').eq(2));
            }
        }
    }

    function adaptive_function() {
        adaptive_header();
    }

    adaptive_function();


    /* YA
    function map(n){
        ymaps.ready(init);
        function init(){
            // Создание карты.
            var myMap = new ymaps.Map("map", {
                // Координаты центра карты.
                // Порядок по умолчанию: «широта, долгота».
                // Чтобы не определять координаты центра карты вручную,
                // воспользуйтесь инструментом Определение координат.
                controls: [],
                center: [43.585525,39.723062],
                // Уровень масштабирования. Допустимые значения:
                // от 0 (весь мир) до 19.
                zoom: 10
            });

            myPlacemar = new ymaps.Placemark([43.585525,39.723062],{
                id:'2'
            },{
                // Опции.
                hasBalloon:false,
                hideIconOnBalloonOpen:false,
                // Необходимо указать данный тип макета.
                iconLayout: 'default#imageWithContent',
                // Своё изображение иконки метки.
                iconImageHref: 'img/icons/map.svg',
                // Размеры метки.
                iconImageSize: [40, 40],
                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-20, -20],
                // Смещение слоя с содержимым относительно слоя с картинкой.
                iconContentOffset: [0,0],
            });
            myMap.geoObjects.add(myPlacemar);

            myMap.behaviors.disable('scrollZoom');
        }
    }
    */
    FormsOb.forms();

    function digi(str) {
        var r = str.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
        return r;
    }

//VALIDATE FORMS
    $(document).on('submit', 'form.form, form.equipment-form-body, form.mainblock-form', function (e) {
        var er = 0;
        var form = $(this);
        var ms = form.data('ms');
        $.each(form.find('.req'), function (index, val) {
            er += formValidate($(this));
        });
        if (er == 0) {
            removeFormError(form);
        } else {
            $('div[id^=wait_comp_]').remove();
            e.preventDefault();
        }
    });

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };

    function formValidate(input) {
        var er = 0;
        var form = input.parents('form');
        if (input.attr('name') == 'email' || input.hasClass('email')) {
            if (!isValidEmailAddress($.trim(input.val())) || input.val() == input.attr('data-value')) {
                er++;
                addError(input);
            } else {
                removeError(input);
            }
        } else if (input.attr('type') == 'checkbox') {
            if (input.prop('checked') == true) {
                input.removeClass('err').parent().removeClass('err');
            } else {
                er++;
                input.addClass('err').parent().addClass('err');
            }
        } else {
            if ($.trim(input.val()) == '' || input.val() == input.attr('data-value') || !/^[a-zа-яёA-ZА-ЯЁ0-9.,!?\- ]+( [a-zа-яёA-ZА-ЯЁ0-9.,!?\- ]+)*$/.test($.trim(input.val())) || $.trim(input.val()).length < 2) {
                er++;
                addError(input);
            } else {
                removeError(input);
            }
        }
        if (input.hasClass('name')) {
            if (!(/^[А-Яа-яa-zA-Z-]+( [А-Яа-яa-zA-Z-]+)$/.test(input.val()))) {
                er++;
                addError(input);
            }
        }
        if (input.hasClass('pass-2')) {
            if (form.find('.pass-1').val() != form.find('.pass-2').val()) {
                addError(input);
            } else {
                removeError(input);
            }
        }
        return er;
    }

    function formLoad() {
        $('.popup').hide();
        $('.popup-message-body').hide();
        $('.popup-message .popup-body').append('<div class="popup-loading"><div class="popup-loading__title">Идет загрузка...</div><div class="popup-loading__icon"></div></div>');
        $('.popup-message').addClass('active').fadeIn(300);
    }

    function showMessageByClass(ms) {
        $('.popup').hide();
        $('.popup-message.' + ms).addClass('active').fadeIn(300);
    }

    function showMessage(html) {
        $('.popup-loading').remove();
        $('.popup-message-body').show().html(html);
    }

    function clearForm(form) {
        $.each(form.find('.input'), function (index, val) {
            $(this).removeClass('focus').val($(this).data('value'));
            $(this).parent().removeClass('focus');
            if ($(this).hasClass('phone')) {
                maskclear($(this));
            }
        });
    }

    function addError(input) {
        input.addClass('err');
        input.parent().addClass('err');
        input.parent().find('.form__error').remove();
        if (input.hasClass('email')) {
            var error = '';
            if (input.val() == '' || input.val() == input.attr('data-value')) {
                error = input.data('error');
            } else {
                error = input.data('error-2');
            }
            if (error != null) {
                input.parent().append('<div class="form__error">' + error + '</div>');
            }
        } else {
            if (input.data('error') != null && input.parent().find('.form__error').length == 0) {
                input.parent().append('<div class="form__error">' + input.data('error') + '</div>');
            }
        }
        if (input.parents('.select-block').length > 0) {
            input.parents('.select-block').parent().addClass('err');
            input.parents('.select-block').find('.select').addClass('err');
        }
    }

    function addErrorByName(form, input__name, error_text) {
        var input = form.find('[name="' + input__name + '"]');
        input.attr('data-error', error_text);
        addError(input);
    }

    function addFormError(form, error_text) {
        form.find('.form__generalerror').show().html(error_text);
    }

    function removeFormError(form) {
        form.find('.form__generalerror').hide().html('');
    }

    function removeError(input) {
        input.removeClass('err');
        input.parent().removeClass('err');
        input.parent().find('.form__error').remove();

        if (input.parents('.select-block').length > 0) {
            input.parents('.select-block').parent().removeClass('err');
            input.parents('.select-block').find('.select').removeClass('err').removeClass('active');
            //input.parents('.select-block').find('.select-options').hide();
        }
    }

    function removeFormErrors(form) {
        form.find('.err').removeClass('err');
        form.find('.form__error').remove();
    }

    function maskclear(n) {
        if (n.val() == "") {
            n.inputmask('remove');
            n.val(n.attr('data-value'));
            n.removeClass('focus');
            n.parent().removeClass('focus');
        }
    }

    function searchselectreset() {
        $.each($('.select[data-type="search"]'), function (index, val) {
            var block = $(this).parent();
            var select = $(this).parent().find('select');
            if ($(this).find('.select-options__value:visible').length == 1) {
                $(this).addClass('focus');
                $(this).parents('.select-block').find('select').val($('.select-options__value:visible').data('value'));
                $(this).find('.select-title__value').val($('.select-options__value:visible').html());
                $(this).find('.select-title__value').attr('data-value', $('.select-options__value:visible').html());
            } else if (select.val() == '') {
                $(this).removeClass('focus');
                block.find('input.select-title__value').val(select.find('option[selected="selected"]').html());
                block.find('input.select-title__value').attr('data-value', select.find('option[selected="selected"]').html());
            }
        });
    }

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
    if (isMobile.any()) {
    }

    if (location.hash) {
        var hsh = location.hash.replace('#', '');
        if ($('.popup-' + hsh).length > 0) {
            popupOpen(hsh);
        } else if ($('div.' + hsh).length > 0) {
            $('body,html').animate({scrollTop: $('div.' + hsh).offset().top,}, 500, function () {
            });
        }
    }
    $('.wrapper').addClass('loaded');

    var act = "click";
    if (isMobile.iOS()) {
        var act = "touchstart";
    }

    $('.header-menu__icon').click(function (event) {
        $(this).toggleClass('active');
        $('.header-menu').toggleClass('active');
        $('body').toggleClass('lock');
    });

//ZOOM
   /* if ($('.gallery').length > 0) {
        baguetteBox.run('.gallery', {
            // Custom options
        });
    }*/
//FANCYBOX
    $('.fancybox-preview').fancybox({
        arrows: false,
        infobar: false,
        buttons: [
            // "zoom",
            //"share",
            // "slideShow",
            //"fullScreen",
            //"download",
            // "thumbs",
            "close"
        ],
    });

//POPUP
    $('body').on('click', '.pl', function (event) {
        var pl = $(this).attr('href').replace('#', '');
        popupOpen(pl);
        return false;
    });

    function popupOpen(pl) {
        var v = $('a[href="#' + pl + '"]').data('vid');
        $('.popup').removeClass('active').hide();
        // $('.popup-' + pl).find('form')[0].reset(); // reset form (only text fields)
        if (!isMobile.any()) {
            $('body').css({paddingRight: $(window).outerWidth() - $('.wrapper').outerWidth()}).addClass('lock');
            $('header,.pdb').css({paddingRight: $(window).outerWidth() - $('.wrapper').outerWidth()});
            setTimeout(function (event) {
                popupscroll();
            }, 300);
        } else {
            $('body').addClass('lock');
        }
        if (pl == 'info') {
            var sectId = $('.examples-slide.slick-active').data('id');
            $('#info_popup_' + sectId).fadeIn(300).delay(300).addClass('active');
            $('#info_popup_' + sectId).find('.popup-content-scroll').removeClass('noscroll').getNiceScroll().resize();
            popupscroll();
            return;
        }
        history.pushState('', '', '#' + pl);
        if (v != '') {
            $('.popup-' + pl + ' .popup-video__value').html('<iframe src="https://www.youtube.com/embed/' + v + '?autoplay=1"  allow="autoplay; encrypted-media" allowfullscreen></iframe>');
        }
        $('.popup-' + pl).fadeIn(300).delay(300).addClass('active');
    }

    function openPopupById(popup_id) {
        $('#' + popup_id).fadeIn(300).delay(300).addClass('active');
    }

    function popupClose() {
        $('.popup').removeClass('active').fadeOut(300);
        if (!$('.header-menu').hasClass('active')) {
            if (!isMobile.any()) {
                $('body').css({paddingRight: 0}).removeClass('lock');
                $('header,.pdb').css({paddingRight: 0});
            } else {
                $('body').removeClass('lock');
            }
        }
        $('.popup-video__value').html('');

        history.pushState('', '', window.location.href.split('#')[0]);
    }

    $(document).on('click', '.popup', function (e) {
        if (!$(e.target).is(".popup>.popup-table>.cell *") || $(e.target).is(".popup-close") || $(e.target).is(".popup__close")) {
            popupClose();
            e.preventDefault();
            // return false;
        }
    });

    $(window).scroll(function () {
        var h = $(this).outerHeight();
        var w = $(this).outerWidth();
        var scr = $(this).scrollTop();
        if (scr > $('.equipment-body').offset().top - $('header').outerHeight()) {
            $('.flyform-bodybutton').addClass('active');
        } else {
            $('.flyform-bodybutton').removeClass('active');
        }
    });


    $('.goto').click(function () {
        var el = $(this).attr('href').replace('#', '');
        //var top=$('header-top').outerHeight();
        if (w < 768) {
            top = 0;
        }
        var offset = $('header').outerHeight();
        $('body,html').animate({scrollTop: $('.' + el).offset().top - offset}, 500, function () {
        });

        if ($('.header-menu').hasClass('active')) {
            $('.header-menu,.header-menu__icon').removeClass('active');
            $('body').removeClass('lock');
        }
        return false;
    });

    function ibg() {
        $.each($('.ibg'), function (index, val) {
            if ($(this).find('img').length > 0) {
                $(this).css('background-image', 'url("' + $(this).find('img').attr('src') + '")');
            }
        });
    }

    ibg();

//Клик вне области
    $(document).on('click touchstart', function (e) {
        if (!$(e.target).is(".select *")) {
            $('.select').removeClass('active');
        }
        ;
    });

//UP
    $(window).scroll(function () {
        var w = $(window).width();
        if ($(window).scrollTop() > 50) {
            $('#up').fadeIn(300);
        } else {
            $('#up').fadeOut(300);
        }
    });
    $('#up').click(function (event) {
        $('body,html').animate({scrollTop: 0}, 300);
    });

    $('body').on('click', '.tab__navitem', function (event) {
        var eq = $(this).index();
        if ($(this).hasClass('parent')) {
            var eq = $(this).parent().index();
        }
        if (!$(this).hasClass('active')) {
            $(this).closest('.tabs').find('.tab__navitem').removeClass('active');
            $(this).addClass('active');
            $(this).closest('.tabs').find('.tab__item').removeClass('active').eq(eq).addClass('active');
            if ($(this).closest('.tabs').find('.slick-slider').length > 0) {
                $(this).closest('.tabs').find('.slick-slider').slick('setPosition');
            }
        }
    });
    $.each($('.spoller.active'), function (index, val) {
        $(this).next().show();
    });
    $('body').on('click', '.spoller', function (event) {
        if ($(this).hasClass('mob') && !isMobile.any()) {
            return false;
        }
        if ($(this).hasClass('closeall') && !$(this).hasClass('active')) {
            $.each($(this).closest('.spollers').find('.spoller'), function (index, val) {
                $(this).removeClass('active');
                $(this).next().slideUp(300);
            });
        }
        $(this).toggleClass('active').next().slideToggle(300, function (index, val) {
            if ($(this).parent().find('.slick-slider').length > 0) {
                $(this).parent().find('.slick-slider').slick('setPosition');
            }
        });
    });


    function scrolloptions() {
        var scs = 100;
        var mss = 50;
        var bns = false;
        if (isMobile.any()) {
            scs = 10;
            mss = 1;
            bns = true;
        }
        var opt = {
            cursorcolor: "#a5a5a5",
            cursorwidth: "7px",
            background: "#efefef",
            autohidemode: false,
            cursoropacitymax: 0.4,
            bouncescroll: bns,
            cursorborderradius: "3px",
            scrollspeed: scs,
            mousescrollstep: mss,
            directionlockdeadzone: 0,
            cursorborder: "0px solid #fff",
        };
        return opt;
    }

    function popupscroll() {
        $('.popup-content-scroll').niceScroll('.popup-content-scroll-list', scrolloptions());
    }

    /*
    function scrollwhouse(){
            var scs=100;
            var mss=50;
            var bns=false;
        if(isMobile.any()){
            scs=10;
            mss=1;
            bns=true;
        }
        var opt={
            cursorcolor:"#afafaf",
            cursorwidth: "5px",
            background: "",
            autohidemode:false,
            railalign: 'left',
            cursoropacitymax: 1,
            bouncescroll:bns,
            cursorborderradius: "0px",
            scrollspeed:scs,
            mousescrollstep:mss,
            directionlockdeadzone:0,
            cursorborder: "0px solid #fff",
        };
        return opt;
    }
    $('.whouse-content-body').niceScroll('.whouse-content-scroll',scrollwhouse());
    $('.whouse-content-body').scroll(function(event) {
            var s=$(this).scrollTop();
            var r=Math.abs($(this).outerHeight()-$('.whouse-content-scroll').outerHeight());
            var p=s/r*100;
        $('.whouse-content__shadow').css({opacity:1-1/100*p});
    });
    */


    if ($('.t,.tip').length > 0) {
        tip();
    }

    function tip() {
        $('.t,.tip').webuiPopover({
            placement: 'top',
            trigger: 'hover',
            backdrop: false,
            //selector:true,
            animation: 'fade',
            dismissible: true,
            padding: false,
            //hideEmpty: true
            onShow: function ($element) {
            },
            onHide: function ($element) {
            },
        }).on('show.webui.popover hide.webui.popover', function (e) {
            $(this).toggleClass('active');
        });
    }
});

$(document).on('keypress', 'input[name="PHONE"]', function (evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
});


