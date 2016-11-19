<form action="/postComment/<?= $post->id ?>" method="POST">
    <? if (User::checkAuth()) { ?>
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" class="form-control" id="name" disabled="disabled"
                   value="<?= User::current()->name ?>">
        </div>
    <? } else { ?>
        <div class="form-group">
            <label for="name">Имя:</label>
            <input name="name" type="text" class="form-control" id="name"
                   value="<?= !empty($data['name']) ? $data['name'] : '' ?>">
        </div>
    <? } ?>
    <div class="form-group">
        <textarea class="form-control" name="text" id="text" rows="10"></textarea>
    </div>
    <button type="submit" class="btn btn-default">Отправить</button>
</form>