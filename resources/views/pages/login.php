<? nanolink('blocks.head', ['title' => 'Авторизация']) ?>
<body>
<? nanolink('blocks.header') ?>
<div class="container">
    <div class="row">
        <? nanolink('blocks.breadcrumbs', [
            'breadcrumbs' => [
                '/' => 'Главная',
                '/login' => 'Авторизация'
            ]
        ]) ?>
        <? Flash::display() ?>
        <? nanolink('forms.login_form', ['data' => Flash::data()]) ?>
    </div>
</div>
</body>
</html>
