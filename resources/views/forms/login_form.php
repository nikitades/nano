<div class="row">
    <div class="col-md-6">
        <form action="/login" method="POST">
            <div class="form-group">
                <label for="email">Адрес электронной почты:</label>
                <input name="email" type="email" class="form-control" id="email" value="<?= !empty($data['email']) ? $data['email'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="pwd">Пароль:</label>
                <input name="password" type="password" class="form-control" id="pwd">
            </div>
            <div class="checkbox">
                <label><input type="checkbox" name="remember" <?= !empty($data['remember']) ? 'checked="checked"' : '' ?>> Запомнить</label>
            </div>
            <button type="submit" class="btn btn-default">Отправить</button>
            <a href="/register" target="_blank" class="btn btn-link">Зарегистрироваться</a>
        </form>
    </div>
</div>