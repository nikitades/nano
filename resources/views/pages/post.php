<? nanolink('blocks.head', ['title' => $post->name]) ?>
<body>
<? nanolink('blocks.header') ?>
<div class="container">
    <div class="row">
        <? nanolink('blocks.breadcrumbs', [
            'breadcrumbs' => [
                '/' => 'Главная',
                $post->id => $post->name
            ]
        ]) ?>
        <div class="posts_list buffer">
            <div class="page-header">
                <h1><?= $post->name ?></h1>
            </div>
            <div class="post-content buffer">
                <?= $post->content ?>
            </div>
            <hr>
            <div class="post-commentaries buffer-top">
                <h3>Комментарии</h3>
                <? Flash::display(); ?>
                <? nanolink('forms.comment_form', ['data' => Flash::data()]) ?>
                <div class="buffer">
                    <? foreach ($post->comments as $comment) nanolink('blocks.post-comment', ['comment' => $comment]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
