<?php

use app\Http\Controllers\Rest\CompanyRestController;
use app\Repositories\Rest\CompanyRestRepository;
use helperClasses\Request;

include "function.php"; //Управляющий файл

$request = new Request();
$repository = new CompanyRestRepository();
$controller = new CompanyRestController($repository);
$controllerData = $controller->edit($request);
$company = $controllerData['company'];
?>

<!DOCTYPE html>
<html lang="ru-Ru" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Редактировать компанию</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>
<body>
<div class="page__layout">
    <?php include_view('/admin/adminMenu.php'); ?>
    <div class="content">
        <div class="block">
            <h1 class="block__title">Редактировать компанию "<?= $company['name'] ?>"</h1>
            <?php include_view('/includes/adminMessageBar.php'); ?>
            <div class="login__error"></div>
            <form method="post" action="/admin/company/update.php" id="edit-company" class="create"
                  enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $company['id'] ?>" data-check="true">
                <input type="hidden" name="hash" value="<?= substr(md5($company['id']), 0, 8) ?>" data-check="true">
                <div class="create__item">
                    <p>
                        <span>Название компании</span>
                        <input type="text" name="name" value="<?= $company['name'] ?>" data-check="true">
                    </p>
                    <p>
                        <span>Контактный номер</span>
                        <input type="text" name="phone" value="<?= $company['phone'] ?>" data-check="true">
                    </p>
                    <p>
                        <span>Сайт компании</span>
                        <input type="text" name="sity" value="<?= $company['sity'] ?>" data-check="true">
                    </p>
                    <p>
                        <span>E-mail компании</span>
                        <input type="text" name="email" value="<?= $company['email'] ?>" data-check="true">
                    </p>
                    <p>
                        <span>Позиция</span>
                        <select class="width-auto" id="position" name="position">
                            <option value="0" <?php echo $company['position'] === 0 ? 'selected' : ''; ?> >По
                                умолчанию
                            </option>
                            <option value="1" <?php echo $company['position'] === 1 ? 'selected' : ''; ?>>Первое(1)
                                место
                            </option>
                            <option value="2" <?php echo $company['position'] === 2 ? 'selected' : ''; ?>>Второе(2)
                                место
                            </option>
                            <option value="3" <?php echo $company['position'] === 3 ? 'selected' : ''; ?>>Третье(3)
                                место
                            </option>
                            <option value="4" <?php echo $company['position'] === 4 ? 'selected' : ''; ?>>Четвёртое(4)
                                место
                            </option>
                            <option value="5" <?php echo $company['position'] === 5 ? 'selected' : ''; ?>>Пятое(5) место
                            </option>
                            <option value="6" <?php echo $company['position'] === 6 ? 'selected' : ''; ?>>Шестое(6)
                                место
                            </option>
                            <option value="7" <?php echo $company['position'] === 7 ? 'selected' : ''; ?>>Седьмое(7)
                                место
                            </option>
                            <option value="8" <?php echo $company['position'] === 8 ? 'selected' : ''; ?>>Восьмое(8)
                                место
                            </option>
                            <option value="9" <?php echo $company['position'] === 9 ? 'selected' : ''; ?>>Девятое(9)
                                место
                            </option>
                            <option value="10" <?php echo $company['position'] === 10 ? 'selected' : ''; ?>>Десятое(10)
                                место
                            </option>

                        </select>
                    </p>
                    <p>
                        <span>Город</span>
                        <select class="width-auto" id="city" name="city" data-check="true">
                            <option value="1" <? echo $company['sity'] == 1 ? 'selected' : ''; ?> >Москва и Московская
                                обл.
                            </option>
                            <option value="2" <? echo $company['sity'] == 2 ? 'selected' : ''; ?>>Тула и Тульская обл.
                            </option>
                            <option value="3" <? echo $company['sity'] == 3 ? 'selected' : ''; ?>>Республика
                                Крым
                            </option>
                        </select>
                    </p>
                    <p>
                        <span>Адрес офиса</span>
                        <input type="text" name="address" value="<?= $company['address'] ?>" data-check="true">
                    </p>
                    <p>
                        <span>Место нахождения офиса</span>
                    <div id="map" class="map"></div>
                    <input type="hidden" name="map" value="<?= $company['map'] ?>" data-check="true">
                    </p>
                    <p class="checkbox_wraper">
                        <label class="label--checkbox">
                            <input type="hidden" name="dev" value="0">
                            <input type='checkbox' value="1" class="checkbox" name="dev" <?= $company['dev'] == 1 ?
                                "checked" :
                                ""; ?>/>
                            В разработке
                        </label>
                    </p>
                </div>
                <div class="create__item" style="padding-left:25px;">
                    <p>
                        <span>Дата основания компании(DD.MM.YYYY)</span>
                        <input type="text" name="data" value="<?= date('d.m.Y', $company['data']) ?>" data-check="true">
                    </p>
                    <p>
                        <span>ИНН</span>
                        <input type="text" name="inn" value="<?= $company['inn'] ?>">
                    </p>
                    <p>
                        <span>Логотип компании</span>
                        <input type="file" name="file" id="create__file" accept=".jpg, .jpeg, .png" value="1" />
                    </p>
                    <p>
                        <span>Facebook(Ссылка)</span>
                        <input type="text" name="fb" value="<?= $company['fb'] ?>">
                    </p>
                    <p>
                        <span>Однокласники(Ссылка)</span>
                        <input type="text" name="ok" value="<?= $company['ok'] ?>">
                    </p>
                    <p>
                        <span>Вконтакте(Ссылка)</span>
                        <input type="text" name="vk" value="<?= $company['vk'] ?>">
                    </p>
                    <p>
                        <span>WhatsApp(сылка)</span>
                        <input type="text" name="wa" value="<?= $company['wa'] ?>">
                    </p>
                    <p>
                        <span>Viber(сылка)</span>
                        <input type="text" name="vb" value="<?= $company['tw'] ?>">
                    </p>
                    <p>
                        <span>Telegram(сылка)</span>
                        <input type="text" name="tg" value="<?= $company['tg'] ?>">
                    </p>
                    <p>
                        <span>Twitter(Ссылка)</span>
                        <input type="text" name="tw" value="<?= $company['tw'] ?>">
                    </p>
                    <p>
                        <span>Instagram(ник)</span>
                        <input type="text" name="ins" value="<?= $company['ins'] ?>">
                    </p>
                    <p>
                        <span>Youtube(Ссылка)</span>
                        <input type="text" name="yb" value="<?= $company['yb'] ?>">
                    </p>
                </div>
                <p style="display:block; order:4; width:100%; margin-left:30px;">
                    <span>Описание</span>
                    <textarea name="description" data-check="true"
                              class="edit-input__text"><?= $company['description'] ?></textarea>
                </p>
                <input type="submit" name="" value="Сохранить" class="submit">
            </form>
        </div>
    </div>
</div>
<script src="/js/trumbowyg.min.js"></script>
<script src="/js/trumbowyg.upload.min.js"></script>
<script src="/js/ru.js"></script>
<script>
    $('.edit-input__text').trumbowyg({
        lang: 'ru',
        svgPath: '../images/icons.svg',
        btnsDef: {
            // Create a new dropdown
            image: {
                dropdown: ['insertImage', 'upload'],
                ico: 'insertImage'
            }
        },
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['image'], // Our fresh created dropdown
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        plugins: {
            // Add imagur parameters to upload plugin for demo purposes
            upload: {
                serverPath: 'https://api.imgur.com/3/image',
                fileFieldName: 'image',
                headers: {
                    'Authorization': 'Client-ID fecead0231558d7'
                },
                urlPropertyName: 'data.link'
            }
        }
    });
</script>
<script src="https://api-maps.yandex.ru/2.1/?apikey=a6da9518-c21f-41f1-80f6-8fb6ae90ea25&lang=ru_RU"
        type="text/javascript"></script>
<script src="/js/formstyler.js"></script>
<script src="/js/maps.js"></script>
<script> ymaps.ready(adminMap([<?=$company['map']?>], 17, 'point')); </script>
<script src="/js/admin.js"></script>
</body>
</html>
