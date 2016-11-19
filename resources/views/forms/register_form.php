<form action="/register" method="POST">
    <div class="form-group">
        <label for="name">Имя:</label>
        <input name="name" type="text" class="form-control" id="name" value="<?= !empty($data['name']) ? $data['name'] : '' ?>">
    </div>
    <div class="form-group">
        <label for="email">Адрес электронной почты:</label>
        <input name="email" type="email" class="form-control" id="email" value="<?= !empty($data['email']) ? $data['email'] : '' ?>">
    </div>
    <div class="form-group">
        <label for="pwd">Пароль:</label>
        <input name="password" type="password" class="form-control" id="pwd">
    </div>
    <button type="submit" class="btn btn-default">Отправить</button>
    <a href="/login" class="btn btn-link">Войти</a>
</form>