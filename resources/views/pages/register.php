<? nanolink('blocks.head', ['title' => 'Регистрация']) ?>
<body>
<? nanolink('blocks.header') ?>
<div class="container">
    <div class="row">
        <? nanolink('blocks.breadcrumbs', [
            'breadcrumbs' => [
                '/' => 'Главная',
                '/register' => 'Регистрация'
            ]
        ]) ?>
        <div class="row">
            <div class="col-md-6">
                <? Flash::display() ?>
                <? nanolink('forms.register_form', ['data' => Flash::data()]) ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
