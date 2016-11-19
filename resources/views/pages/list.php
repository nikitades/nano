<? nanolink('blocks.head') ?>
<? nanolink('blocks.header') ?>
<div class="container">
   <div class="row">
       <? nanolink('blocks.breadcrumbs', [
           'breadcrumbs' => [
               '/' => 'Главная'
           ]
       ]) ?>
       <div class="posts_list buffer">
           <? foreach ($posts_list as $post) { nanolink('blocks.mini_post', ['post' => $post]); } ?>
       </div>
   </div>
</div>
<? nanolink('blocks.footer') ?>
