<? nanolink('blocks.head', ['title' => 'Регистрация']) ?>
<? nanolink('blocks.header') ?>
<div class="container">
    <div class="row">
        <? nanolink('blocks.breadcrumbs', [
            'breadcrumbs' => [
                '/' => 'Главная',
                '/register' => 'Регистрация'
            ]
        ]) ?>
        <? Flash::display() ?>
        <? if (User::checkAuth()) { ?>
            <? nanolink('blocks.notification', ['type' => 'success', 'text' => 'Вы уже авторизованы!']) ?>
        <? } else { ?>
            <? nanolink('forms.register_form', ['data' => Flash::data()]) ?>
        <? } ?>
    </div>
</div>
<? nanolink('blocks.footer') ?>