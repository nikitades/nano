<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?
                $time = (time() - strtotime($comment->created_at)) / 60;
                switch (true) {
                    case (($t = floor($time)) < 60):
                        $time_phrase = "{$t} минут";
                        break;
                    case ($t = floor($time / 60)) < 24:
                        $time_phrase = "{$t} часов";
                        break;
                    case ($t = floor($time / 60 / 24)) < 7:
                        $time_phrase = "{$t} дней";
                        break;
                    default:
                        $time_phrase = "миллион лет";
                        break;
                }
                ?>
                <strong><?= !empty($comment->user) ? $comment->user->name : 'Аноним' ?></strong> <span
                    class="text-muted"><?= $time_phrase ?> назад</span>
            </div>
            <div class="panel-body">
                <div><?= $comment->text ?></div>
            </div>
        </div>
    </div>
</div>