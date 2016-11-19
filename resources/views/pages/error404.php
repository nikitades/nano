<? nanolink('blocks.head') ?>
<body>
<? nanolink('blocks.header') ?>
<div class="container">
    <div class="row">
        <? nanolink('blocks.breadcrumbs', [
            'breadcrumbs' => [
                '/' => 'Главная',
                'javascript: void(0)' => 'Страница не найдена'
            ]
        ]) ?>
        <div class="posts_list buffer">
            <div class="alert alert-warning" role="alert">Страница не найдена!</div>
        </div>
    </div>
</div>
</body>
</html>
