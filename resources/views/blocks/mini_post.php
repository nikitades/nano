<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><a href="<?= $post->url() ?>"><?= escape($post->name) ?></a></h3>
    </div>
    <div class="panel-body">
        <?= safe($post->announce) ?>
    </div>
    <div class="panel-footer"><a href="<?= $post->url() ?>" class="btn btn-info btn-xs">Читать</a></div>
</div>