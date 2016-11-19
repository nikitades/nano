<? nanolink('blocks.head', ['title' => 'Добавление поста']) ?>
<body>
<? nanolink('blocks.header') ?>
<div class="container">
    <div class="row">
        <? nanolink('blocks.breadcrumbs', [
            'breadcrumbs' => [
                '/' => 'Главная',
                '/post' => 'Добавление поста'
            ]
        ]) ?>
        <div class="post-form">
            <? Flash::display() ?>
            <? if (User::checkAuth()) { ?>
                <? nanolink('forms.post_form', ['data' => Flash::data()]) ?>
            <? } else { ?>
                <? nanolink('blocks.notification', ['type' => 'warning', 'text' => 'Пожалуйста, авторизуйтесь, чтобы оставлять посты.']) ?>
            <? } ?>
        </div>
    </div>
</div>
</body>
</html>
