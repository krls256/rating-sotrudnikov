<form action="" method="get" class="review-form">
    <div class="d-flex align-items-end">
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
            <label for="sort_by">Сортировка</label>
            <select name="sort_by" id="sort_by" class="form-control">
                <option value="asc" <?php if($request->get('sort_by') === 'asc') echo
                'selected'?>>По возрастанию</option>
                <option value="desc" <?php if($request->get('sort_by') === 'desc') echo
                'selected'?>>По убыванию</option>
            </select>
        </div>
        <button class="btn btn-info">Применить</button>
    </div>
</form>
