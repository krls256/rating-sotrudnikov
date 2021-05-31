<!--need $request-->
<!--need $companies-->
<form action="" method="get" class="review-form">
    <div class="d-flex align-items-end justify-content-between">
        <div class="form-group mb-0 mr-2">
            <label for="company_id">Компания</label>
            <select name="company_id" id="company_id" class="form-control">
                <option value="">Не указано</option>
                <?php
                    foreach ($companies as $company) {
                        $id = $company->id;
                        $name = $company->name;
                        $selected = ((int) $request->get('company_id')) === $id ? 'selected' : '';
                        echo "<option value='$id' $selected >$name</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group mb-0 mr-2">
            <label for="review_source">Источник</label>
            <select name="review_source" id="review_source" class="form-control">
                <option value="">Не указано</option>
                <?php
                foreach (\app\Models\Review::source()->all() as $src) {

                    $name = \app\Models\Review::source()->russianName($src);
                    $selected = $request->get('review_source') === $src ? 'selected' : '';
                    echo "<option value='$src' $selected >$name</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group mb-0 mr-2">
            <label for="is_positive">Позитивный/Негативный</label>
            <select name="is_positive" id="is_positive" class="form-control">
                <option value="">Не указано</option>
                <option value="1" <?php if($request->get('is_positive') === '1') echo 'selected'?>>Позитивные</option>
                <option value="0" <?php if($request->get('is_positive') === '0') echo 'selected'?>>Негативные</option>
            </select>
        </div>
        <div class="form-group mb-0 mr-2">
            <label for="is_published">Публикация</label>
            <select name="is_published" id="is_published" class="form-control">
                <option value="">Не указано</option>
                <option value="1" <?php if($request->get('is_published') === '1') echo
                'selected'?>>Опубликованные</option>
                <option value="0" <?php if($request->get('is_published') === '0') echo 'selected'?>>Не
                    опубликованные</option>
            </select>
        </div>
        <div class="form-group mb-0 mr-2">
            <label for="is_moderated">Модерация</label>
            <select name="is_moderated" id="is_moderated" class="form-control">
                <option value="">Не указано</option>
                <option value="1" <?php if($request->get('is_moderated') === '1') echo
                'selected'?>>Прошел модерацию</option>
                <option value="0" <?php if($request->get('is_moderated') === '0') echo 'selected'?>
                >Не прошел модерацию</option>
            </select>
        </div>
        <button class="btn btn-info">Применить</button>
    </div>
</form>
