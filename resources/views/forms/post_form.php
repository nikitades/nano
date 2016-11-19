<div class="row">
    <div class="col-xs-12">
        <form action="/post" method="POST">
            <div class="form-group">
                <label for="name">Название:</label>
                <input name="name" type="text" class="form-control" id="name"
                       value="<?= !empty($data['name']) ? $data['name'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="announce">Анонс:</label>
                <textarea class="form-control" name="announce" rows="3"
                          id="announce"><?= !empty($data['announce']) ? $data['announce'] : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="content">Содержание:</label>
                <textarea class="form-control" name="content" rows="10"
                          id="content"><?= !empty($data['content']) ? $data['content'] : '' ?></textarea>
            </div>
            <button type="submit" class="btn btn-default">Отправить</button>
        </form>
    </div>
</div>