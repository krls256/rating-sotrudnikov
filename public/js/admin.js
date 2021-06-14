$(document).ready(function () {
    if ($('*').is('#city, #create__file, #type, #position, #company, #filter_moderation, #moderation, #select-castom')) {
        $('#type, #city, #create__file, #position, #company, #filter_moderation, #moderation, #select-castom').styler({
            selectSearch: true,
        });
    }

    //функция уведомлений в окне авторизации
    function card__log(text, type) {
        let log = $('.login__error');

        if (type == 'ok') {
            log.addClass('success'); //если успешно авторизоаван показываем зеленую карточку
        }
        log.html(text).css({display: 'block'}); //Добавляем текст сообщения и делаем видимым

        //Скрываем блок через 5 секунд
        setTimeout(function () {
            log.text('').css({display: 'none'}).removeClass('success');
        }, 5000);
    }

    function checkForm (form, selector = '[data-check="true"]') {
        var pass = true;
        form.find(selector).each(function () {
            if ($(this).val().length == '') {
                pass = false;
            }
        });
        return pass
    }

    $('[name="banner"]').on('change', function () {
        var $input = $(this);
        var fd = new FormData;

        fd.append('file', $input.prop('files')[0]);

        $.ajax({
            url: 'function?func=edit_banner',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                switch (data) {
                    case 'file_size':
                        card__log('Изображение должно быть 300х400.');
                        break;
                    case 'file_error':
                        card__log('Что-то пошло не так!');
                        break;
                    default:
                        card__log('Вы успешно обновили баннер.', 'ok');
                }
            }
        });
    });

    var files; //Записываем файл

    $('.create input[type=file], .articals[type="file"]').on('change', function () {
        files = this.files;
    });

    // Изменение компании
    $('#edit-company').on('submit', function (e) {
        e.preventDefault();
        var elem = $(this);
        var pass = checkForm(elem,'[data-check="true"]');

        if (pass) {
            var dateInput = $('input[name="data"]');
            var date = dateInput.val().split('.').reverse().join('-');
            var dateObj = new Date(date);
            dateInput.val(dateObj.getTime().toString().slice(0, -3));

            elem.unbind('submit').submit()
        } else {
            card__log('Заполните все обязательные поля', 'validation_error');
        }
    })

    // Создание компании



    // Отключить отзыв
    $('.review-bottom .submit--red, .comment-bottom .submit--red').on('click', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const companyId = urlParams.get('id');
        let id = $(this).data('id'),
            key = $(this).data('key'),
            type = $(this).data('type');

        if (!$(this).closest('.block').find('*').is('.warning')) {
            $(this).closest('.block')
                .append(
                    `<div class="warning comment_wer">
            <span>Вы уверены? После удаления заявку нельзя восстановить.</span>
            <form action="/admin/review/delete.php" method="POST">
            <input type="hidden" name="id" value="${id}">
            <input type="hidden" name="company_id" value="${companyId}">
            <button data-id="'+id+'" data-key="'+key+'" data-type="'+type+'">Да</button data-id="'+id+'" data-key="'+key+'" data-type="'+type+'"></form>
            <div>Нет</div>
          </div>`);
        }
    });

    $(document).on('click', '.warning > div:last-child', function () {
        $(this).closest('.warning').remove();
    });


    /**
     * Удаление отзывов сотрудников
     */
    $('.hr-rev-dal').on('click', function () {
        var $this = $(this);
        var id = $this.data('id');

        if (id.length == '')
            return card__log('Что-то пошло не так.');

        $.post('function?func=review-hr-del', {id: id})
            .then(function (e) {
                card__log('Отзыв успешно удален.', 'ok');
                $this.closest('form').remove();
            });
    });

    $('.create_review_name').on('submit', function (e) {
        console.log('.create_review_name submitted');
        e.stopPropagation(); // Остановка происходящего
        e.preventDefault();  // Полная остановка происходящего
        let elem = $(this),
            status = true;

        //Проверяем поля на пустоту
        elem.find('input[type="text"], [name="text"]').each(function () {
            if ($(this).val().length == '') {
                status = false;
            }
        });
        $(this).unbind('submit').submit();
        return;

        if (status == true) {
            $.ajax({
                type: 'POST',
                url: 'review/store.php',
                data: elem.serialize(),
                cache: false,
                success: function (res) {
                    switch (res) {
                        case 'text_error':
                            card__log('Заполните все поля.');
                            break;
                        case 'sql_error':
                            card__log('Что-то пошло не так...');
                            break;
                        case 'ok':
                            card__log('Статья успешно добавлена.', 'ok');
                            elem.find('input[type="text"], .jq-file__name').val('');
                            elem.find('textarea').val('');
                            break;
                    }
                }
            });
        } else {
            card__log('Заполните все поля.');
        }

    });

    $('.company-edit__del').on('click', function () {
        let id = $(this).data('id'),
            key = $(this).data('key');

        $(this).closest('.block')
            .append('<div class="warning company_war"><span>Вы уверены? После удаления компанию нельзя восстановить.</span><div data-id="' + id + '" data-key="' + key + '">Да</div><div>Нет</div></div>');

        return false;
    });

    $(document).on('click', '.company_war > div:nth-child(2)', function () {
        let id = $(this).data('id'),
            block = $(this).closest('.block'),
            key = $(this).data('key');

        $.post('function?func=del_company', {id: id, key: key}, function (res) {
            if (res == 'ok') {
                block.remove();
            } else {
                if (!block.is('.login__error')) {
                    block.prepend('<div class="login__error">' + res + '</div>');
                } else {
                    block.find('.login__error').text(res);
                }
            }
        });
    });

    $('.save-review').on('click', function (e) {
        console.log('.save-review submitted');
        e.stopPropagation(); // Остановка происходящего
        e.preventDefault();  // Полная остановка происходящего

        var el = $(this).closest('form'),
            test = true,
            type = $(this).data('method');

        el.find('input[type="text"], textarea, select').each(function () {
            if ($(this).val() == '') {
                test = false;
            }
        });

        if (test) {
            $.post('function?func=review_edit', el.serialize() + "&method=" + type, function (res) {
                if (res == 'ok') {
                    window.location = 'moderation?type=user';
                } else {
                    card__log(res);
                }
            });
        } else {
            card__log('Заполните все поля.');
        }

    });

    //Обработка настроек сайта
    $('.edit-index').on('submit', function (e) {
        e.preventDefault();  // Полная остановка происходящего
        var url = '/admin/settings/api/update.php'
        var is = $(this)[0];
        fetch(url, {
            method: 'POST',
            body: new FormData(is)
        })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    card__log('Настройки успешно обновлены', 'ok');
                } else {
                    var content = data.message.map(mes => '<div>' + mes + '</div>')
                    card__log(content, 'error')
                }
            })
            .catch(console.error)

    });

    $('#filter_moderation').on('change', function (e) {
        window.location = 'moderation?id=' + $(this).val();
    });

    $('.advice').on('submit', function () {
        var chek = true;

        if ($(this).find('[data-check="true"]').val() == '') {
            chek = false;
        }

        if (chek === true) {
            $.post('function?func=advice', $(this).serialize(), function (req) {
                if (req == 'ok') {
                    card__log('Советы обновлены.', 'ok');
                }
            });
        } else {
            card__log('Должно быть как минимум 2 совета.');
        }
    });
});


const formTableHelper = () => {
    const form = document.querySelector('.review-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const selectors = form.querySelectorAll('select');
            selectors.forEach(select => {
                if(select.value === '') {
                    select.name = '';
                }
            })
            form.submit();
        })
    }
}

formTableHelper();

const toggleTableForm = () => {
    const tableHeaders = document.querySelectorAll('[data-type="table-header"]');
    const tableForms = document.querySelectorAll('[data-type="table-form"]');
    const tableEntries = [];
    tableHeaders.forEach((item, index) => {
        tableEntries.push([item, tableForms[index]]);
    })

    tableForms.forEach(form => {
        const wrapper = form.querySelector('[data-type="form-wrapper"]');
        const line = form.querySelector('td');
        line.style.padding = '0 .75rem';
        wrapper.style.maxHeight = '0';
    })

    tableEntries.forEach(([header, form]) => {
        const wrapper = form.querySelector('[data-type="form-wrapper"]');
        const line = form.querySelector('td');
        const toggleControl = header.querySelector('[data-action="toggle-control"]');
        toggleControl.addEventListener('click', () => {
            const maxHeight = `${wrapper.scrollHeight}px`;
            if(wrapper.style.maxHeight === maxHeight) {
                wrapper.style.maxHeight = '0';
                line.style.padding = '0px 0.75rem';
            } else {
                wrapper.style.maxHeight = maxHeight
                line.style.padding = '0.75rem';
            }
        })
    })
}

toggleTableForm();

const resizeTableForm = (wrapper) => {
    const height = `${wrapper.scrollHeight}px`;
    wrapper.style.maxHeight = height;
}


const tableResponseHandler = (wrapper, success, failure, warning) => ({status, message}) => {
    const list =
        `<ul style="list-style-type: none;" class="m-0">${message.map(m => `<li>${m}</li>`)}</ul>`;
    switch (status) {
        case 'success': {
            success.classList.remove('d-none');
            success.innerHTML = list;
        } break;
        case 'failure': {
            failure.classList.remove('d-none');
            failure.innerHTML = list;
        } break;
        default: {
            warning.classList.remove('d-none');
            warning.innerHTML = 'Не могу найти соответствующее серверное событие';
        }
    }
    wrapper.classList.remove('table-form__wrapper-loading');
    resizeTableForm(wrapper);
}

const ajaxUpdateTable = () => {
    const wrappers = document.querySelectorAll('[data-type="form-wrapper"]');
    wrappers.forEach(wrapper => {
        const form = wrapper.querySelector('form');
        form.addEventListener('submit', e => {
            e.preventDefault();
            const url = form.getAttribute('action');
            wrapper.classList.add('table-form__wrapper-loading')
            fetch(url, {
                method: 'POST',
                body: new FormData(form)
            })
                .then(d => d.json())
                .then(tableResponseHandler(
                    wrapper,
                    form.querySelector('.alert-success'),
                    form.querySelector('.alert-danger'),
                    form.querySelector('.alert-warning')
                ))
                .catch(console.error);
        })
    })
}



ajaxUpdateTable();

const closeAlerts = () => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.addEventListener('click', (e) => {
                alert.textContent = '';
                alert.classList.add('d-none');
            })
        })
}

closeAlerts();

const paginationLinks = () => {
    const pagination = document.querySelector('.table__pagination');
    if(pagination) {
        const links = pagination.querySelectorAll('a.page-link');
        links.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const page = link.dataset.page
                const urlSearchParams = new URLSearchParams(window.location.search);
                const urlObj = Object.fromEntries(urlSearchParams.entries())
                urlObj.page = page;
                const newUrl = '?' + Object.entries(urlObj).map(([key, value]) => `${key}=${value}`).join('&');
                window.location = newUrl;
            })
        })
    }
}

paginationLinks();

const reviewsJsonFileConverter = () => {
    const input = document.querySelector('#reviews_file');
    const button = document.querySelector('#reviews_file_button');
    const form = document.querySelector('#reviews_file_form');
    let reviews;
    if(input && button && form) {

        input.addEventListener('change', (e) => {
            const reader = new FileReader();
            reader.readAsText(e.target.files[0]);
            reader.onload = (file) => {
                reviews = JSON.parse(file.target.result);

                button.removeAttribute('disabled')
            }
        })

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const fd = new FormData(form);
            const url = form.getAttribute('action');
            fd.append('reviews', JSON.stringify(reviews))
            fetch(url, {
                method: 'POST',
                body: fd
            })
                .then(r => r.json())
                .then(({status, message}) => {
                    const list = message.map(m => `<div>${m}</div>`)
                    switch (status) {
                        case 'success': {
                            const s = document.querySelector('#reviews_file_success_tracker')
                            s.classList.remove('d-none');
                            s.innerHTML = list;
                        } break;
                        case 'failure': {
                            const f = document.querySelector('#reviews_file_failure_tracker')
                            f.classList.remove('d-none');
                            f.innerHTML = list;
                        } break;
                    }
                })
                .catch(console.error)

        })
    }
}

reviewsJsonFileConverter();
