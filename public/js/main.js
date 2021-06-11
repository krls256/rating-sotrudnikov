/**
 * Открываем окно
 *
 * @param {*} e
 */
function modal_open(e) {
    var t = $(".modal");
    t.css({
        display: "block"
    }),
        750 < $(window).width() ? t.children(e).css({
            display: "block"
        }).stop().animate({
            top: 100,
            opacity: 1
        }, 200) : t.children(e).css({
            display: "block"
        }).stop().animate({
            top: 0,
            opacity: 1
        }, 200)
}

/**
 * Обновляем выпадающие списки
 */
function refresh() {
    var e = $(".jq-selectbox ul li:first");
    $(".jq-selectbox__select-text").text(e.text()),
        $(".jq-selectbox ul li").removeClass(),
        e.addClass("selected sel"),
        $(".jq-selectbox select").val()
}

/**
 * Стираем данные из форм
 */
function modal_clear() {
    var e = $(".modal");

    refresh();
    e.find('input:not([type="hidden"]), textarea').val("");
    e.find(".active").removeClass("active");
    e.find(".g-recaptcha").each(function () {
        grecaptcha.reset($(this).data("wi"));
    }),
        e.find(".thank").remove();
    e.find(".modal__error").css({
        display: "none"
    }).text();
}

/**
 * Закрываем окно
 *
 * @param {*} e
 */
function modal_close(e) {
    var t, a = $(".modal");
    t = 750 < $(window).width() ? 50 : 0,
        a.children(e).stop().animate({
            top: t,
            opacity: "0"
        }, 200, function () {
            a.css({
                display: "none"
            }),
                a.find(".modal__error").css({
                    display: "none"
                }).removeClass("success"),
                $(this).css({
                    display: "none"
                }),
                modal_clear()
        })
}

/**
 * Вывод ошибок в окне
 *
 * @param {*} e
 * @param {*} t
 */
function modal_error(e, t) {
    var a = $(".modal__error");
    a.removeClass("success"),
    "success" === t && a.addClass("success"),
        a.css({
            display: "block"
        }),
        a.html(e)
}

function reactOnFormResponse(overlaySelector) {
    return function (strResponse) {
        var response = JSON.parse(strResponse);
        var status = response.status;
        switch (status) {
            case "success": {
                var messages = response.messages;
                modal_error(
                    messages.map(function (message) {
                        return "<div>" + message + "</div>";
                    }), 'success')
            }
                break;
            case "failure": {
                var errors = response.errors;
                modal_error(
                    errors.map(function (message) {
                        return "<div>" + message + "</div>";
                    }), 'failure');
            }
                break;
        }
        $(overlaySelector).addClass('d-none');
    }
}

function sendRecaptcha(callback, overlaySelector) {
    $(overlaySelector).removeClass('d-none');
    if (grecaptcha !== undefined) {
        grecaptcha.ready(function () {
            grecaptcha.execute('6LdPIwwbAAAAAE0Ra3cw2Xowe9NgPwKqdvqRvGxV', {action: 'submit'})
                .then(callback) // takes token as an argument
                .catch(function () {
                    modal_error('Что-то пошло не так попробуйте отправить форму чуть позже.', 'error');
                    $(overlaySelector).addClass('d-none');
                })
        });
    } else {
        $(overlaySelector).addClass('d-none');
        modal_error('Что-то пошло не так попробуйте отправить форму чуть позже.', 'error');
    }
}

$(document).ready(function (e, t) {
    var t;
    $(".modal__type").styler();

    // Перехватываем события ресайза для изменения стилей
    $(window).on("load resize", function () {
        var breakPoint = 850;
        breakPoint < $(this).width() && ($(".home__search-item").find("*").removeAttr("style"), $("header .header__menu").removeAttr("style"), $("header .button-menu").removeClass("active"))
    });

    $("header .button-menu").on("click", function () {
        console.log($(this))
        $(this).hasClass("active") ? ($(this).removeClass("active"), $("header .header__menu").stop().animate({
            left: "100%"
        }, 300, function () {
            $(this).removeAttr("style")
        })) : ($(this).addClass("active"), $("header .header__menu").stop().animate({
            left: "0"
        }, 300))
    })

    $(".review_modal, .comment_modal, .request_modal").on("click", function () {
        var e = $(this).data();
        switch (e.type) {
            case "review":
                elem = $("#review");
                break;
            case "comment":
                elem = $("#comment");
                elem.find('[name="type"]').val(e.val);
                elem.find('[name="review_id"]').val(e.id);
                break;
            case "request":
                elem = $("#request");
                elem.find('[name="type"]').val(e.val);
                elem.find('[name="company_id"]').val(e.id);
                break;
        }


        elem.find('[name="key"]').val(e.key);

        modal_open(".window__" + e.type);
    });

    $(".modal__window .close").on("click", function () {
        modal_close($(this).closest(".modal__window"))
    });

    $(".modal").on("click", function (e) {
        var t = $(".modal__window");
        t.is(e.target) || 0 !== t.has(e.target).length || modal_close($(this).closest(".modal__window"))
    });

    $(".modal__like span").on("click", function () {
        var e = $(this).parent();
        e.find("span").hasClass("active") && e.find("span").removeClass("active"),
            $(this).toggleClass("active")
    });

    // Новый комментарий
    $("#comment").on("submit", function (e) {
        e.preventDefault();
        var $this = $(this);
        var pass = true;
        var error = '';
        $this.find('[data-check="true"]').each(function () {
            if ($(this).val().length === 0) {
                pass = false;
                if (error.length === 0)
                    error += "<div>Пожалуйста заполните все обязательные поля.</div>";
            }
        });
        if (pass) {
            sendRecaptcha(function (recaptcha_token) {
                var data = {recaptcha_token: recaptcha_token};
                var formData = new FormData($this[0]);
                for (var entry of formData.entries()) {
                    var key = entry[0];
                    var value = entry[1];
                    data[key] = value;
                }
                $.post('/api/new-comment.php', data, reactOnFormResponse('[data-overlay="comment"]'))
            }, '[data-overlay="comment"]')
        } else {
            modal_error(error, 'error');
        }
    });
    var validMask = false;
    var maskOptions = {
        onChange: function(val) {validMask = val.length === 17},
    }
    $('input[name="user_phone"]').mask("+7(000) 000-00-00", maskOptions);
    //Форама отправки заявок
    $('#request').on("submit", function (e) {
        e.preventDefault();
        var $this = $(this);
        var pass = true;
        var errors = '';
        $this.find('[data-check="true"]').each(function () {
            if ($(this).val().length === 0) {
                pass = false;
                if (errors.length === 0) {
                    errors += "<div>Пожалуйста заполните все обязательные поля.</div>";
                }
            }
        });
        if(validMask === false) {
            pass = false;
            errors += "<div>Некорректный номер</div>"
        }

        if (pass) {
            sendRecaptcha(function (recaptcha_token) {
                var data = {recaptcha_token: recaptcha_token};
                var formData = new FormData($this[0]);
                for (var entry of formData.entries()) {
                    var key = entry[0];
                    var value = entry[1];
                    data[key] = value;
                }
                $.post('/api/new-user-request.php', data, reactOnFormResponse('[data-overlay="request"]'))

            }, '[data-overlay="request"]')
        }
        else {
            modal_error(errors, 'error');
        }
    })

    $("#review").on("submit", function (e) {
        e.preventDefault();

        var $this = $(this);
        var like = $this.find('.modal__like span.active').data('like');
        var pass = true
        var error = '';
        $this.find('[data-check="true"]').each(function () {
            if ($(this).val().length === 0) {
                pass = false;
                if (error.length === 0) {
                    error += "<div>Пожалуйста заполните все обязательные поля.</div>";
                }
            }
        });
        if (like === undefined) {
            pass = false;
            error += "<div>Выберете понравилась ли вам компания.</div>";
        }

        if (pass) {
            sendRecaptcha(function (recaptcha_token) {
                var data = {recaptcha_token: recaptcha_token, is_positive: like};
                var formData = new FormData($this[0]);
                for (var entry of formData.entries()) {
                    var key = entry[0];
                    var value = entry[1];
                    data[key] = value;
                }
                $.post('/api/new-review.php', data, reactOnFormResponse('[data-overlay="review"]'))

            }, '[data-overlay="review"]')
        } else {
            modal_error(error, 'error');
        }
    });

    $(" .home__search-item span, .home__search-item i").on("click", function () {
        $(".home__search").trigger("focus")
    });

    $(".home__search").on("focus", function () {
        $(this).closest(".home__item").addClass("active"),
            950 < $(window).width() ? $(this).parent().stop().animate({
                width: "100%"
            }, 300) : ($(this).stop().animate({
                width: "100%",
                padding: "6px 7px"
            }, 300), setTimeout(function () {
                $(".home__search-item").stop().animate({
                    width: "100%"
                }, 200),
                    $(".home__search-item span").fadeIn("fast", "swing")
            }, 100))
    }).on("input", function () {
        var e = $(this).val();
        clearTimeout(t),
            "" == $(this).val() ? ($(this).siblings("span").css({
                display: "block"
            }), $('input[name="home__search"]').removeAttr("style"), $(".search").stop().animate({
                top: 50,
                opacity: 0
            }, 300, function () {
                $(this).css({
                    display: "none"
                })
            })) : ($(this).siblings("span").css({
                display: "none"
            }), t = setTimeout(function () {
                console.log(e)
                $.get('/api/search.php', {search: e}, function (responseStr) {
                    var response = JSON.parse(responseStr);
                    var status = response.status;
                    if(status === 'success') {
                        var data = response.data;
                        if(data.length === 0) {
                            $('.search').html('<div class="search__error">По вашему запросу ничего не найдено</div>');
                        } else {
                            var content = data.map(function (company) {
                                var url = company.url;
                                var name = company.name;
                                var description = company.description;
                                var sIndex = description.indexOf('</')
                                var eIndex = description.indexOf('>', sIndex);
                                var elementPrefix = description.slice(sIndex, eIndex).replace('/', '');
                                var elementPrefixIndex = description.indexOf(elementPrefix)
                                var textStartIndex = description.indexOf('>', elementPrefixIndex);

                                description = description.slice(textStartIndex + 1, sIndex)
                                description = description.slice(0, 100) + '...';

                                return (
                                    '<a href="/otzyvy-sotrudnikov-' + url + '" class="result-search">' +
                                    '<div class="result-search__item">' +
                                    '<h4>' + name +'</h4>' +
                                    '<span>' + description + '</span>' +
                                    '</div>' +
                                    '</a>'
                                )
                            })
                            $('.search')
                                .html(content)
                                .css({ display: 'block'})
                                .animate({
                                    top: '30px', opacity: '1'
                                });
                        }
                    }
                })
            }, 300))
    });

    $(document).on("click", function (e) {
        var t = $(".home__search-item");
        t.is(e.target) || 0 !== t.has(e.target).length || "" == t.find("input").val() && (950 < $(window).width() ? t.stop().animate({
            width: "200px"
        }, 300, function () {
            $(this).closest(".home__item").removeClass("active"),
                $(this).removeAttr("style")
        }) : (t.find("input").stop().animate({
            width: "0",
            padding: "6px 0"
        }, 300, function () {
            $(this).closest(".home__item").removeClass("active"),
                $(this).removeAttr("style"),
                $(".home__search-item span").removeAttr("style")
        }), $(".home__search-item span").fadeOut(250, "swing")))
    });

    $(window).on('scroll load', function () {
        var bannerBlock = $('.banner-block'),
            navBlcok = $('.content__item-right > div:nth-child(1)'),
            nav = (navBlcok.offset().top + navBlcok.height() + 5),
            scrollT = $(this).scrollTop();

        if (nav < scrollT) {
            bannerBlock.css({
                position: 'fixed',
                top: 15
            });
        } else {
            bannerBlock.removeAttr('style');
        }

    });
});
